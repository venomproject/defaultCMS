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
class SliderRecord extends TActiveRecord
{
	const TABLE='Slider';

	public $ID;
	public $Name;
	public $Description;
	public $Photo;
	public $Position;

	/**
	* @param string $className
	* @return SliderRecord
	*/
	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
}
?>
