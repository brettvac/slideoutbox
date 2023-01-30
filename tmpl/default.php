<?php
// no direct access
defined('_JEXEC') or die;

$config = Joomla\CMS\Factory::getConfig();
$siteName = $config->get('sitename');
$document = Joomla\CMS\Factory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_slideoutbox/css/mod_slideoutbox.css');

$input = Joomla\CMS\Factory::getApplication()->input;
$view = $input->get('view');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

use Joomla\CMS\WebAsset\WebAssetManager;

$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('jquery');


?>
<div id="last"></div>
<div id="slidebox">
    <a class="close"></a>
    <?php 
            //Get the module
            $module_id = $params->get('module_id');
            // Load the module
            $module = JModuleHelper::getModuleById($module_id);
            // Display the module's content
            echo JModuleHelper::renderModule($module);
        ?>
</div>
<?php 
$document = JFactory::getDocument();
$document->addScript(JURI::base() . 'modules/mod_slideoutbox/js/slider.js');
?>