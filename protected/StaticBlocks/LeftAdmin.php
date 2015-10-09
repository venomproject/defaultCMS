<?php
class LeftAdmin extends TTemplateControl {
	public $activeLi = null;
	public $ActLang;
	public function onLoad($param) {
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		$this->ActLang = $langID;
		
		if ($this->User->PagesID == 0 || $this->User->Roles [0] == 'admin') {
			$this->PagesParent->DataSource = PagesRecord::finder ()->findAll ( 'PageID IS NULL AND LanguageID = ?', $langID );
			$this->PagesParent->dataBind ();
		}
		
		$m = null;
		if ($this->getPage ()->getPagePath () == 'Pages.Index' || $this->getPage ()->getPagePath () == 'Pages.Add') {
			$m = $this->getRequest ()->itemAt ( "id" );
		}
		$this->activeLi = array (
				0 
		);
		if ($m != null) {
			array_push ( $this->activeLi, $m );
			do {
				$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
				$m = $b->PageID;
				$breadcrumbs [$m] = $b->Name;
				array_push ( $this->activeLi, $m );
			} while ( $m != null );
		}
	}
	public function dataBindMasterCategory($sender, $param) {
		$item = $param->Item;
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			
			$item->ChildrenList->DataSource = PagesRecord::finder ()->findAll ( 'PageID = ? ORDER BY Position', $item->DataItem->ID );
			$item->ChildrenList->dataBind ();
		}
	}
}
?>
