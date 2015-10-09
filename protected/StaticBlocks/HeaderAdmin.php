<?php
class HeaderAdmin extends TTemplateControl {
	public function onLoad($param) {
		$this->LanguageList->DataSource = CatalogueRecord::finder ()->findAll ();
		$this->LanguageList->dataBind ();
		
		$session = Prado::getApplication ()->getSession ();
		if (!$session->itemAt ( 'jezyk' )) {
			$session->add ( 'jezyk', 1 );
		}
	}
	public function logout($sender, $param) {
		$this->Application->getModule ( 'auth' )->logout ();
		$this->Response->redirect ( $this->Service->constructUrl ( 'Home' ) );
	}
	
	public function changeLanguage($sender, $param) {
	
		$session = Prado::getApplication ()->getSession ();
		$session->add ( 'jezyk', $param->getCommandParameter() );
		
		$this->Response->redirect($this->Service->constructUrl("Home"));
	}
}
?>
