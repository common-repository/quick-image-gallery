<?php
/*
Plugin Name: Quick Image Gallery
Plugin URI: http://quick-plugins.com/quick-image-gallery/
Description: If you can read this then the plugin is already working. 
Version: 1.2.1
Author: fisicx
Author URI: http://quick-plugins.com/
*/

add_action('init', 'qig_setup');
add_action('wp_head', 'qig_head_script');
add_filter('wp_get_attachment_link', 'qig_gallerylinks');
add_filter('the_content', 'qig_imagelinks');
add_filter('plugin_action_links', 'qig_plugin_action_links', 10, 2 );
add_shortcode('qig', 'qig_imagelinks');

if (is_admin()) require_once( plugin_dir_path( __FILE__ ) . '/settings.php' );

function qig_plugin_action_links($links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$qig_links = '<a href="'.get_admin_url().'options-general.php?page=quick-image-gallery/settings.php">'.__('Settings').'</a>';
		array_unshift( $links, $qig_links );
		}
	return $links;
	}
function qig_setup() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('qig_script', plugins_url('js/imagebox.js', __FILE__));
	wp_enqueue_style( 'qig_style', plugins_url('quick-image-gallery.css', __FILE__));
	}
function qig_head_script() {
	$qig = qig_get_stored_settings ();
	$code = '<script type="text/javascript">';
	if ($qig['caption'] =='usetitle') $code .= 'jQuery(".imagebox").imagebox({beforeShow: function(){this.title = jQuery(this.element).find("img").attr("title");}});';
	if ($qig['caption'] =='usealt'  ) $code .= 'jQuery(".imagebox").imagebox({beforeShow: function(){this.title = jQuery(this.element).find("img").attr("alt");}});';
	if ($qig['caption'] =='usenone' ) $code .= 'jQuery(".imagebox").imagebox({helpers:{title:false}});';
	$code .= '</script>';
	echo $code;
	}
function qig_imagelinks($content) {
	global $post;
	$qig = qig_get_stored_settings ();
	if ($qig['images'] || $qig['select']) {
		$pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)/i";
		$replacement = '<a$1href=$2$3.$4$5 class="imagebox" rel="group" $6';
		$content = preg_replace($pattern, $replacement, $content);
		}
	return $content;
	}
function qig_gallerylinks($link) {
	global $post;
	$qig = qig_get_stored_settings ();
	if ($qig['gallery']) {
		$link = str_replace('<a href', '<a class="imagebox" rel="group" href', $link);
		}
	return $link;
	}
function qig_get_stored_settings () {
	$qig = get_option('qig');
	if(!is_array($qig)) $qig = array();
	$default = qig_get_default_settings();
	$qig = array_merge($default, $qig);
	return $qig;
	}
function qig_get_default_settings () {
	$qig = array();
	$qig['images'] ='checked';
	$qig['gallery'] ='checked';
	$qig['select'] ='';
	$qig['caption'] ='usetitle';
	return $qig;
	}
