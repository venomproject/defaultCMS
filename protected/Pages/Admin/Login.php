<?php
class Login extends TPage {
	public function onLoad($param) {
		if($this->User->Name == 'admin')
		$this->Response->redirect ( $this->Service->constructUrl ( "Home" ) );
	}
	public function validateUser($sender, $param) {
		$auth = $this->Application->Modules ['auth'];
		$param->IsValid = $auth->login ( $this->Username->Text, $this->Password->Text );
	}
	public function Login_Clicked($sender, $param) {
		if ($this->IsValid) {
			$url = $this->Application->Modules ['auth']->ReturnUrl;
			if (empty ( $url ))
				$url = $this->Service->DefaultPageUrl;
			$this->Response->redirect ( $url );
		}
	}
}
?>