<?php
class Show extends TPage
{
	public $Site;
	public $Parent;
	public $activeBreadcrumbs = null;
	public $Category;
	public function onLoad($param)
	{
		parent::onLoad($param);
		$id = $this->getRequest()->itemAt("id");
		$this->Site = PagesRecord::finder ()->withMasterPhoto ( 'IsParent = 1' )->findByPk ( $id );

		$underList = array();
		$i=0;
		foreach(PagesRecord::finder()->findAll('PageID = ? ORDER BY Position', $id) as $dataRows){
			$underList[$i]['ID'] = $dataRows->ID;
			$underList[$i]['Name'] = $dataRows->Name;
		
			$underList[$i]['Photo'] = '/UserFiles/Pages/nophoto.png';
			$checkPhoto = FilesRecord::finder()->findByPagesID_AND_IsParent($dataRows->ID,1);
			if(isset($checkPhoto))
				$underList[$i]['Photo'] = '/UserFiles/Pages/'.$dataRows->ID.'/thumb/'.$checkPhoto->Name;
		
			$i++;
		}
		
		$m = $this->getRequest ()->itemAt ( "id" );
			
		if ($m != null) {
			do {
				$b = PagesRecord::finder ()->find ( 'ID = ?', $m );
				$m = $b->PageID;
				$this->activeBreadcrumbs[$b->ID] = $b->Name;
			} while ( $m != null );
		}
		ksort($this->activeBreadcrumbs);
		
		$this->Sites->DataSource= $underList;
		$this->Sites->dataBind();
		
		$this->Gallery->DataSource = FilesRecord::finder ()->findAll ( 'PagesID = ? AND IsParent = 0 ORDER BY Position ', $id );
		$this->Gallery->dataBind ();
			
	}

}
?>