<?php
class GalleryAdminBox extends TTemplateControl {
	
	public $pathName;
	
	public function onLoad($param) {
		parent::onLoad($param);

		if (! $this->getPage ()->IsPostBack) {
			$this->clearTempFile ();
		}

		$this->pathName = explode(".", $this->getPage()->getPagePath());
		
		if($this->pathName[1] == 'Index'){
			if (! is_dir ( Prado::getPathOfAlias ( 'UserFiles' ) . '/'.$this->pathName[0].'/' . $this->getRequest ()->itemAt ( "id" ) )) {
				$dirun = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
				mkdir ( $dirun->path . '/'.$this->pathName[0].'/' . $this->getRequest ()->itemAt ( "id" ), 0775 );
				mkdir ( $dirun->path . '/'.$this->pathName[0].'/' . $this->getRequest ()->itemAt ( "id" ).'/thumb/', 0775 );
				$dirun->close ();
			}
			
		
		$this->Files->DataSource = FilesRecord::finder ()->findAll ( $this->pathName[0].'ID = ? ORDER BY Position ASC ', $this->getRequest ()->itemAt ( "id" ) );
		
		}else{
			$this->Files->DataSource = array();
		}
		$this->Files->dataBind ();
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
	
	
	public function PositionPhoto($sender, $param) {
		if($this->pathName[1] == 'Index'){
			$i = 0;
			
			foreach ( $_POST as $row => $value) {
				
				if (( int ) $value == true && !is_array($value) && strstr($row, "Files")!==False) {
					$file = FilesRecord::finder()->findByID($value);
					$file->Position = $i;
					$file->save();
					
					$i ++;
				}
			}
		}
		$this->Response->redirect ( $this->Service->constructUrl ( $this->pathName[0].".Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );
	}
	
	public function fileDelete($sender, $param) {
		if($this->pathName[1] == 'Index'){
			FilesRecord::finder ()->deleteByID ( $param->CommandName );
			unlink ( Prado::getPathOfAlias ( 'UserFiles' ) . '/'.$this->pathName[0].'/' . $this->getRequest ()->itemAt ( "id" ) . '/' . $param->CommandParameter );
		}
		$this->Response->redirect ( $this->Service->constructUrl ( $this->pathName[0].".Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );
	}
	
	public function EditModal($sender, $param) {
		$row = FilesRecord::finder ()->findByID ( $this->IDSrc->Text );
		$row->Description = $this->DescriptionSrc->Text;
		$row->Url = $this->UrlSrc->Text;
		if($this->MasterSrc->Checked){

			$sql = "UPDATE `Files` SET `IsParent` = 0 WHERE `PagesID` = " . $this->getRequest ()->itemAt ( 'id' );
			$command = FilesRecord::finder ()->getDbConnection ()->createCommand ( $sql );
			$affectedRows = $command->execute ();
					
			$row->IsParent = 1;
		}
		$row->save();	

		$this->Response->redirect ( $this->Service->constructUrl ( $this->pathName[0].".Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );		
	}
}
?>
