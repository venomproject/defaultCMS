<?php
class Search extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$id = $this->getRequest ()->itemAt ( "id" );
 
		$this->Site = $id;
		
		$this->populateData ();
		
	}
	protected function getData($offset, $limit) {
		$id = $this->getRequest ()->itemAt ( "id" );
		$this->Sites->DataSource =  PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'ShortDescription LIKE "%'.$id.'%" || Description LIKE "%'.$id.'%"' );
		return $this->Sites->dataBind ();
	}
	protected function populateData() {
		$offset = $this->Sites->CurrentPageIndex * $this->Sites->PageSize;
		$limit = $this->Sites->PageSize;
		if ($offset + $limit > $this->Sites->VirtualItemCount)
			$limit = $this->Sites->VirtualItemCount - $offset;
		$data = $this->getData ( $offset, $limit );
		$this->Sites->DataSource = $data;
		$this->Sites->dataBind ();
	}
	public function pageChanged($sender, $param) {
		$this->Sites->CurrentPageIndex = $param->NewPageIndex;
		$this->populateData ();
	}
}
?>