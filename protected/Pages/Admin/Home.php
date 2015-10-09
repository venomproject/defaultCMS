<?php
class Home extends TPage
{
	
	public function onLoad($param) {
		
		if($this->User->PagesID >  0){
			$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Oddzial" ) );
		}
		
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Data" ) );
	}
}
?>