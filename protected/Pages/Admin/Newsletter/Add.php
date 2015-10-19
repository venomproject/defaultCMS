<?php
class Add extends TPage {
	public $staticPage;
	public $activeBreadcrumbs = null;
	public function onLoad($param) {
		parent::onLoad ( $param );
		$this->staticPage->Name = 'Nowy szablon newsletter';
	}
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			$rows = new nNewsletterRecord ();
			$rows->Name = TPropertyValue::ensureString ( $this->Name->getSafeText () );
			$rows->Status = 0;
			$rows->save ();
			
			$lay = new nLayoutRecord ();
			//$lay->PlaneText = TPropertyValue::ensureString ( $this->PlaneText->getText () );
			$lay->HtmlText = TPropertyValue::ensureString ( $this->HtmlText->getText () );
			$lay->nNewsletterID = $rows->ID;
			$lay->save ();
			
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
			$this->Response->redirect ( $this->Service->constructUrl ( "Newsletter.Data" ) );
		}
	}
}
?>