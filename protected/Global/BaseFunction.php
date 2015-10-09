<?php
class BaseFunction
{
	private $Key = 'hLJjJNI6qWZxIqSHTjUMbcVFx6867F6F73C21DWG5bfKyWRnAiwQqvqxTKV1JUVNJUVl1cjojbpwIoHEFF7B7DF1A6CF6B4C9F4B1h97wqvc14tW5HsGuAMRSsI3oJfzWwXr71A7331BuDcYFRmEfhjd5oh4iGAzuKgOU8b9CTDnP1tA88SxP4Lq140gBo7RIAt7QycAlXNwC9141ADFEF2C332A6E7F6CE2C6813';

	public $UploadFilePath = 'themes/Admin/jQuery-File-Upload/server/php/files/';
	
	public $GlobalWidth = '445';
	
	public function cryptString($param)
	{
		$str =sha1(crypt($this->Key, md5($param)));
		return strtr($str, '.,?!;:-/\\', 'abcdefgah');
	}
	
	public function getShortLang(){ 
		$source = Prado::getApplication()->getGlobalization();
		if (Prado::getApplication()->getRequest ()->contains ( 'culture' )) {
			$source->setCulture ( Prado::getApplication()->getRequest ()->itemAt ( 'culture' ) );
		} 
		return $source->getCulture();
	}
	
	
	public function createThumb($name, $sciezka, $szerokosc){

		
		$plik = $sciezka.$name;
		$i = explode('.', $plik);
		$rozszerzenie = end($i);
		list($img_szer, $img_wys) = getimagesize($plik);

		$proporcje = $img_szer / $img_wys;
		
		if($proporcje>1){
			
		}
		
		$wysokosc = $szerokosc/$proporcje;
		
		$canvas = imagecreatetruecolor($szerokosc, $wysokosc);

		switch($rozszerzenie) {
			case 'jpg':
				$org = imagecreatefromjpeg($plik);
				break;
			case 'jpeg':
				$org = imagecreatefromjpeg($plik);
				break;
			case 'gif':
				$org = imagecreatefromgif($plik);
				break;
			case 'png':
				$org = imagecreatefrompng($plik);
				break;				
		}
		imagecopyresampled($canvas, $org, 0, 0, 0, 0,
				$szerokosc, $wysokosc, $img_szer, $img_wys);

		$newPath = $sciezka.'/thumb/'.$name;
		if(imagejpeg($canvas, $newPath, 90)) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>