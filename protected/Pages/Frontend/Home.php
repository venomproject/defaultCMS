<?php
class Home extends TPage {
	public $Site;
	public $activeBreadcrumbs = null;
	
	public function onLoad($param) {
		parent::onLoad ( $param );
		$this->populateData ();
		
		$this->GalleryHome->DataSource = PagesRecord::finder ()->withMasterPhoto('IsParent = 1')->findAll('ShowHome = 1 AND Other = 13' );
		$this->GalleryHome->dataBind ();
	}
	protected function getData($offset, $limit) {
		$this->Sites->DataSource = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'ShowHome = 1 AND Other = 4 ORDER BY Position' );
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