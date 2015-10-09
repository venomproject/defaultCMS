<?php
class Index extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public $hide = 1;
	public $hideNews = 1;
	
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->staticPage = PagesRecord::finder()->findByPk($this->getRequest ()->itemAt ( "id" ));
			
		
		if ($this->getRequest ()->contains ( "id" ) == true && isset($this->staticPage) == true) {
			
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			$parentID = $this->getRequest ()->itemAt ( "id" );
			
			if (! $this->getPage ()->IsPostBack) {
				
				TPropertyValue::ensureString ( $this->Name->setText ( $this->staticPage->Name ) );
				TPropertyValue::ensureString ( $this->Price->setText ( $this->staticPage->Price ) );
				TPropertyValue::ensureString ( $this->Qty->setText ( $this->staticPage->Qty ) );
				//TPropertyValue::ensureString ( $this->ShowDate->setText ( $this->staticPage->ShowDate ) );
				//TPropertyValue::ensureString ( $this->TitleDate->setText ( $this->staticPage->TitleDate ) );
				TPropertyValue::ensureString ( $this->Seo->setText ( $this->staticPage->Seo ) );
				TPropertyValue::ensureString ( $this->Description->setText ( $this->staticPage->Description ) );
				TPropertyValue::ensureString ( $this->ShortDescription->setText ( $this->staticPage->ShortDescription  ) );
				TPropertyValue::ensureString ( $this->MetaKeywords->setText ( $this->staticPage->MetaKeywords ) );
				TPropertyValue::ensureString ( $this->MetaDescription->setText ( $this->staticPage->MetaDescription ) );
				
				$this->ShowMenu->setChecked ( $this->staticPage->ShowMenu ) ;
				$this->ShowFooter->setChecked ( $this->staticPage->ShowFooter ) ;
				$this->ShowHome->setChecked ( $this->staticPage->ShowHome ) ;
				
				
				$this->checkPosition ($parentID, $langID );
				
				$this->PagesChildren->DataSource = PagesRecord::finder ()->findAll ( 'Protected = 0 AND PageID = ? AND LanguageID = ? ORDER BY Position', $parentID, $langID );
				$this->PagesChildren->dataBind ();
				
			}
			
			$m = $this->getRequest ()->itemAt ( "id" );
				
			if ($m != null) {
				do {
					$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
					$m = $b->PageID;
					$this->activeBreadcrumbs [$b->ID] = $b->Name;
				} while ( $m != null );
			}
			ksort ( $this->activeBreadcrumbs );
			
			if(isset($this->activeBreadcrumbs[4])){
				$this->hide = 0;
			}
			
			if(isset($this->activeBreadcrumbs[4]) || isset($this->activeBreadcrumbs[13])){
				$this->hideNews = 0;
			}
			
			
			
		} else {
			$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Add"));
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
				$rows->Description = TPropertyValue::ensureString ( $this->Description->getText ());
				$rows->ShortDescription = TPropertyValue::ensureString ( $this->ShortDescription->getText () );
				$rows->Seo = TPropertyValue::ensureString ( $this->Seo->getSafeText () );
				$rows->MetaKeywords = TPropertyValue::ensureString ( $this->MetaKeywords->getSafeText () );
				$rows->MetaDescription = TPropertyValue::ensureString ( $this->MetaDescription->getSafeText () );
			//	$rows->ShowDate = TPropertyValue::ensureString ( $this->ShowDate->getSafeText () );
			//	$rows->TitleDate = TPropertyValue::ensureString ( $this->TitleDate->getSafeText () );
				
				$rows->Price = TPropertyValue::ensureString ( $this->Price->getSafeText () );
				$rows->Qty = TPropertyValue::ensureString ( $this->Qty->getSafeText () );
					
				
				if($this->User->PagesID == 0){
				$rows->ShowMenu =  $this->ShowMenu->getChecked ();				
				$rows->ShowFooter =  $this->ShowFooter->getChecked ();
				$rows->ShowHome =  $this->ShowHome->getChecked ();
				}
				
				if(isset($this->activeBreadcrumbs[4])){
					$rows->Other =  4;	
				}
				
				if(isset($this->activeBreadcrumbs[13])){
					$rows->Other =  13;
				}
				
				$rows->save ();
				
				$baseMethod = new BaseFunction ();
				$d = dir ($baseMethod->UploadFilePath);
				while ( $entry = $d->read () ) {
					if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
						$namePhoto = strtolower($entry);
						$row = new FilesRecord ();
						$row->Name = $namePhoto;
						$row->IsParent = 0;
						if (FilesRecord::finder ()->count ( 'PagesID = ? AND IsParent = 1', $this->getRequest ()->itemAt ( "id" ) ) == 0) {
							$row->IsParent = 1;
						}
						$row->Position = 999;
						$row->PagesID = $this->getRequest ()->itemAt ( "id" );
						$row->save ();
						
						copy ( $baseMethod->UploadFilePath.$entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Pages/' . $this->getRequest ()->itemAt ( "id" ) . '/' . $namePhoto ) or die ( "Błąd przy kopiowaniu" );
						$baseMethod->createThumb($namePhoto, Prado::getPathOfAlias ( 'UserFiles' ).'/Pages/'.$this->getRequest ()->itemAt ( "id" ).'/', $baseMethod->GlobalWidth );
					}
				}
				$d->close ();
				$transaction->commit ();
				
				
				$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
						"id" => $this->getRequest ()->itemAt ( "id" ) 
				) ) );
			} catch ( Exception $e ) {
				$transaction->rollBack ();
				die();
			}
		}
	}
	
	public function changePosition($sender, $param) {
		$rows = PagesRecord::finder ()->findByID ($param->getCommandParameter ());
		if($param->getCommandName () == 'Top')
			$rows->Position = $rows->Position-15;
		else
			$rows->Position = $rows->Position+15;
		$rows->save ();
		$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Index", array (
						"id" => $this->getRequest ()->itemAt ( "id" ) 
				) ) );
	}
	protected function checkPosition($parentID, $langID) {
		$i = 1;
		foreach (PagesRecord::finder ()->findAll( 'Protected = 0 AND PageID = ? AND LanguageID = ? ORDER BY TitleDate DESC, Position ASC', $parentID, $langID ) as $row){
			$rows = PagesRecord::finder ()->findByID ($row->ID);
			$rows->Position = $i*10;
			$rows->save ();
			$i++;
		}
		return $i;
	
	}
}
?>