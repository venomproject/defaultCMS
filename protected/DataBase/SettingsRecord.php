<?php
/**
* Generated by Venom Project
*
* mail: biuro@venomproject.com
* mobile: 510-321-811
* www: http://www.venomproject.com
* 
* Autor : Karol K�pa
*/
class SettingsRecord extends TActiveRecord
{
	const TABLE='Settings';

	public $ID;
	public $Key;
	public $Value;
	public $LanguageID;
	public $LangCode;
	
	/**
	* @param string $className
	* @return SettingsRecord
	*/
	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
}
?>
