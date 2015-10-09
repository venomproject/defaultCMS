<?php
class BodyContent extends TTemplateControl {
	public $title;
	public $keywords;
	public $description;
	public $LangCode = 'pl';
	public $SliderImg = '';
	public $StaticPhrase = array();

	public function onLoad($param) {
		$this->title = '';
		$this->keywords = '';
		$this->description = '';
		
		
		$baseMethod = new BaseFunction ();
		$langID = $baseMethod->getShortLang ();
		$this->LangCode = $baseMethod->getShortLang ();
		
		switch ($this->getPage ()->getPagePath ()) {
			case 'Home' :
				$seo = PagesRecord::finder ()->findByID_AND_LangCode ( 1, $langID );
				$this->title = $seo->Name;
				$this->keywords = $seo->MetaKeywords;
				$this->description = $seo->MetaDescription;
				break;
			case 'Pages' :
				$seo = PagesRecord::finder ()->findByID_AND_LangCode ( $this->getRequest ()->itemAt ( "id" ),$langID 
				);
				$this->title = $seo->Name;
				$this->keywords = $seo->MetaKeywords;
				$this->description = $seo->MetaDescription;
				break;
			default :
				break;
		}
		
		$phrase = SettingsRecord::finder ()->findAllByLanguageID(1);
		foreach ($phrase as $key => $value){
			$this->StaticPhrase[$value->Key] = $value->Value;
		}

		$this->Footer->DataSource = PagesRecord::finder ()->findAll ( 'ShowFooter = 1 ORDER BY Position ' );
		$this->Footer->dataBind ();
	}
	
	public function searchcFuntion($sender, $param) {
		
		$this->Response->redirect ($this->Service->constructUrl ( "Search", array('id'=> $this->SearchPhrase->Text) ));
	}


	public function changeLanguage($sender, $param) {
		$globalization = $this->getApplication ()->getGlobalization ();
		$globalization->setCulture ( $param->getCommandParameter () );
		$this->Response->redirect ( $this->Service->constructUrl ( "Home" ) );
	}

	public function onInit($param) {

	
	
		if($this->getRequest ()->itemAt ( "id" ) == 8 && $this->getPage()->getPagePath() == 'Pages' ){
			$this->Response->redirect ($this->Service->constructUrl ( "Contact") );
		}
		
		if($this->getRequest ()->itemAt ( "id" ) == 4 && $this->getPage()->getPagePath() == 'Pages' ){
			$this->Response->redirect ($this->Service->constructUrl ( "Category") );
		}
		
		if($this->getRequest ()->itemAt ( "id" ) == 13 && $this->getPage()->getPagePath() == 'Pages' ){
			$this->Response->redirect ($this->Service->constructUrl ( "Gallery") );
		}
	
	/*
		if($this->getRequest ()->itemAt ( "id" ) == 5 && $this->getPage()->getPagePath() == 'Pages' ){
			$this->Response->redirect ($this->Service->constructUrl ( "Team", array('id'=> $this->getRequest ()->itemAt ( "id" )) ));
		}
		
		if($this->getRequest ()->itemAt ( "id" ) == 6 && $this->getPage()->getPagePath() == 'Pages' ){
			$this->Response->redirect ($this->Service->constructUrl ( "Team", array('id'=> $this->getRequest ()->itemAt ( "id" )) ));
		}
		
		*/
/*	
		if (strstr ( $_SERVER ['PHP_SELF'], "UserFiles" ) !== False) {
			
			$this->Response->redirect ( 'http://www.' . $_SERVER ["SERVER_NAME"] . $_SERVER ['PATH_INFO'] );
		}
		
		
		
		
	
		
		if($this->getRequest ()->itemAt ( "id" ) == 9){
			$this->Response->redirect ($this->Service->constructUrl ( "Media" ));
		}
	*/	
	}
}
?>
