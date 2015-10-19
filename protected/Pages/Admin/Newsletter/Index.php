<?php
class Index extends TPage {
	public $staticPage;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->staticPage = nNewsletterRecord::finder ()->findByID ( $this->getRequest ()->itemAt ( "id" ) );
		
		if ($this->getRequest ()->contains ( "id" ) == true && isset ( $this->staticPage ) == true) {
			
			if (! $this->getPage ()->IsPostBack) {
				$lay = nLayoutRecord::finder ()->findBy_nNewsletterID ( $this->getRequest ()->itemAt ( "id" ) );
				TPropertyValue::ensureString ( $this->Name->setText ( $this->staticPage->Name ) );
				//TPropertyValue::ensureString ( $this->PlaneText->setText ( $lay->PlaneText ) );
				TPropertyValue::ensureString ( $this->HtmlText->setText ( $lay->HtmlText ) );
				
				$senderList = '';
				foreach ( nSenderRecord::finder ()->findAll ( 'nLayoutID = ? AND Status != 2', $lay->ID ) as $row ) {
					$senderList .= $row->Email . ';';
				}
				$this->SendDescription->setText ( $senderList );
			}
		} else {
			$this->Response->redirect ( $this->Service->constructUrl ( "Newsletter.Data" ) );
		}
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			$rows = nNewsletterRecord::finder ()->findBy_nNewsletterID ( $this->getRequest ()->itemAt ( "id" ) );
			$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
			$rows->Status = 0;
			$rows->save ();
			
			$lay = nLayoutRecord::finder ()->findBy_nNewsletterID ( $this->getRequest ()->itemAt ( "id" ) );
		//	$lay->PlaneText = TPropertyValue::ensureString ( $this->PlaneText->getText () );
			$lay->HtmlText = TPropertyValue::ensureString ( $this->HtmlText->getText () );
			$lay->nNewsletterID = $rows->ID;
			$lay->save ();
			
			nSenderRecord::finder ()->deleteAll ( 'nLayoutID = ? AND Status != 2', $lay->ID );
			
			$mailList = explode ( ";", $this->SendDescription->getText () );
			foreach ( $mailList as $email ) {
				if (filter_var ( trim ( $email ), FILTER_VALIDATE_EMAIL )) {
					
					if (! nSenderRecord::finder ()->findBy_nLayoutID_AND_Email ( $lay->ID, trim ( $email ) )) {
						$send = new nSenderRecord ();
						$send->Email = trim ( $email );
						$send->Status = 0;
						$send->nLayoutID = $lay->ID;
						$send->save ();
					}
				}
			}
		}
		$this->Response->redirect ( $this->Service->constructUrl ( "Newsletter.Data" ) );
	}
}
?>