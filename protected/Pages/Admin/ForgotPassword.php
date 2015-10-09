<?php
class ForgotPassword extends TPage {
	public function onInit($param) {
		parent::onInit ( $param );
		$this->Correct->Visible = false;
		$this->Error->Visible = false;
	}
	private function cryptPassword() {
		$baseMethod = new BaseFunction ();
		
		return UserRecord::finder ()->findByUsername_AND_Email ( $baseMethod->cryptString ( $this->Username->getSafeText () ), $baseMethod->cryptString ( $this->Email->getSafeText () ) );
	}
	public function forgot_Clicked($sender, $param) {
		if ($this->IsValid && $this->cryptPassword ()) {
			
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
			$headers .= "From: " . $_SERVER ['SERVER_ADMIN'] . "\r\n";
			$subject = "Przypomnienie hasła";
			
			$tresc = "\t\t\tWitaj ! 
			w celu zmiany hasła kliknij w poniższy link : 
			
			http://" . $_SERVER ['HTTP_HOST'] . $this->Service->constructUrl ( "ChangePassword", array (
					'hash' => $this->cryptPassword ()->Username 
			) ) . "
				
			Pozdrawiamy!";
			
			if (@mail ( $this->Email->Text, $subject, $tresc, $headers )) {
				$content = 'Wiadomość zostałą wysłana';
			} else
				$content = 'Wiadomość nie mogła zostać wysłana.';
			
			$this->Error->Visible = false;
			$this->Correct->Visible = true;
		} else {
			
			$this->Username->Text = null;
			$this->Email->Text = null;
			$this->Error->Visible = true;
		}
	}
}
?>