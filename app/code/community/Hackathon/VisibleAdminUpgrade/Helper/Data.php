<?php

class Hackathon_VisibleAdminUpgrade_Helper_Data extends Mage_Core_Helper_Abstract {

    public function checkForPendingScripts()
    {
        $pendingUpdates = [];
        $resources = Mage::getConfig()->getNode('global/resources')->children();

        foreach ($resources as $resName => $resource) {
            if (!$resource->setup) {
                continue;
            }
            $className = Hackathon_VisibleAdminUpgrade_Model_Resource_Setup::class;
            if (isset($resource->setup->class)) {
                $className = $resource->setup->getClassName();
            }

            /**
             * @var $setupClass Hackathon_VisibleAdminUpgrade_Model_Resource_Setup
             */
            $setupClass = new $className($resName);
            $dbResource = null;
            if (method_exists($setupClass, '_getResource') && is_callable([$setupClass, '_getResource'])) {
                $dbResource = $setupClass->_getResource();
            } else {
                $dbResource = Mage::getResourceSingleton('core/resource');
            }

            $dbVer = $dbResource->getDbVersion($resName);
            $modConfig = $this->loadModuleConfig($resName);
            $configVer = (string) $modConfig->version;

            $status = version_compare($configVer, $dbVer);
            if ($status == Mage_Core_Model_Resource_Setup::VERSION_COMPARE_GREATER) {
                if (!in_array($resName, $pendingUpdates)) {
                    $pendingUpdates[] = [$resName => $dbVer.'=>'.$configVer];
                }
            }
        }

        return $pendingUpdates;
    }

    public function displayAdminMessage()
    {
        $pending = $this->checkForPendingScripts();
        if (count($pending) > 0) {
            /**
             * @var $admSession Mage_Admin_Model_Session
             */
            $admSession = Mage::getSingleton('adminhtml/session');
            $link = Mage_Adminhtml_Helper_Data::getUrl('adminhtml/hackathon/forceupdate');
            $linkText = $this->__('>HERE<');
            $admSession->addNotice(
                $this->__(
                    'There are setup scripts pending, click %s to run them now',
                    '<a href="'.$link.'">'.$this->escapeHtml($linkText).'</a>'
                )
            );
        }
    }

    public function coreUpdateAll()
    {
        Mage_Core_Model_Resource_Setup::applyAllUpdates();

        return true;
    }

    protected function loadModuleConfig($resName)
    {
        $config    = Mage::getConfig();
        $resConfig = $config->getResourceConfig($resName);
        $modName   = (string) $resConfig->setup->module;
        $modConfig = $config->getModuleConfig($modName);

        return $modConfig;
    }

}