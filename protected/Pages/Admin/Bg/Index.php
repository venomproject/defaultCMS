<?php
class Index extends TPage {
	public $staticPage;
	public function onLoad($param) {
		parent::onLoad ( $param );
	}
	
	public function editRow($sender, $param) {
		$baseMethod = new BaseFunction ();
		$d = dir ( $baseMethod->UploadFilePath );
		while ( $entry = $d->read () ) {
			if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
				$male = strtolower($entry);
				
				if(file_exists (Prado::getPathOfAlias ( 'UserFiles' ) . '/Bg/'.$male )){
				unlink ( Prado::getPathOfAlias ( 'UserFiles' ) . '/Bg/'.$male );				
				}
				
				copy ( $baseMethod->UploadFilePath . $entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Bg/' . $male ) or die ( "Błąd przy kopiowaniu" );
				$rows->Photo = $entry;
			}
		}
		$d->close ();
	}
}
?>