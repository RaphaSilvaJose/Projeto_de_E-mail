<?php
class Controller extends AppController {
    function email($User_id = null, $curriculo_id = null) {
        //carregando o model
        $result =  null;
        $this->loadModel('email');
        $this->email->recursive = -1;

        //buscando os dados do banco
        $result = $this->email->find('all', array(
            'fields' => array('email.User_id','email.to','email.from','email.created','email.text','email.id','email.curriculo_id'),
            'conditions' => array( 'email.User_id' => $User_id ,'email.curriculo_id' => $dado_id ),
            'order' => array('email.created' => 'asc')
        ));
        
        //enviando para view
        $this->set('result',$result);
        
        
    }
    
}