<?php
class ChangePassword extends TPage {
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$hash = $this->getRequest ()->itemAt ( "amp;hash" );
		if ($this->getRequest ()->contains ( "amp;hash" ) == false) {
			$hash = $this->getRequest ()->itemAt ( "hash" );
		}
		
		if (! UserRecord::finder ()->findByUsername ( $hash )) {
			$this->InCorrect->Visible = true;
			$this->Correct->Visible = false;
		} else {
			$this->InCorrect->Visible = false;
		}
	}
	public function changePassword2($sender, $param) {
		$finder = UserRecord::finder ();
		$finder->DbConnection->Active = true;
		$transaction = $finder->DbConnection->beginTransaction ();
		try {
			$baseMethod = new BaseFunction ();
			
			$hash = $this->getRequest ()->itemAt ( "amp;hash" );
			if ($this->getRequest ()->contains ( "amp;hash" ) == false) {
				$hash = $this->getRequest ()->itemAt ( "hash" );
			}
			
			$rows = $finder->findByUsername ( $hash );
			$rows->Password = TPropertyValue::ensureString ( $baseMethod->cryptString ( $this->ConfirmPassword->getSafeText () ) );
			$rows->save ();
			$transaction->commit ();
		} catch ( Exception $e ) {
			print_R ( $e->getMessage () );
			$transaction->rollBack ();
		}
		
		$this->Response->redirect ( $this->Service->constructUrl ( "Login" ) );
	}
}
?>