<?php

class emailsController extends AppController {

	var $name = 'emails';
    
	function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('receive');
	}
    
	function receive($tipo = 0) {
        //Entrada do Json

		// $inputJSON = file_get_contents('php://input');
		// $input = json_decode($inputJSON, TRUE); //convert JSON into array
		// debug($inputJSON);
		// debug($this->params);
		// debug($input);
		// debug(json_decode($this->data['form']['mandrill_events'],true));
        $json_entrada = json_decode($this->params['form']['mandrill_events'],true);
        // $this->log($inputJSON, 'emails_receive');
        // $this->log($this->data, 'emails_receive');
        $this->log($json_entrada, 'emails_receive');

        // die();
        // $json_entrada = json_decode(file_get_contents('../webroot/json_mandrill.json'),true);
        $data = new DateTime();
        unset($json_entrada[0]['msg']['raw_msg']);
        $ts = $json_entrada[0]['ts'];
        
        //navegando pelos arrays
        $ret['from_mail'] = $json_entrada[0]['msg']['from_e-mail'];
        $ret['to_mail'] = $json_entrada[0]['msg']['to'][0][0];
        $ret['text_mail'] = $json_entrada[0]['msg']['html'];
        $ret['assunto'] = $json_entrada[0]['msg']['subject'];
        $attachments = $json_entrada[0]['msg']['attachments'];
        
        //Converter Data TimeStamp
        $data->setTimeStamp($ts);
        $ret['data']= $data->format('Y-m-d H:i:s');

        $ret['anexos'] = [];
                
        //buscar anexos e conversão BASE64 do arquivo
        foreach ($attachments as $sigla => $anexo){
            $ret['anexos'][] = $anexo;
            $base64 = $anexo['content'];
            debug($base64);
            $dadosBin = base64_decode($base64);
            $hash = md5(rand(5,15) .$ret['data']);
            $type = explode(".", mb_decode_mimeheader($anexo['name']));

            $folderName = '../e-mail_recebido/';
            $filename = $hash .'.' .$type[sizeof($type)-1];
            $finishFileName = $folderName.$filename;
            // $filename = '../e-mail_recebido/'.$hash .'.' .$type[sizeof($type)-1];
            
            file_put_contents($finishFileName, $dadosBin);
            break;
        }
        
        //separando ID da user e-mail
        $user = explode("user",$ret['to_mail']);
        $userID = explode("@",$user[1]);
        $userID = $userID[0];
        //debug($attachments);

        //Carregar dados do banco
        $this->loadModel('user');
        $this->user->recursive = -1;
        $result = $this->user->read(array('user.id','user.titulo'), $userID);
        $this->log($result, 'emails_receive');
        $this->log($userID, 'emails_receive');
        $this->log(3, 'emails_receive');
        
        if(!empty($result['user']['id'])):
            
            //Salvar no banco
            $arr['created'] = $ret['data'];
            $arr['from'] = $ret['from_mail'];
            $arr['to'] = $ret['to_mail'];
            $arr['tipo'] = $tipo;
            $arr['text'] = $ret['text_mail'];
            $arr['user_id'] = $userID;
            $arr['dado_id'] = $result['user']['user_id'];
            $arr['assunto'] = $ret['assunto'];
            
            $save = $this->email->save($arr);

            $num_pis = $this->requestAction('/Users/postRChilli', array(
                'nome_arquivo' => $filename,
                'nome_pasta' => $folderName,
                'user_id' => $userID,
                'e-mail' => $arr['from']
                )
            );  
            $this->log('/users/postRChilli/'.$filename.'/'.$folderName.'/'.$userID.'/'.$arr['from'], 'emails_receive');
	
        else:
            $this->log($userID.': user não encontrada', 'emails_receive');
        endif;
        

        //debug($arr);
                
        die();
	}


    function recebidos_emails(){
        $this->autoRender = false;
        $array_data= $this->data;
        
        //Convertendo dados para array
        $encode= json_encode($array_data,true);
        $decode= json_decode($encode,true);
        
        $data= $decode['data'];
        $from=$decode['from'];
        $to=$decode['to'];
        $user=$decode['user'];
        $id=$decode['id'];

        //passando parametros para outra função
        $this->requestAction('Envios/Envio_email/', 
				array(
					'Envio_email' => array(
						'from' => $from,
						'to' => $to,
						'data' => $data,
                        'user' => $user,
                        'id' => $id
					) 
				) 
			);		
    }
    
}
