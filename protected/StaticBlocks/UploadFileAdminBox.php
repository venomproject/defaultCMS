<?php
class UploadFileAdminBox extends TTemplateControl {
	
	public $pathName;
	
	public function onLoad($param) {
		parent::onLoad($param);
		if (! $this->getPage ()->IsPostBack) {
			$this->clearTempFile();
		}
	}
	
	public function clearTempFile() {
	
	
		$d = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
		while ( $entry = $d->read () ) {
			if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry )) {
				unlink ( Prado::getPathOfAlias ( 'UserFiles' ) . '/' . $entry );
			}
		}
		$d->close ();
	
		$f = dir ( 'themes/Admin/jQuery-File-Upload/server/php/files/' );
		while ( $entry = $f->read () ) {
			if (strlen ( $entry ) > 2 && is_file ( $f->path . '/' . $entry ) && $entry != '.htaccess') {
				unlink ( $f->path . '/' . $entry );
			}
		}
		$f->close ();
	
		$g = dir ( 'themes/Admin/jQuery-File-Upload/server/php/files/thumb/' );
		while ( $entry = $g->read () ) {
			if (strlen ( $entry ) > 2 && is_file ( $g->path . '/' . $entry ) && $entry != '.htaccess') {
				unlink ( $g->path . '/' . $entry );
			}
		}
		$g->close ();
	}
}
?>
