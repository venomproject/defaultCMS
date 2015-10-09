<?php
class Category extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->Category->DataSource = PagesRecord::finder ()->findAll ( 'PageID = 4 ORDER BY Name');
		$this->Category->dataBind ();
		
		
		$this->populateData ();
		
		
	}
	protected function getData($offset, $limit) {
		$this->Sites->DataSource = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'PageID = ? AND ShowDate <= ? ORDER BY Position', $this->getRequest ()->itemAt ( "id" ), date('d-m-Y') );
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