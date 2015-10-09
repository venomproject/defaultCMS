<?php
/**
 * GlobalizationUrlDetect class will resolve the
 * default culture from URL parameter "culture="
 *
 */
class GlobalizationUrlDetect extends TGlobalization
{
    private $_detectedLanguage;
 
    public function init($xml)
    {
        parent::init($xml);
        $this->getApplication()->attachEventHandler('OnBeginRequest', 
            array($this,'OnBeginRequest'));
    }
 
    /**
     * $this->Request isn't resolved yet when this component is initialized.
     * So we wait until the application fires the BeginRequest event.
     */
    public function OnBeginRequest($param)
    {
        //set the culture according to request parameter "culture"
        if ($culture=$this->getRequest()->itemAt('culture')) {
            $this->_detectedLanguage=$culture;
            $this->setCulture($culture);
        }
     }
 
    public function getDetectedLanguage()
    {
        return $this->_detectedLanguage;
    }
}
?>