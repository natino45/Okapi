<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) { $this->_redirect('auth/'); }
		$this->_redirect('preview');
    }

    public function indexAction()
    {
      //empty
    }


}

