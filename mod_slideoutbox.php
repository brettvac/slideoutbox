<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// no direct access
defined('_JEXEC') or die;

$app = Factory::getApplication();

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require ModuleHelper::getLayoutPath('mod_slideoutbox', $params->get('layout', 'default'));
?>