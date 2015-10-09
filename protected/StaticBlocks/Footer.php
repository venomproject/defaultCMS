<?php
class Footer extends TTemplateControl {
	public function onLoad($param) {
		$this->FooterMenu->DataSource = PagesRecord::finder ()->findAll ( 'ShowFooter = 1 AND PageID IS NULL ORDER BY Position' );
		$this->FooterMenu->dataBind ();
	}
	public function dataBindMasterCategory($sender, $param) {
		$item = $param->Item;
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			
			$item->ChildrenList->DataSource = PagesRecord::finder ()->findAll ( 'ShowFooter = 1 AND PageID = ? ORDER BY Position', $item->DataItem->ID );
			$item->ChildrenList->dataBind ();
		}
	}
}
?>
