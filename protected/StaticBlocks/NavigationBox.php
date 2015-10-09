<?php
class NavigationBox extends TTemplateControl {
	public $activeLi = null;
	public function onLoad($param) {
		$breadcrumbs = array ();
		
		$this->LeftMenu->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND PageID IS NULL ORDER BY Position' );
		$this->LeftMenu->dataBind ();
	}
	public function dataBindUnderCategory($sender, $param) {
		$item = $param->Item;
		
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			
			$item->PhotoList->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND PageID = ? ORDER BY Position', $item->DataItem->ID );
			$item->PhotoList->dataBind ();
		}
	}
	public function dataBindMasterCategory($sender, $param) {
		$item = $param->Item;
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			
			$item->ChildrenList->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND  PageID = ? ORDER BY Position', $item->DataItem->ID );
			$item->ChildrenList->dataBind ();
		}
	}
}
?>
