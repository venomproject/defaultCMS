<?php
/**
* Generated by Venom Project
*
* mail: biuro@venomproject.com
* mobile: 510-321-811
* www: http://www.venomproject.com
* 
* Autor : Karol Kępa
*/
class PagesRecord extends TActiveRecord
{
	const TABLE='Pages';

	public $ID;
	public $Name;
	public $MenuName;
	public $ShortDescription;
	public $Description;
	public $LanguageID;
	public $LangCode;
	public $Protected; // 0 - standard, 1 - protected delete
	public $ShowMenu;
	public $ShowFooter;
	public $ShowHome;
	public $Date;
	
	public $TitleDate;
	public $ShowDate;
	public $ShowDateDiff;
	
	public $PageID; // NULL - parent
	public $PagesID; // NULL - parent
	
	public $Seo;
	public $MetaKeywords;
	public $MetaDescription;
	public $Other; // additional serialization data
	public $Position;

	public $HideDate;
	public $HideDateDiff;
	
	public $Price;
	public $Qty;
	
	public $MasterPhoto = 'nophoto.png'; 
	public $Photos=array();
	public static $RELATIONS=array
	(
			'Photos' => array(self::HAS_MANY, 'FilesRecord', 'PagesID'),
			'MasterPhoto' => array(self::HAS_ONE, 'FilesRecord', 'PagesID'),
	);
	
	
	/**
	* @param string $className
	* @return PagesRecord
	*/
	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
}
?>
