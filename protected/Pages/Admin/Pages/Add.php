<?php
class Add extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->staticPage->Name = 'Nowa strona główna';
		if (! $this->getPage ()->IsPostBack) {
			$rows->ShowDate = $this->ShowDate->setText (date('d-m-Y')) ;
			$rows->TitleDate =  $this->TitleDate->setText (date('d-m-Y')) ;
		}
		
		if ($this->getRequest ()->contains ( "id" ) == true) {
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			$parentID = $this->getRequest ()->itemAt ( "id" );
			$this->staticPage = PagesRecord::finder ()->find ( 'ID = ? AND LanguageID = ?', $parentID, $langID );

			$m = $this->getRequest ()->itemAt ( "id" );
				
			if ($m != null) {
				do {
					$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
					$m = $b->PageID;
					$this->activeBreadcrumbs[$b->ID] = $b->Name;
				} while ( $m != null );
			}
			ksort($this->activeBreadcrumbs);
			
		} else {
		//	$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index" ,array("id" => 1)) );
		}
		
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			
			$rows = new PagesRecord ();
			$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
			
			if($this->User->PagesID == 0)
			$rows->PageID = $this->getRequest ()->itemAt ( "id" );
			else
				$rows->PageID = $this->User->PagesID;
			
			$rows->Description = TPropertyValue::ensureString ( $this->Description->getText ());
			$rows->ShortDescription = TPropertyValue::ensureString ( $this->ShortDescription->getText () );
			$rows->Seo = TPropertyValue::ensureString ( $this->Seo->getSafeText () );
			$rows->MetaKeywords = TPropertyValue::ensureString ( $this->MetaKeywords->getSafeText () );
			$rows->MetaDescription = TPropertyValue::ensureString ( $this->MetaDescription->getSafeText () );
			$rows->LanguageID = $langID;
			$rows->LangCode = CatalogueRecord::finder ()->find ( 'cat_id = ?', $langID )->ShortName;
			$rows->ShowDate = TPropertyValue::ensureString ( $this->ShowDate->getSafeText () );
			$rows->ShowDateDiff = strtotime($this->ShowDate->getSafeText ());
			$rows->TitleDate = TPropertyValue::ensureString ( $this->TitleDate->getSafeText () );
			
				$rows->ShowMenu =  $this->ShowMenu->getChecked ();
				$rows->ShowFooter =  $this->ShowFooter->getChecked ();
				$rows->ShowHome =  $this->ShowHome->getChecked ();
					if ($this->ShowHome->getChecked () == true){
						$rows->HideDate = TPropertyValue::ensureString ( $this->HideDate->getSafeText () );
						$rows->HideDateDiff = strtotime($this->HideDate->getSafeText ());
					}else{
						$rows->HideDate = null;
						$rows->HideDateDiff = 0;
					}
			
			
			
			
			$rows->save ();
 
			$pos = PagesRecord::finder ()->findByID ( $rows->ID );
			$pos->Position = 0;
			$pos->save ();
			
			
			if (! is_dir ( Prado::getPathOfAlias ( 'UserFiles' ) . '/Pages/' . $rows->ID )) {
				$dirun = dir ( Prado::getPathOfAlias ( 'UserFiles' ) );
				mkdir ( $dirun->path . '/Pages/'.$rows->ID, 0775 );
				mkdir ( $dirun->path . '/Pages/'.$rows->ID.'/thumb/', 0775 );
				$dirun->close ();
			}
			
			$baseMethod = new BaseFunction ();
			$d = dir ($baseMethod->UploadFilePath);
			while ( $entry = $d->read () ) {
				if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
					$namePhoto = strtolower($entry);
					$row = new FilesRecord ();
					$row->Name = $namePhoto;
					
					$row->IsParent = 0;
					if(FilesRecord::finder ()->count('PagesID = ? AND IsParent = 1', $rows->ID ) == 0){
						$row->IsParent = 1;
					}
					
					$row->Position = 999;
					$row->PagesID = $rows->ID;
					$row->save ();
			
					copy ( $baseMethod->UploadFilePath.$entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Pages/' . $rows->ID . '/' . $namePhoto ) or die ( "Błąd przy kopiowaniu" );
					$baseMethod->createThumb($namePhoto, Prado::getPathOfAlias ( 'UserFiles' ).'/Pages/'.$rows->ID.'/', $baseMethod->GlobalWidth );
				}
			}
			$d->close ();
			
			$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index" ,array("id" => $rows->ID)) );
		}
	}
	
	public function deleteItem($sender,$param)
	{
		PagesRecord::finder()->deleteByPk($this->PagesChildren->DataKeys[$param->Item->ItemIndex]);
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index" ,array("id" => 1)) );
	}
	
}
?>