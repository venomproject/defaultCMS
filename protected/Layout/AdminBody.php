<?php
class AdminBody extends TTemplateControl {
	public $PageName;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->PageName->Name = "Strona powitalna";
		// echo '<h1 style="color:red;text-align:center;">Trwa modyfikacja</h1>';
	}
	public function onInit($param) {
		
		/* echo $this->getPage ()->getPagePath ();
		
		if ($this->getPage ()->getPagePath () == 'Pages.Index' || $this->getPage ()->getPagePath () == 'Pages.Add') {
			echo 'inna';
		} else {
			echo 'dobra';
		}
		
		die (); */
		/*
		 * if (
		 * $this->getPage ()->getPagePath () != 'Pages.Index' ||
		 * $this->getPage ()->getPagePath () == 'Pages.Add' && $this->getRequest ()->itemAt ( "id" ) != $this->User->PagesID) {
		 * $this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
		 * 'id' => $this->User->PagesID
		 * ) ) );
		 * }
		 */
	}
}
?>
