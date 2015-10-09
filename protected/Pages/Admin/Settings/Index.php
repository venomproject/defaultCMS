<?php
class Index extends TPage {
	
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		if (! $this->getPage ()->IsPostBack) {
			$this->DataGrid->DataSource = SettingsRecord::finder ()->findAll ( 'LanguageID = ?', $langID );
			$this->DataGrid->dataBind ();
		}
		
	}
	public function getData() {
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		
		return SettingsRecord::finder ()->findAll ( 'LanguageID = ?', $langID );
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
		
		$rows = SettingsRecord::finder ()->find ( 'ID = ? AND LanguageID = ?', $id, $langID );
		$rows->Value = $item->Value->TextBox->Text;
		$rows->save ();
		
		$this->DataGrid->EditItemIndex = - 1;
		$this->DataGrid->DataSource = $this->Data;
		$this->DataGrid->dataBind ();
		
		$session = Prado::getApplication ()->getSession ();
		$langID = $session->itemAt ( 'jezyk' );
		$this->Response->redirect ( $this->Service->constructUrl ( "Settings.Index", array (
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