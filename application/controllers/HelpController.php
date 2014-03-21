<?php

class HelpController extends Zend_Controller_Action
{

    public function init()
    {
         if(!$this->getRequest()->isXmlHttpRequest()){ $this->_helper->layout()->enableLayout(); }   
		 else{$this->_helper->layout()->disableLayout();} 
		 $this->view->noAJhelp = true;
    }

    public function indexAction()
    {
        
    }


}

