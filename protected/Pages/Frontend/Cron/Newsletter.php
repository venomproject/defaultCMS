<?php
class Newsletter extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$checkNewsletter = nNewsletterRecord::finder ()->findByStatus ( 1 );
		$layout = nLayoutRecord::finder ()->findBy_nNewsletterID ( $checkNewsletter->ID );
		
		$subject = $checkNewsletter->Name;
		$from = 'test@vp.d2.pl';
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . $from . "\r\n" . 

		'Reply-To: ' . $from . "\r\n" . 

		'X-Mailer: PHP/' . phpversion ();
		$message = '<html><body>';
		
		$lista = nSenderRecord::finder ()->findAll ( 'nLayoutID = ? AND Status = 0 LIMIT 1', $layout->ID );
		foreach ( $lista as $person ) {
			
			$to = $person->Email;
			
			$message .= $layout->HtmlText;
			$message .= '</body></html>';
			
			if (mail ( $to, $subject, $message, $headers )) {
				
				$person->Status = 1;
				$person->save ();
			} else {
				
				$person->Status = 5;
				$person->save ();
			}
		}
		
		if (empty ( $lista )) {
			$checkNewsletter->Status = 0;
			$checkNewsletter->save ();
		}
	}
}
?>