<?php

class Hackathon_VisibleAdminUpgrade_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup {

    /**
     * Get core resource resource model
     *
     * @return Mage_Core_Model_Resource_Resource
     */
    public function _getResource()
    {
        return Mage::getResourceSingleton('core/resource');
    }
}