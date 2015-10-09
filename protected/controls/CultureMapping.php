<?php
class CultureMapping extends TUrlMappingPattern {
 
    // Store UrlMappings UrlPrefix
    private $_prefix;
 
    public function init($config)
    {
        parent::init($config);
        $this->_prefix=$this->getManager()->getUrlPrefix();
    }
 
    /**
     * constructUrl
     *
     * Inject culture info into UrlPrefix of TUrlMapping
     *
     */
    public function constructUrl($getItems,$encodeAmpersand,$encodeGetItems)
    {
		/*
		echo '<pre>';
		print_r($this->getManager()->getApplication()->getRequest());
		*/
		
        $culture=$this->getManager()->getApplication()->getGlobalization()->getCulture();
        $this->getManager()->setUrlPrefix($this->_prefix.'/'.$culture);
		
	
        return parent::constructUrl($getItems,$encodeAmpersand,$encodeGetItems);
    }
}
?>