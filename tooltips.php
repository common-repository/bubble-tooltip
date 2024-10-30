<?php
/*
Plugin Name: Nice Tooltips
Plugin URI: http://bueltge.de/wp-bubble-tooltips-plugin/142/
Description: Nice Tooltips for Links.
Version: 2.2
Author: Frank B&uuml;ltge
Author URI: http://bueltge.de/
*/

/*
------------------------------------------------------
 ACKNOWLEDGEMENTS
------------------------------------------------------
Javascript for Bubble Tooltips is from Alessandro Fulciniti - http://pro.html.it - http://web-graphics.com
More informations to the script - http://web-graphics.com/mtarchive/001717.php

Javascript for Sweet Titles is from Dustin Diaz - http://www.dustindiaz.com/
More informations to the script - http://www.dustindiaz.com/sweet-titles/
/*

/*
------------------------------------------------------
INSTRUCTION:
------------------------------------------------------
1. Define the tooltip, bubble or sweet in line 35
2. Copy the folder with the php-, gif-, css- and the js-file in your Plugin-Folder (/wp-content/plugins/)
3. Activate this Plugin in the Admin-area
4. [Optional] Edit in line 86 of js/BubbleTooltips.js. You can change the ID of function the tooltip or
without ID - example without ID, for the complate site: enableTooltips();
with ID - example with ID content: enableTooltips("content"}.
*/


// Edit here, Define tooltip, 1 for Bubble Tooltips, 0 for Sweet Titles
define( 'FB_TT_BUBBLE', 1 );


//avoid direct calls to this file, because now WP core and framework has been used
if ( !function_exists('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if ( !class_exists('nice_tooltips') ) {

	class nice_tooltips {
		
		function nice_tooltips() {
			
			if ( is_admin() )
				return;
			
			if ( 1 == (int) FB_TT_BUBBLE ) {
				wp_register_script( 'bubble-tooltips', $this->get_plugins_url( 'js/BubbleTooltips.js', __FILE__ ), '', 0.1, TRUE );
				wp_enqueue_script( array( 'bubble-tooltips' ) );
				
				wp_enqueue_style( 'bubble-tooltips', $this->get_plugins_url( 'css/bt.css', __FILE__ ) );
			} else {
				wp_register_script( 'add-event', $this->get_plugins_url( 'js/addEvent.js', __FILE__ ), '', 0.1, TRUE );
				wp_register_script( 'sweet-titles', $this->get_plugins_url( 'js/sweetTitles.js', __FILE__ ), array('add-event'), 0.1, TRUE );
				wp_enqueue_script( array( 'sweet-titles' ) );
				
				wp_enqueue_style( 'sweet-titles', $this->get_plugins_url( 'css/sweetTitles.css', __FILE__ ) );
			}
		}
		
		// function for WP < 2.8
		function get_plugins_url($path = '', $plugin = '') {
			
			if ( function_exists('plugin_url') )
				return plugins_url($path, $plugin);
			
			if ( function_exists('is_ssl') )
				$scheme = ( is_ssl() ? 'https' : 'http' );
			else
				$scheme = 'http';
			if ( function_exists('plugins_url') )
				$url = plugins_url();
			else 
				$url = WP_PLUGIN_URL;
			if ( 0 === strpos($url, 'http') ) {
				if ( function_exists('is_ssl') && is_ssl() )
					$url = str_replace( 'http://', "{$scheme}://", $url );
			}
		
			if ( !empty($plugin) && is_string($plugin) )
			{
				$folder = dirname(plugin_basename($plugin));
				if ('.' != $folder)
					$url .= '/' . ltrim($folder, '/');
			}
		
			if ( !empty($path) && is_string($path) && ( FALSE === strpos($path, '..') ) )
				$url .= '/' . ltrim($path, '/');
		
			return apply_filters('plugins_url', $url, $path, $plugin);
		}

	} // end class
	
	function nice_tooltips_start() {
	
		new nice_tooltips();
	}
	// hook in WP
	add_action( 'plugins_loaded', 'nice_tooltips_start' );
} // end if class_exists
?>