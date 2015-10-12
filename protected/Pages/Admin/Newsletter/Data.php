<?php
class Data extends TPage {
	public $QtyPage = 0;
	public function onLoad($param) {
		parent::onLoad ( $param );
		if (! $this->getPage ()->IsPostBack) {
			
			$this->QtyPage = $this->checkPosition ();
			$this->populateData ();
		}
	}
	protected function getData($offset, $limit) {
		$this->DataGrid->DataSource = nNewsletterRecord::finder ()->findAll ();
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
		$nID = $this->DataGrid->DataKeys [$param->Item->ItemIndex];
		$lID = nLayoutRecord::finder ()->findBy_nNewsletterID ( $nID );
		
		if (isset ( $lID->ID )) {
			nSenderRecord::finder ()->deleteAllBy_nLayoutID ( $lID->ID );
			nLayoutRecord::finder ()->deleteBy_nNewsletterID ( $nID );
		}
		nNewsletterRecord::finder ()->deleteBy_ID ( $nID );
		
		$this->populateData ();
		
		$this->Correct->Visible = true;
		$this->Alert->Visible = false;
	}
	protected function checkPosition() {
		$i = 0;
		foreach ( nNewsletterRecord::finder ()->findAll () as $row ) {
			$i ++;
		}
		return $i;
	}
	
	public function ChangeStatusNewsletter($sender,$param)
	{
		$rowData = nNewsletterRecord::finder()->findByID($param->CommandName);
			$rowData->Status = $param->CommandParameter;
		$rowData->save();
	
	
		$this->Response->redirect($this->Service->constructUrl("Newsletter.Data"));
	}
}
?>