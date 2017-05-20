<?php
/**
 * Created by PhpStorm.
 * User: zyr3x
 * Date: 09/12/16
 * Time: 10:49
 */
require_once 'abstract.php';

class Mage_Shell_RunUpdates extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run()
    {
        if (empty($this->_args)) {
            $this->usageHelp();
            return;
        }

        /**
         * @var $helpy Hackathon_VisibleAdminUpgrade_Helper_Data
         */
        $helpy = Mage::helper('hackathon_visibleadminupgrade');

        if ( isset($this->_args['display']) ) {
            $pending = $helpy->checkForPendingScripts();
            echo json_encode($pending, JSON_PRETTY_PRINT)."\n";
        }

        if ( isset($this->_args['run']) ) {
            Mage::getConfig()->setNode(Mage_Core_Model_App::XML_PATH_SKIP_PROCESS_MODULES_UPDATES, false);
            $helpy->coreUpdateAll();
        }

    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        echo <<<USAGE
Usage:  php -f runUpdates.php -- 
run - Run pending updates;
display - Display pending updates
USAGE;
    }
}

$shell = new Mage_Shell_RunUpdates();
$shell->run();

