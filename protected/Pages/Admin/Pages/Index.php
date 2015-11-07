<?php
class Index extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		if ($this->getRequest ()->contains ( "kopiaId" )) {
			
			$clone = PagesRecord::finder ()->findByPk ( $this->getRequest ()->itemAt ( "kopiaId" ) );
			
			if (isset ( $clone )) {
				$rows = new PagesRecord ();
				$rows->Name = $clone->Name;
				$rows->ShortDescription = $clone->ShortDescription;
				$rows->Description = $clone->Description;
				
				$rows->LanguageID = $clone->LanguageID;
				$rows->LangCode = $clone->LangCode;
				$rows->Protected = 0;
				
				$rows->ShowMenu = 0;
				$rows->ShowFooter = 0;
				$rows->ShowHome = 0;
				$rows->HideDate = null;
				
				$rows->ShowDate = $clone->ShowDate;
				$rows->TitleDate = $clone->TitleDate;
				
				$rows->Seo = $clone->Seo;
				$rows->MetaKeywords = $clone->MetaKeywords;
				$rows->MetaDescription = $clone->MetaDescription;
				
				//$rows->PageID = $clone->PageID;
				$rows->Other = $clone->Other;
				$rows->Position = $clone->Position;
				
				$rows->save ();
				
				$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
						"id" => $rows->ID
				) ) );
			} else {
				$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Data" ) );
			}
		}
		
		$this->staticPage = PagesRecord::finder ()->findByPk ( $this->getRequest ()->itemAt ( "id" ) );
		
		if ($this->getRequest ()->contains ( "id" ) == true && isset ( $this->staticPage ) == true) {
			
			$m = $this->getRequest ()->itemAt ( "id" );
			
			if ($m != null) {
				do {
					$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
					$m = $b->PageID;
					$this->activeBreadcrumbs [$b->ID] = $b->Name;
				} while ( $m != null );
			}
			ksort ( $this->activeBreadcrumbs );
			
			
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			$parentID = $this->getRequest ()->itemAt ( "id" );
			
			if (! $this->getPage ()->IsPostBack) {
				
				TPropertyValue::ensureString ( $this->Name->setText ( $this->staticPage->Name ) );
				TPropertyValue::ensureString ( $this->ShowDate->setText ( $this->staticPage->ShowDate ) );
				TPropertyValue::ensureString ( $this->TitleDate->setText ( $this->staticPage->TitleDate ) );
				TPropertyValue::ensureString ( $this->Seo->setText ( $this->staticPage->Seo ) );
				TPropertyValue::ensureString ( $this->Description->setText ( $this->staticPage->Description ) );
				TPropertyValue::ensureString ( $this->ShortDescription->setText ( $this->staticPage->ShortDescription ) );
				TPropertyValue::ensureString ( $this->MetaKeywords->setText ( $this->staticPage->MetaKeywords ) );
				TPropertyValue::ensureString ( $this->MetaDescription->setText ( $this->staticPage->MetaDescription ) );
				
				$this->ShowMenu->setChecked ( $this->staticPage->ShowMenu );
				$this->ShowFooter->setChecked ( $this->staticPage->ShowFooter );
				$this->ShowHome->setChecked ( $this->staticPage->ShowHome );
				
				if ($this->staticPage->ShowHome == true)
					TPropertyValue::ensureString ( $this->HideDate->setText ( $this->staticPage->HideDate ) );
				
				$this->checkPosition ( $parentID, $langID );
				
				$this->PagesChildren->DataSource = PagesRecord::finder ()->findAll ( 'Protected = 0 AND PageID = ? AND LanguageID = ? ORDER BY Position', $parentID, $langID );
				$this->PagesChildren->dataBind ();
				
            $this->OtherPages->DataSource=PagesRecord::finder ()->findAll ('ORDER BY Name');
            $this->OtherPages->dataBind();
			
			$this->OtherPages->setSelectedValue($this->staticPage->PageID);
				
			}
		} else {
			$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Add" ) );
		}
	}
	public function deleteItem($sender, $param) {
		FilesRecord::finder ()->deleteAllByPagesID ( $this->PagesChildren->DataKeys [$param->Item->ItemIndex] );
		PagesRecord::finder ()->deleteByPk ( $this->PagesChildren->DataKeys [$param->Item->ItemIndex] );
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );
	}
	public function editRow($sender, $param) {
		
		if ($this->IsValid) {
			$finder = PagesRecord::finder ();
			$finder->DbConnection->Active = true;
			$transaction = $finder->DbConnection->beginTransaction ();
			try {
				$rows = $finder->findByID ( $this->getRequest ()->itemAt ( "id" ) );
				$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
				$rows->Description = TPropertyValue::ensureString ( $this->Description->getText () );
				$rows->ShortDescription = TPropertyValue::ensureString ( $this->ShortDescription->getText () );
				$rows->Seo = TPropertyValue::ensureString ( $this->Seo->getSafeText () );
				$rows->MetaKeywords = TPropertyValue::ensureString ( $this->MetaKeywords->getSafeText () );
				$rows->MetaDescription = TPropertyValue::ensureString ( $this->MetaDescription->getSafeText () );
				$rows->ShowDate = TPropertyValue::ensureString ( $this->ShowDate->getSafeText () );
				$rows->ShowDateDiff = strtotime($this->ShowDate->getSafeText ());
				
				$rows->PageID = $this->OtherPages->getData();
				
				$rows->TitleDate = TPropertyValue::ensureString ( $this->TitleDate->getSafeText () );
				
				
					$rows->ShowMenu = $this->ShowMenu->getChecked ();
					$rows->ShowFooter = $this->ShowFooter->getChecked ();
					$rows->ShowHome = $this->ShowHome->getChecked ();
					if ($this->ShowHome->getChecked () == true){
						$rows->HideDate = TPropertyValue::ensureString ( $this->HideDate->getSafeText () );
						$rows->HideDateDiff = strtotime($this->HideDate->getSafeText ());
					}else{
						$rows->HideDate = null;
						$rows->HideDateDiff = 0;
					}	
				
				$rows->save ();
				
				$baseMethod = new BaseFunction ();
				$d = dir ( $baseMethod->UploadFilePath );
				while ( $entry = $d->read () ) {
					if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
						$namePhoto = strtolower ( $entry );
						$row = new FilesRecord ();
						$row->Name = $namePhoto;
						
						$row->IsParent = 0;
						if (FilesRecord::finder ()->count ( 'PagesID = ? AND IsParent = 1', $this->getRequest ()->itemAt ( "id" ) ) == 0) {
							$row->IsParent = 1;
						}
						
						$row->Position = 999;
						//$row->PagesID = $this->getRequest ()->itemAt ( "id" );
						$row->save ();
						
						copy ( $baseMethod->UploadFilePath . $entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Pages/' . $this->getRequest ()->itemAt ( "id" ) . '/' . $namePhoto ) or die ( "Błąd przy kopiowaniu" );
						$baseMethod->createThumb ( $namePhoto, Prado::getPathOfAlias ( 'UserFiles' ) . '/Pages/' . $this->getRequest ()->itemAt ( "id" ) . '/', $baseMethod->GlobalWidth );
					}
				}
				$d->close ();
				$transaction->commit ();
				
				$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
						"id" => $this->getRequest ()->itemAt ( "id" ) 
				) ) );
			} catch ( Exception $e ) {
				$transaction->rollBack ();
				print_r($e);
				echo 'a';
				die ();
			}
		}
	}
	public function changePosition($sender, $param) {
		$rows = PagesRecord::finder ()->findByID ( $param->getCommandParameter () );
		if ($param->getCommandName () == 'Top')
			$rows->Position = $rows->Position - 15;
		else
			$rows->Position = $rows->Position + 15;
		$rows->save ();
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );
	}
	protected function checkPosition($parentID, $langID) {
		$i = 1;
		foreach ( PagesRecord::finder ()->findAll ( 'Protected = 0 AND PageID = ? AND LanguageID = ? ORDER BY TitleDate DESC, Position ASC', $parentID, $langID ) as $row ) {
			$rows = PagesRecord::finder ()->findByID ( $row->ID );
			$rows->Position = $i * 10;
			$rows->save ();
			$i ++;
		}
		return $i;
	}
}
?>