<?php
/**
 * @package Slide Out Box Module
 * @version 1.0
 * @license GPLv2
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

// Get variable values from the parameters
$scroll_depth = $params->get('scroll_depth', 50);
$cookie_expire = $params->get('cookie_expire', 7);
$show_once_session = $params->get('show_once_session', 0);
$exclude_queries = $params->get('exclude_queries', '');
$show_heading = $params->get('show_heading', 0);
$heading_tag = $params->get('heading_tag', 'h2');
$heading = $params->get('heading', '');
$main_text = $params->get('main_text', '');
$show_button = $params->get('show_button', 0);
$button_text = $params->get('button_text', '');
$button_url = $params->get('button_url', '');
$prepare_content = $params->get('prepare_content', 0);

// Check query exclusion
if ($exclude_queries) 
  {  
    $uri = Uri::getInstance();
    $query = $uri->getQuery();
    $exclude = array_map('trim', explode(',', $exclude_queries));
    foreach ($exclude as $string) {
        if ($string && strpos($query, $string) !== false) {
            return; // Don't show the Slideoutbox if query string contains excluded term
        }
    }
}

// Check session variable for show once per session functionality
if ($show_once_session) {
    $session = Factory::getSession();
    $sessionKey = 'mod_slideoutbox_seen_' . $this->module->id;
    if ($session->get($sessionKey)) {
        return; // Skip rendering if already seen this session
    }
    $session->set($sessionKey, 'seen'); // Mark as seen
}

//Get the Web Asset Manager
$document = Factory::getApplication()->getDocument();
$wa = $document->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('mod_slideoutbox');

// Load module assets
$wa->useScript('mod_slideoutbox.slideoutbox');
$wa->useStyle('mod_slideoutbox.slideoutbox');

// Hide the module title
$this->module->showtitle = 0;

// Pass parameters to JavaScript
$options = [
    'scrollDepth' => (int)$scroll_depth,
    'cookieExpire' => (int)$cookie_expire,
    'moduleId' => $this->module->id
];
$document->addScriptOptions('mod_slideoutbox', $options);

//Prepare the Slideoutbox output
$heading_html = '';
$main_text_html = '';
$button_html = '';

if ($show_heading && $heading) {
    $heading_html = '<' . htmlspecialchars($heading_tag, ENT_QUOTES, 'UTF-8') . '>' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</' . htmlspecialchars($heading_tag, ENT_QUOTES, 'UTF-8') . '>';
}

if ($main_text) {
    $main_text_html = $prepare_content ? HTMLHelper::_('content.prepare', $main_text) : $main_text;
    $main_text_html = '<div class="sbox-content">' . $main_text_html . '</div>';
}

if ($show_button && $button_text && $button_url) {
    $button_html = '<a class="btn" href="' . htmlspecialchars($button_url, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($button_text, ENT_QUOTES, 'UTF-8') . '</a>';
}
?>

<div class="sbox">
    <div id="sbox-<?php echo $this->module->id; ?>">
        <a class="close"></a>
        <?php echo $heading_html; ?>
        <?php echo $main_text_html; ?>
        <?php echo $button_html; ?>
    </div>
</div>