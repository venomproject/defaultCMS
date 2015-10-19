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
		$this->DataGrid->DataSource = SliderRecord::finder ()->findAll ('ORDER BY Position');
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
		SliderRecord::finder ()->deleteBy_ID ( $nID );
		$this->populateData ();
		
		$this->Correct->Visible = true;
		$this->Alert->Visible = false;
	}
	public function changePosition($sender, $param) {
		$rows = SliderRecord::finder ()->findByID ( $param->getCommandParameter () );
		if ($param->getCommandName () == 'Top')
			$rows->Position = $rows->Position - 15;
		else
			$rows->Position = $rows->Position + 15;
		$rows->save ();
		$this->Response->redirect ( $this->Service->constructUrl ( 'Slider.Data' ) );
	}
	protected function checkPosition() {
		$i = 1;
		foreach ( SliderRecord::finder ()->findAll ( ' ORDER BY Position' ) as $row ) {
			$rows = SliderRecord::finder ()->findByID ( $row->ID );
			$rows->Position = $i * 10;
			$rows->save ();
			$i ++;
		}
		return $i - 1;
	}
}
?>