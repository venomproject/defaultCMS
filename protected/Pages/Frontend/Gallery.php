<?php
class Gallery extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		

		if($this->getRequest ()->contains ( "id" ) == true){
			$id = $this->getRequest ()->itemAt ( "id" );
		}else{
			$id = 13;
		}
		
		$this->Site = PagesRecord::finder ()->withPhotos()->findByPk ( $id );
		
		if(strlen($this->Site->Description) < 2 && count($this->Site->Photos) == 0)
			$this->PageDescitpion->Visible = false;
		
		
		
		$this->Gallery->DataSource = FilesRecord::finder ()->findAll ( 'PagesID = ? AND IsParent = 0 ORDER BY Position ', $id );
		$this->Gallery->dataBind ();
		
		$this->populateData ();
	}
	protected function getData($offset, $limit) {
		if($this->getRequest ()->contains ( "id" ) == true){
			$id = $this->getRequest ()->itemAt ( "id" );
		}else{
			$id = 13;
		}
		
		$this->Sites->DataSource = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'PageID = ? ORDER BY Position', $id);
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