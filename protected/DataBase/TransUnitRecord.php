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
class TransUnitRecord extends TActiveRecord
{
	const TABLE='trans_unit';

	public $id;
	public $msg_id;
	public $cat_id;
	public $source;
	public $target;
	public $comments;
	public $date_added;
	public $date_modified;
	public $author;
	public $translated;	

	/**
	* @param string $className
	* @return UserRecord
	*/
	public static function finder($className=__CLASS__)
	{
		return parent::finder($className);
	}
}
?>
