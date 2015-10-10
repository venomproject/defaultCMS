<?php
class Data extends TPage {
	public $QtyPage = 0;
	public function onLoad($param) {
		parent::onLoad ( $param );
		if (! $this->getPage ()->IsPostBack) {
		
			$this->QtyPage = $this->checkPosition ( );
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
		
		nNewsletterRecord::finder ()->deleteByPk ( $this->DataGrid->DataKeys [$param->Item->ItemIndex] );
		$this->Response->redirect ( $this->Service->constructUrl ( "Newsletter.Data") );			
	}
	
	protected function checkPosition() {
		$i = 0;
		foreach (nNewsletterRecord::finder ()->findAll() as $row){
			$i++;
		}
		return $i;
	}
}
?>