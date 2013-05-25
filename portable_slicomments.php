<?php
/**
 * @package		sliComments
 * @subpackage	Content Plugin
 * @license		GNU General Public License version 3; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');
JLoader::register('sliComments', JPATH_SITE.'/components/com_slicomments/helper.php');

/**
 * Portable sliComments Plugin
 *
 * @package		sliComments
 * @subpackage	Content Plugin
 * @since		1.0
 */
class plgContentPortable_slicomments extends JPlugin
{
	/**
	 * Plugin that cloaks all emails in content from spambots via Javascript.
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	mixed	An object with a "text" property or the string to be cloaked.
	 * @param	array	Additional parameters. See {@see plgEmailCloak()}.
	 * @param	int		Optional page number. Unused. Defaults to zero.
	 * @return	boolean	True on success.
	 */
	public function onContentPrepare($context, &$item, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer' || strpos($item->text, '{slicomments}') === false) {
			return true;
		}

		$item->text = preg_replace('/{slicomments}/i', sliComments::commentify(compact('item', 'params')), $item->text, 1);

		$params = new JRegistry($item->attribs);
		$params->set('slicomments.enabled', false);
		$item->attribs = (string) $params;
	}
}
