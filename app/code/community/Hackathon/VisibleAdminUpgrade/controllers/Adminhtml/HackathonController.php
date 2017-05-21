<?php

class Hackathon_VisibleAdminUpgrade_Adminhtml_HackathonController extends Mage_Adminhtml_Controller_Action {

    public function forceupdateAction() {
        /**
         * @var $helpy Hackathon_VisibleAdminUpgrade_Helper_Data
         * @var $admSession Mage_Admin_Model_Session
         */
        $helpy = Mage::helper('hackathon_visibleadminupgrade');

        //for some strange reason the url redirects to another store after one of the following calls.
        //// scince we don't care at this point it is sufficent to generate the url before the mess happens =)
        $url = Mage::helper('adminhtml')->getUrl('adminhtml/dashboard/index');

        Mage::getConfig()->setNode(Mage_Core_Model_App::XML_PATH_SKIP_PROCESS_MODULES_UPDATES, false);
        $admSession = Mage::getSingleton('adminhtml/session');

        try {
            $helpy->coreUpdateAll();
            $admSession->addSuccess('Updates completed sucessfully');
        } catch (Exception $e) {
            $admSession->addError('Error in update script: '.$e->getMessage());
            $admSession->addNotice(nl2br($e->getTraceAsString()));
        }
        
        $this->_redirectUrl($url);
    }

}