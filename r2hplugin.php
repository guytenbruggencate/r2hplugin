<?php
/**
 * @copyright	Copyright (c) 2015 R2H B.V. (http://www.r2h.nl). All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Content - R2Hplugin Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	R2HB.V..R2Hplugin
 */
class plgContentR2Hplugin extends JPlugin {

	protected $autoloadLanguage = true;

	/* Content plugin example */
	function onContentPrepare($context, $article, $params, $limitstart)
	{
		/* Load value from plugin XML params field */
		$r2h_textvalue = $this->params->get('r2htextvalue', 'Show this text is no value is defined!!!');

		/* Replace in article content [r2hreplacer] by any other text string from params */
		$article->text = str_replace('[r2hreplacer]', '<strong>' . $r2h_textvalue . '</strong>', $article->text);

		return true;
	}

	/* system plugin example */
	function onAfterRender()
	{

		/* Grab UA code from plugin XML params field */
		$web_property_id = $this->params->get('web_property_id', 'UA-XXXXXXX-X');

		$buffer = JResponse::getBody();
		$google_analytics_javascript = "
			<script type='text/javascript'>
  			var _gaq = _gaq || [];
  			_gaq.push(['_setAccount', '".$web_property_id."']);
  			_gaq.push(['_trackPageview']);
  				(function() {
    				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  				})();
			</script>";

		$buffer = str_replace ("</body>", $google_analytics_javascript."\n</body>", $buffer);

		/* Add comment before header */
		$buffer = str_replace ("</head>",  "<!-- comment before the head -->\n" . "</head>", $buffer);

		JResponse::setBody($buffer);

		return true;
	}

}