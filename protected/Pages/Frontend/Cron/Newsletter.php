<?php
Prado::using ( 'Lib.PHPMailer.PHPMailerAutoload' );
class Newsletter extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$checkNewsletter = nNewsletterRecord::finder ()->findByStatus ( 1 );
		if ($checkNewsletter) {
			
			$layout = nLayoutRecord::finder ()->findBy_nNewsletterID ( $checkNewsletter->ID );
			
			$mail = new PHPMailer ();
			$mail->isSendmail ();
			$mail->setFrom ( 'from@vp.d2.pl', 'First Last' );
			$mail->addReplyTo ( 'from@vp.d2.pl' );
			
			$lista = nSenderRecord::finder ()->findAll ( 'nLayoutID = ? AND Status = 0 LIMIT 25', $layout->ID );
			foreach ( $lista as $person ) {
				
				$mail->addAddress ( $person->Email );
				$mail->Subject = $checkNewsletter->Name;
				$mail->msgHTML ( $layout->HtmlText );
				
				if ($mail->send ()) {
					$person->Status = 1;
					$person->save ();
				} else {
					
					$person->Status = 5;
					$person->save ();
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
			}
			
			if (empty ( $lista )) {
				$checkNewsletter->Status = 0;
				$checkNewsletter->save ();
			}
		}
		die ();
	}
}
?>