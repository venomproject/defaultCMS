<?php
class Products extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$id = $this->getRequest ()->itemAt ( "id" );
 
		$this->Site = PagesRecord::finder ()->withPhotos()->findByPk ( $id );
		if ($this->Site == NULL) {
			throw new THttpException(404,'/',$id);
		}
		if(strlen($this->Site->Description) < 2 && count($this->Site->Photos) == 0)
			$this->PageDescitpion->Visible = false;
		
		$this->populateData ();
		
		$this->Gallery->DataSource = FilesRecord::finder ()->findAll ( 'PagesID = ? AND IsParent = 0 ORDER BY Position ', $id );
		$this->Gallery->dataBind ();
	}
	protected function getData($offset, $limit) {
		$this->Sites->DataSource = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'PageID = ? ORDER BY Position', $this->getRequest ()->itemAt ( "id" ));
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