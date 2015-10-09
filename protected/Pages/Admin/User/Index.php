<?php
class Index extends TPage {
	public $staticPage;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->staticPage = PagesRecord::finder ()->findByPk ( $this->getRequest ()->itemAt ( "id" ) );
		
		if ($this->getRequest ()->contains ( "id" ) == true && isset ( $this->staticPage ) == true) {
			
			$session = Prado::getApplication ()->getSession ();
			$langID = $session->itemAt ( 'jezyk' );
			$parentID = $this->getRequest ()->itemAt ( "id" );
			
			if (! $this->getPage ()->IsPostBack) {
				
				$this->PagesChildren->DataSource = UserRecord::finder ()->findAll ( 'PagesID = ?', $parentID);
				$this->PagesChildren->dataBind ();
				
				$this->InCorrect->Visible = false;
			}
		} else {
			$this->Response->redirect ( $this->Service->constructUrl ( "Pages.Add" ) );
		}
	}
	public function deleteItem($sender, $param) {
		UserRecord::finder ()->deleteByID ( $this->PagesChildren->DataKeys [$param->Item->ItemIndex] );
		$this->Response->redirect ( $this->Service->constructUrl ( "User.Index", array (
				"id" => $this->getRequest ()->itemAt ( "id" ) 
		) ) );
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			$baseMethod = new BaseFunction ();
			$qty = UserRecord::finder ()->count();
			
			

			if(UserRecord::finder ()->findByName($this->Login->getSafeText ())){
				$this->InCorrect->Visible = true;
			}else{
				
			
			
			$rows = new UserRecord ();
			$rows->Username = $baseMethod->cryptString ( $this->Login->getSafeText () );
			$rows->Email = $baseMethod->cryptString ( $this->Login->getSafeText () );
			$rows->Password = $baseMethod->cryptString ( $this->Password->getSafeText () );
			$rows->Role = 0;
			$rows->PagesID = $this->getRequest ()->itemAt ( "id" );
			$rows->Name =  $this->Login->getSafeText () ;
			$rows->ID = $qty+1;
			$rows->save ();
			
			$this->Response->redirect ( $this->Service->constructUrl ( "User.Index", array (
					"id" => $this->getRequest ()->itemAt ( "id" ) 
			) ) );
			
			}
		}
	}
	
}
?>