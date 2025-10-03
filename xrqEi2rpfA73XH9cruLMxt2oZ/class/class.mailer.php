<?php
	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');	
	include_once(INCLUDE_PATH.'class/class.parametro.php');	
	include_once(INCLUDE_PATH.'class/PHPMailerAutoload.php');
	include_once(INCLUDE_PATH.'class/Snoopy.class.php'); 


	class mailer extends DB {

		public function __construct(){
	    	$parametro 		= new parametro();
	    	$this->host 	= $parametro->getParametroByCodigo('EMAIL_SERVER');
			$this->port 	= $parametro->getParametroByCodigo('EMAIL_PUERTO');
	    	$this->user 	= $parametro->getParametroByCodigo('EMAIL_USER');
			$this->pass 	= $parametro->getParametroByCodigo('EMAIL_PASS');

			$this->name 	= $parametro->getParametroByCodigo('EMAIL_FROM');
			$this->from 	= $parametro->getParametroByCodigo('EMAIL_USER');

			$this->copia 	= $parametro->getParametroByCodigo('EMAIL_COPIA');
			$this->oculta 	= $parametro->getParametroByCodigo('EMAIL_OCULTA');

			$this->site 	= $parametro->getParametroByCodigo('RUTA_BASE');
			$this->admin 	= $parametro->getParametroByCodigo('RUTA_BASE_ADMIN');
			$this->plantilla= $parametro->getParametroByCodigo('RUTA_PLANTILLA');


	    }


	    public function mailMe($address, $from, $subject, $htmlBody){
	    	$mail = new PHPMailer();
	    	$mail->SetLanguage( 'es', INCLUDE_PATH.'class/language/' );
			$mail->IsSMTP();
			$mail->SMTPDebug 	= 0;
			$mail->CharSet 		= 'UTF-8';    
			$mail->Mailer 		= "smtp";
			$mail->Host 		= $this->host;
			$mail->Port 		= $this->port; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
			$mail->SMTPAuth 	= false;
			//$mail->SMTPSecure 	= 'tls';
			$mail->Username 	= $this->user;
			$mail->Password 	= $this->pass;
			    
			$mail->From     	= $this->from;
			$mail->FromName 	= $this->name;


			if (is_array($address)) {
				foreach($address as $mailAddress) {
					$mail->AddAddress($mailAddress); 
				}
			} else {
				$mail->AddAddress($address, $from);
			}
			//$mail->AddCC($this->oculta);
			$mail->AddCC($this->copia);
			
			$mail->WordWrap = 50;       
			$mail->IsHTML(true);                             
			
			$mail->Subject  =  $subject; 
			$mail->Body     =  $htmlBody;

			if(!$mail->Send()){
				echo "Message could not be sent. <p>";
				echo "Mailer Error: " . $mail->ErrorInfo;
				return false;
				exit;
			}else{
				return true;
			}
	    }


	    public function getContentHTML($url = false){
	    	if(empty($url)){
	    		$url = $this->plantilla."comodin.php";
	    	}else{
	    		$url = $this->plantilla.$url;
	    	}

	    	$snoopy = new Snoopy();
            $RESTString = $url;
            $snoopy->fetch($RESTString);
            return $snoopy->results;
        }

	}
?>