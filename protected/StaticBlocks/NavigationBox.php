<?php
class NavigationBox extends TTemplateControl {
	public $activeLi = null;
	public $lang;
	public function onLoad($param) {
		$breadcrumbs = array ();
		$this->lang = new BaseFunction ();
		$this->LeftMenu->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND PageID IS NULL AND LangCode =? ORDER BY Position', $this->lang->getShortLang () );
		$this->LeftMenu->dataBind ();
	}
	public function dataBindUnderCategory($sender, $param) {
		$item = $param->Item;
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			$item->PhotoList->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND PageID = ? AND LangCode =? ORDER BY Position', $item->DataItem->ID, $this->lang->getShortLang () );
			$item->PhotoList->dataBind ();
		}
	}
	public function dataBindMasterCategory($sender, $param) {
		$item = $param->Item;
		if ($item->ItemType === 'Item' || $item->ItemType === 'AlternatingItem') {
			$item->ChildrenList->DataSource = PagesRecord::finder ()->findAll ( 'ShowMenu = 1 AND  PageID = ? AND LangCode =? ORDER BY Position', $item->DataItem->ID, $this->lang->getShortLang () );
			$item->ChildrenList->dataBind ();
		}
	}
}
?>