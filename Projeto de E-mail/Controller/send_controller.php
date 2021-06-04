<?php
class SendController extends AppController {

	function enviarEmail(){
			$smtpconf = new SmtpconfComponent();
			$smtpOptions = $smtpconf->returnSmtpOptions($this->params['parametros_email']['email']);
			if($_SERVER['SERVER_NAME'] == 'localhost') {
				$this->Email->to = "raphael@email.com.br";
			} else {
				$this->Email->to = $this->params['parametros_email']['email'];
			}			
			$this->Email->subject = $assunto;
			$this->Email->from = 'nao-responder@email.me';
			$this->Email->template = $this->params['parametros_email']['template'];
			$this->Email->sendAs = 'html';
			if(!empty($this->params['parametros_email']['anexos'])){
				$this->Email->attachments = array($this->params['parametros_email']['anexos']);
			}
			
			$this->Email->smtpOptions = $smtpOptions;
			$this->Email->delivery = 'smtp';
			$params_layout['texto'] = nl2br($params_layout['texto']);
			
			if(count($params_layout) > 0){
				foreach ($params_layout as $key => $value) {
					$this->set($key, $value);
				}
			}
		}
	
	/*
	**************************************************
	E-mail Envio Mensagens E-mail
	**************************************************
	*/
	function envio_email(){
		
        //Layout do email
		//$id_layout = $this->params['post']['id_layout'];

        //Recebendo os dados
        $from = $this->params['email']['from'];
        $to = $this->params['email']['to'];
        $data = $this->params['email']['data'];
        $user = $this->params['email']['user'];
        $id = $this->params['email']['id'];
        

        //Montando e enviando o email
			

            //Carregar dados do banco	
            $this->loadModel('Recebidos');
            $this->loadModel('id');
            $this->id->recursive = 1;
 
             if(!empty($data)):
            
            //Enviando email
             $this->requestAction('Envios/enviarEmail/', 
				array(
					'parametros_email' => array(
						'email' => $from,
						'assunto' => 'User '.$to,
						'titulo' => 'User '.$to,
						'texto' => $data,
                        'id_layout' => $id_layout
					) 
				) 
			);	

                
                //Salvar no banco
                $arr['from'] = $from;
                $arr['to'] = $to;
                $arr['text'] = $data;
                $arr['assunto'] = $to;
                $arr['User_id'] = $to;
                $arr['dado_id'] = $dado_id;
                $arr['user_id'] = $user;
                

                $save = $this->Recebidos->save($arr);

    
            else:
                $this->log($id.': User não encontrado', 'emails_receive');
            endif;
	}

}