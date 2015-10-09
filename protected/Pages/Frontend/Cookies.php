<?php
class Cookies extends TPage {
	public $Site;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
		$this->Site = PagesRecord::finder()->findByPk(1);
		
	}
}
?>