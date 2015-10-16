<?php
class Index extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->staticPage = SliderRecord::finder ()->findByPk ( $this->getRequest ()->itemAt ( "id" ) );
		
		if ($this->getRequest ()->contains ( "id" ) == true && isset ( $this->staticPage ) == true) {
			
			if (! $this->getPage ()->IsPostBack) {
				TPropertyValue::ensureString ( $this->Name->setText ( $this->staticPage->Name ) );
				TPropertyValue::ensureString ( $this->Description->setText ( $this->staticPage->Description ) );
			}
		} else {
			$this->Response->redirect ( $this->Service->constructUrl ( "Slider.Add" ) );
		}
		
		if (! is_dir ( Prado::getPathOfAlias ( 'UserFiles' ) . '/Slider/' )) {
			$dirun = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
			mkdir ( $dirun->path . '/Slider/', 0775 );
			$dirun->close ();
		}
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			
			$finder = SliderRecord::finder ();
			$finder->DbConnection->Active = true;
			$transaction = $finder->DbConnection->beginTransaction ();
			try {
				$rows = $finder->findByID ( $this->getRequest ()->itemAt ( "id" ) );
				$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
				$rows->Description = TPropertyValue::ensureString ( $this->Description->getText () );
				$rows->save ();
				
				$baseMethod = new BaseFunction ();
				$d = dir ( $baseMethod->UploadFilePath );
				while ( $entry = $d->read () ) {
					if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
						$namePhoto = strtolower ( $entry );
						
						$rowPhoto = SliderRecord::finder ()->findByID ( $this->getRequest ()->itemAt ( "id" ) );
						$rowPhoto->Photo = $namePhoto;
						$rowPhoto->save ();
						
						copy ( $baseMethod->UploadFilePath . $entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Slider/' . $namePhoto ) or die ( "Błąd przy kopiowaniu" );
					}
				}
				$d->close ();
				
				$transaction->commit ();
				
				$this->Response->redirect ( $this->Service->constructUrl ( "Slider.Index", array (
						"id" => $this->getRequest ()->itemAt ( "id" ) 
				) ) );
			} catch ( Exception $e ) {
				$transaction->rollBack ();
				die ();
			}
		}
	}
}
?>