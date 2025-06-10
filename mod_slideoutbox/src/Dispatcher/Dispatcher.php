<?php
/**
 * @package Slide Out Box Module
 * @version 1.0
 * @license GPLv2
 */

namespace Naftee\Module\Slideoutbox\Site\Dispatcher;

\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\Input\Input;
use Joomla\Registry\Registry;

class Dispatcher implements DispatcherInterface
{
    protected $module;   
    protected $app;

    public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
    {
        $this->module = $module;
        $this->app = $app;
    }
    
    public function dispatch()
    {
        // Load module language
        $language = $this->app->getLanguage();
        $language->load('mod_slideoutbox', JPATH_SITE . '/modules/mod_slideoutbox');
        
        // Get the module parameters from manifest file
        $params = new Registry($this->module->params);

        // Load the layout
        require ModuleHelper::getLayoutPath('mod_slideoutbox', $params->get('layout', 'default'));
    }
}