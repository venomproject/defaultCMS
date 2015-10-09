<?php
class Pages extends TPage {
	public $Site;
	public $activeBreadcrumbs = null;
	
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
		
		$this->Gallery->DataSource = FilesRecord::finder ()->findAll ( 'PagesID = ? ORDER BY Position ', $id );
		$this->Gallery->dataBind ();
		
		
	}
	
	public function onInit($param) {
		$m = $this->getRequest ()->itemAt ( "id" );
			
		if ($m != null) {
			do {
				$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
				$m = $b->PageID;
				$this->activeBreadcrumbs[$b->ID] = $b->Name;
			} while ( $m != null );
		}
		ksort($this->activeBreadcrumbs);
		
		if( isset($this->activeBreadcrumbs[4]) && count($this->activeBreadcrumbs) == 2){
			$this->Response->redirect ($this->Service->constructUrl ( "Products", array('id'=> $this->getRequest ()->itemAt ( "id" )) ));
		}
		
		if( isset($this->activeBreadcrumbs[4]) && count($this->activeBreadcrumbs) == 3){
			$this->Response->redirect ($this->Service->constructUrl ( "Show", array('id'=> $this->getRequest ()->itemAt ( "id" )) ));
		}
		
	}
	
	protected function getData($offset, $limit) {
		$this->Sites->DataSource = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findAll ( 'PageID = ?  ORDER BY Position', $this->getRequest ()->itemAt ( "id" ));
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