<?php

class Hackathon_VisibleAdminUpgrade_Model_Observer {

    public function controllerActionPredispatchAdminhtml() {
        /**
         * @var $helpy Hackathon_VisibleAdminUpgrade_Helper_Data
         */
        $helpy = Mage::helper('hackathon_visibleadminupgrade');
        $helpy->displayAdminMessage();
    }
}