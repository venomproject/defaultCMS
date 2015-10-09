<?php
class Index extends TPage {
	public $languageFlag;
	
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		if (! $this->getPage ()->IsPostBack) {
			$this->DataGrid->DataSource = TransUnitRecord::finder ()->findAll ( 'cat_id = ?', $langID );
			$this->DataGrid->dataBind ();
		}
		
		$lang = CatalogueRecord::finder ()->findBycat_id($langID );
		$this->languageFlag = $lang->cat_id.'/'.$lang->Photo;
	}
	public function getData() {
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		return TransUnitRecord::finder ()->findAll ( 'cat_id = ?', $langID );
	}
	public function editItem($sender, $param) {
		$this->DataGrid->EditItemIndex = $param->Item->ItemIndex;
		$this->DataGrid->DataSource = $this->Data;
		$this->DataGrid->dataBind ();
	}
	public function saveItem($sender, $param) {
		
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		$id = $param->Item->ItemIndex+1;
		$item = $param->Item;
		
		$rows = TransUnitRecord::finder ()->find ( 'id = ? AND cat_id = ?', $id, $langID );
		$rows->target = $item->TargetTrans->TextBox->Text;
		$rows->save ();
		
		$this->DataGrid->EditItemIndex = - 1;
		$this->DataGrid->DataSource = $this->Data;
		$this->DataGrid->dataBind ();
		
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		$this->Response->redirect ( $this->Service->constructUrl ( "Translation.Index", array (
				'id' => $langID 
		) ) );
	}
	public function cancelItem($sender, $param) {
		$this->DataGrid->EditItemIndex = - 1;
		$this->DataGrid->DataSource = $this->Data;
		$this->DataGrid->dataBind ();
	}
}
?>