<?php define('SITE', 'Bonjour!');

/**
* Reset-Site
*
* Reset-Site
* 
* @version 1.0
* @author Vaska
*/

// turn this on if you want to check things
//error_reporting(E_ALL);

require_once 'defaults.php';
require_once 'common.php';
require_once './config/config.php';
require_once './helper/time.php';

$db = load_class('db', TRUE, 'db');

// find the root page
$page = $db->fetchRecord("SELECT * FROM ".PX."objects WHERE url = '/'");

if (!$page)
{
	// means the page was deleted...add it back
	// get any section for this part
	$sect = $db->fetchRecord("SELECT * FROM ".PX."sections");

	// put it back
	$db->query("INSERT INTO `".PX."objects` (`id`, `object`, `obj_ref_id`, `title`, `content`, `tags`, `header`, `udate`, `pdate`, `creator`, `status`, `process`, `page_cache`, `section_id`, `url`, `ord`, `color`, `bgimg`, `hidden`, `current`, `images`, `thumbs`, `format`, `break`, `tiling`, `year`, `report`) VALUES (1, 'exhibit', 0, 'Main', '<p>Edit this page.</p>', '0', '', '".getNow()."', '".getNow()."', 1, 1, 1, 0, '" . $sect['secid'] . "', '/', 999, 'ffffff', '', 0, 0, 400, 100, 'grow', 0, 1, '2009', 0)");
	
	$note = "We recreated the main page of your site - it should be ok now.";
}
else
{
	// let's make sure the section for page exists
	$sect = $db->fetchRecord("SELECT * FROM ".PX."sections WHERE secid = '" . $page['section_id'] . "'");
	
	if (!$sect)
	{
		// get any section
		$sect2 = $db->fetchRecord("SELECT * FROM ".PX."sections");
		
		// update the record with it
		$db->query("UPDATE ".PX."objects SET section_id = '" . $sect2['secid'] . "' WHERE url = '/'");
		$note = "We update the main page with an active section - it should be ok now.";
	}
	else
	{
		$note = "Everything looked just fine - nothing was changed.";
	}
}

echo $note;
exit;