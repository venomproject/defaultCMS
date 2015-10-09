<?php
class Add extends TPage {
	public $staticPage;
	public function onLoad($param) {
		parent::onLoad ( $param );
		
	}
	
	public function editRow($sender, $param) {
		if ($this->IsValid) {
			
			
			$short = strtolower($this->ShortName->getSafeText ());
			
			$rows = new CatalogueRecord();
			$rows->name = 'messages.'.$short ;
			$rows->MasterName = TPropertyValue::ensureString ( $this->Name->getSafeText () );
			$rows->ShortName = TPropertyValue::ensureString ( $short);
			$rows->save ();
			
			if (!is_dir(Prado::getPathOfAlias('UserFiles').'/Language/'.$rows->cat_id)) {
				$dirun = dir(Prado::getPathOfAlias('UserFiles'));
				mkdir($dirun->path.'/Language/'.$rows->cat_id, 0775);
				$dirun->close();
			}

			$baseMethod = new BaseFunction ();
			$d = dir ($baseMethod->UploadFilePath);
			while ( $entry = $d->read () ) {
				if (strlen ( $entry ) > 2 && is_file ( $d->path . '/' . $entry ) && $entry != '.htaccess') {
					copy ( $baseMethod->UploadFilePath.$entry, Prado::getPathOfAlias ( 'UserFiles' ) . '/Language/'.$rows->cat_id.'/'.$entry) or die ( "Błąd przy kopiowaniu" );
					$row = CatalogueRecord::finder()->findBycat_id($rows->cat_id);
					$row->Photo = $entry;
					$row->save();
				}
			}

			$statyczne = PagesRecord::finder ()->findAll('PageID IS NULL AND LanguageID = 1');
			foreach ($statyczne as $page){
				$new = new PagesRecord();
				$new->Name = $rows->ShortName.' : '.$page->Name;
				$new->LanguageID = $rows->cat_id;
				$new->LangCode = $short;
				$new->PageID = $page->PageID;
				$new->Protected = $page->Protected;
				$new->save();
			}
			
			

			$translation = TransUnitRecord::finder ()->findAll('cat_id = 1');
			foreach ($translation as $page){
				$new = new TransUnitRecord();
				$new->id = $page->id;
				$new->cat_id = $rows->cat_id;
				$new->source = $page->source;
				$new->save();
			}
			
			
			
			$settings = SettingsRecord::finder ()->findAll('LanguageID = 1');
			foreach ($settings as $set){
				$newS = new SettingsRecord();
				$newS->Key = $set->Key;
				$newS->Value = $rows->ShortName.' : '.$set->Value;
				$newS->LanguageID = $rows->cat_id;
				$newS->save();
			}
			
			$this->Response->redirect ( $this->Service->constructUrl ( "Language.Index", array('id'=>$rows->cat_id) ) );
			
		}
	}
	
	
	
	public function deleteItem($sender,$param)
	{
		if($this->Language->DataKeys[$param->Item->ItemIndex] == 1){
			echo 'Error : nie można usunąć domyslnego języka';
			die();
		}else{
		
		PagesRecord::finder()->deleteAllByLanguageID($this->Language->DataKeys[$param->Item->ItemIndex]);
		SettingsRecord::finder()->deleteAllByLanguageID($this->Language->DataKeys[$param->Item->ItemIndex]);
		LanguageRecord::finder()->deleteByPk($this->Language->DataKeys[$param->Item->ItemIndex]);
		$this->Response->redirect ( $this->Service->constructUrl ( "Language.Index", array('id'=>1) ) );
		}
	}
}
?>