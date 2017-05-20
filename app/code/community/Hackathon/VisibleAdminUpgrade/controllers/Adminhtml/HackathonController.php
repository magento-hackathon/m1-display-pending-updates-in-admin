<?php

class Hackathon_VisibleAdminUpgrade_Adminhtml_HackathonController extends Mage_Adminhtml_Controller_Action {

    public function forceupdateAction() {
        /**
         * @var $helpy Hackathon_VisibleAdminUpgrade_Helper_Data
         */
        $helpy = Mage::helper('hackathon_visibleadminupgrade');

        Mage::getConfig()->setNode(Mage_Core_Model_App::XML_PATH_SKIP_PROCESS_MODULES_UPDATES, false);
        $helpy->coreUpdateAll();
    }

}