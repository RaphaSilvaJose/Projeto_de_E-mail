<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="mail, email, conversation, mailbox">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <?php echo $html->css("/css/email.css"); ?>
    <?= $html->script("/js/email.js"); ?>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets_theadmin/img/apple-touch-icon.png">
    <link rel="icon" href="../assets_theadmin/img/favicon.png">
  </head>

  <body>

    <!-- caixa de rolagem da mensagens-->
    <div class="scrollable flex-grow" id="chat_">
    
        <!-- Main-content-->    
        <div class="main-content">

            <?php foreach($result as $ret) {?>
                
                <div class="card" id="autoscroll">
                <header class="card-header cursor-pointer" data-toggle="collapse" >
                    <div class="card-title flexbox">
                    <img class="avatar" src="<?php echo $this->webroot; ?>img/users/sem_foto.jpg" alt="...">
                    <div> 
                        <h6 class="mb-0" id="email_from">
                        <?php print_r($ret['email']['from'])  ?>
                        </h6>
                        <small><?php print_r(date('d/m/Y H:i', strtotime($ret['email']['created']))); ?></small>
                        <small><a class="text-info no-collapsing ml-1" href="#<?php print_r($ret['email']['id']) ?>" data-toggle="collapse">Detalhes</a></small>

                        <div class="collapse no-collapsing cursor-text" id="<?php print_r($ret['email']['id']) ?>">
                        <small class="d-inline-block w-40px mt-1">From:</small>
                        <small><?php print_r($ret['email']['from']) ?></small>
                        <br>
                        <small class="d-inline-block w-40px">To:</small>
                        <small><?php print_r($ret['email']['to']) ?></small>
                        </div>
                    </div>
                    </div>

                    <div class="dropdown">
                    <a class="text-lighter" data-toggle="dropdown" href="#"><i class="ti-more-alt rotate-90"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i class="fa fa-reply"></i> Responder</a>
                        <!--<a class="dropdown-item" href="#"><i class="fa fa-share"></i> Avançar</a>-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fa fa-print"></i> Imprimir</a>
                        <!--<a class="dropdown-item" href="#"><i class="fa fa-trash"></i> Apagar</a>-->
                    </div>
                    </div>
                </header>

                <div class="collapse show" id="email">
                    <div class="card-body">
                    <?php print_r($ret['email']['text'])?>
                    </div>
                </div>
        </div>

            <?php } ?>  
              <?php $vaga = explode("vaga",$ret['email']['to']);
                    $vagaID = explode("@",$vaga[1]);
                    $vagaID = $vagaID[0];?>
          <input class="d-none" type="text" id="from" value="<?php echo $ret['email']['from']?>" />
          <input class="d-none" type="text" id="to" Value="<?php echo $vagaID; ?>"/>  
    </div><!--/.scrollable -->
        
      </div><!--/.main-content -->

      <div class="divider fs-15">Responder</div>

      <!--caixa de digitação da mensagem-->
      <form>
            <div class="form-group" >
                <textarea id="textarea" type="text" style="position:fixed;" data-provide="summernote" data-min-height="120" data-max-height="120" ></textarea>
                </div>
            <button id="btn" type="button" class="btn btn-label btn-primary" style="position:absolute;top:55.0em;">
            <label> 
                <i class="ti-check"></i>
                    </label>Enviar</button>
        </form>
    
        <br>

  </body>
</html>
<!--  -->