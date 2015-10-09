<?php
class Index extends TPage {
	public $staticPage;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		if ($this->getRequest ()->contains ( "id" ) == true) {
			
			if (! is_dir ( Prado::getPathOfAlias ( 'UserFiles' ) . '/Language/' . $this->getRequest ()->itemAt ( "id" ) )) {
				$dirun = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
				mkdir ( $dirun->path . '/Language/' . $this->getRequest ()->itemAt ( "id" ), 0775 );
				$dirun->close ();
			}
			
			$this->staticPage = CatalogueRecord::finder ()->find ( 'cat_id = ? ', $this->getRequest ()->itemAt ( "id" ) );
			if (! $this->getPage ()->IsPostBack) {
				TPropertyValue::ensureString ( $this->Name->setText ( $this->staticPage->MasterName ) );
				TPropertyValue::ensureString ( $this->ShortName->setText ( $this->staticPage->ShortName ) );
				
				$this->Language->DataSource = CatalogueRecord::finder ()->findAll ('Order By cat_id');
				$this->Language->dataBind ();
			}
		}
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			$finder = CatalogueRecord::finder ();
			$finder->DbConnection->Active = true;
			$transaction = $finder->DbConnection->beginTransaction ();
			try {
				$rows = $finder->findBycat_id ( $this->getRequest ()->itemAt ( "id" ) );
				$rows->MasterName = TPropertyValue::ensureString ( $this->Name->getSafeText () );
				$rows->ShortName = TPropertyValue::ensureString ( $this->ShortName->getSafeText () );
				
				$baseMethod = new BaseFunction ();
				$d = dir ( $baseMethod->UploadFilePath );
				while ( $entry = $d->read () ) {
					if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
						copy ( $baseMethod->UploadFilePath . $entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Language/' . $this->getRequest ()->itemAt ( "id" ) . '/' . $entry ) or die ( "Błąd przy kopiowaniu" );
						$rows->Photo = $entry;
					}
				}
				$d->close ();
				
				$rows->save ();
				$transaction->commit ();
				
				$this->Response->redirect ( $this->Service->constructUrl ( "Language.Index", array (
						"id" => $this->getRequest ()->itemAt ( "id" ) 
				) ) );
			} catch ( Exception $e ) {
				$transaction->rollBack ();
			}
		}
	}
	public function deleteItem($sender, $param) {
		if ($this->Language->DataKeys [$param->Item->ItemIndex] == 1) {
			echo 'Error : nie można usunąć domyslnego języka';
			die ();
		} else {
			PagesRecord::finder ()->deleteAllByLanguageID ( $this->Language->DataKeys [$param->Item->ItemIndex] );
			SettingsRecord::finder ()->deleteAllByLanguageID ( $this->Language->DataKeys [$param->Item->ItemIndex] );
			TransUnitRecord::finder ()->deleteAllBycat_id ( $this->Language->DataKeys [$param->Item->ItemIndex] );
			CatalogueRecord::finder ()->deleteBycat_id ( $this->Language->DataKeys [$param->Item->ItemIndex] );
			
			$session = Prado::getApplication ()->getSession ();
			$session->add ( 'jezyk', 1);
			
			$this->Response->redirect ( $this->Service->constructUrl ( "Home" ) );
		}
	}
}
?>