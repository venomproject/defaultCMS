<?php
class Add extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public function onLoad($param) {
		parent::onLoad ( $param );
		$this->staticPage->Name = 'Nowa strona główna';
		
		if (! is_dir ( Prado::getPathOfAlias ( 'UserFiles' ) . '/Slider/' )) {
			$dirun = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
			mkdir ( $dirun->path . '/Slider/', 0775 );
			$dirun->close ();
		}
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			
			$rows = new SliderRecord ();
			$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
			$rows->Description = TPropertyValue::ensureString ( $this->Description->getText () );
			$rows->save ();
			
			$baseMethod = new BaseFunction ();
			$d = dir ( $baseMethod->UploadFilePath );
			while ( $entry = $d->read () ) {
				if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
					$namePhoto = strtolower ( $entry );
					
					$rowPhoto = SliderRecord::finder ()->findByID ( $rows->ID );
					$rowPhoto->Photo = $namePhoto;
					$rowPhoto->save ();
					
					copy ( $baseMethod->UploadFilePath . $entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Slider/' . $namePhoto ) or die ( "Błąd przy kopiowaniu" );
				}
			}
			$d->close ();
			
			$this->Response->redirect ( $this->Service->constructUrl ( "Slider.Index", array (
					"id" => $rows->ID 
			) ) );
		}
	}
}
?>