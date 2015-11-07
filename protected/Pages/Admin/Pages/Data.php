<?php
class Data extends TPage {
	public $QtyPage = 0;
	public function onLoad($param) {
		parent::onLoad ( $param );
		if (! $this->getPage ()->IsPostBack) {
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			
			$this->QtyPage = $this->checkPosition ( $langID );
			$this->populateData ();
		}
	}
	
	protected function getData($offset, $limit) {
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		//$this->DataGrid->DataSource = PagesRecord::finder ()->findAll ( 'LanguageID = ? AND PageID is Null ORDER BY Position', $langID );
		$this->DataGrid->DataSource = PagesRecord::finder ()->findAll ( 'LanguageID = ?  ORDER BY Position', $langID );
		return $this->DataGrid->dataBind ();
	}
	public function pageChanged($sender, $param) {
		$this->DataGrid->CurrentPageIndex = $param->NewPageIndex;
		$this->populateData ();
	}
	protected function populateData() {
		$offset = $this->DataGrid->CurrentPageIndex * $this->DataGrid->PageSize;
		$limit = $this->DataGrid->PageSize;
		if ($offset + $limit > $this->DataGrid->VirtualItemCount)
			$limit = $this->DataGrid->VirtualItemCount - $offset;
		$data = $this->getData ( $offset, $limit );
		$this->DataGrid->DataSource = $data;
		$this->DataGrid->dataBind ();
	}
	public function deleteItem($sender, $param) {
		$chackProtected = PagesRecord::finder ()->findByPk ( $this->DataGrid->DataKeys [$param->Item->ItemIndex] );
		 
		if ($chackProtected->Protected != 1) {
			
			$finder = PagesRecord::finder ();
			$finder->DbConnection->Active = true;
			$transaction = $finder->DbConnection->beginTransaction ();
			try {
				$page = $finder->deleteByPk ( $this->DataGrid->DataKeys [$param->Item->ItemIndex] );
				
				$finders = PagesRecord::finder ();
				$finders->DbConnection->Active = true;
				$file = $finders->deleteAllByPageID ( $this->DataGrid->DataKeys [$param->Item->ItemIndex] );
				
				$transaction->commit ();
				$this->populateData ();
				
				$this->Correct->Visible = true;
				$this->Alert->Visible = false;
			} catch ( Exception $e ) {
				$transaction->rollBack ();
			}
		} else {
			$this->Alert->Visible = true;
			$this->Correct->Visible = false;
		}
	}
	
	
	
	public function changePosition($sender, $param) {
		$rows = PagesRecord::finder ()->findByID ($param->getCommandParameter ());
		if($param->getCommandName () == 'Top')
		$rows->Position = $rows->Position-15;
		else
		$rows->Position = $rows->Position+15;
		$rows->save ();
		$this->Response->redirect ( $this->Service->constructUrl ('Pages.Data') );
	}
	protected function checkPosition($langID) {
	
		$i = 1;
		//foreach (PagesRecord::finder ()->findAll( 'LanguageID = ? AND PageID is Null ORDER BY Position', $langID ) as $row){
		foreach (PagesRecord::finder ()->findAll( 'LanguageID = ?   ORDER BY Position', $langID ) as $row){
			$rows = PagesRecord::finder ()->findByID ($row->ID);
			$rows->Position = $i*10;
			$rows->save ();
			$i++;
		}
		return $i-1;
	
	}
}
?>