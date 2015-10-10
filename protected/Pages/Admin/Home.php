<?php
class Home extends TPage
{
	
	public function onLoad($param) {
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Data" ) );
	}
}
?>