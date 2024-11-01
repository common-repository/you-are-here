<?php
/*
Plugin Name: You Are Here
Version: 0.2
Plugin URI: http://dizque.lacalabaza.net/proyectos/wp/plugins/you-are-here/
Description: Replaces anchor elements pointing to the current document by span elements (adding class="u-r-here").
Author: Choan C. Galvez
Author URI: http://dizque.lacalabaza.net/
*/            

function ttyou_are_here($content) {
	$base = get_settings('siteurl');
	$uri = @$_SERVER['REQUEST_URI'];

	$replace = '#<a([^>]*)href=("|\')(' . $base . ')?' . $uri .'\\2([^>]*)>(.*?)</a>#iS';
	$content = preg_replace($replace, "<span $1 class=\"u-r-here\" $4>$5</span>", $content);	
	return $content;
}

function ttyou_are_here_return_false() {
	return false;
}

if(!strstr($_SERVER['REQUEST_URI'], '/wp-admin')) { // do not filter in admin section
	if (get_settings('gzipcompression')) { // if gzcompression is on, start that before
		gzip_compression();
		add_filter('option_gzipcompression', 'ttyou_are_here_return_false'); // return false to not start again
	}
	ob_start('ttyou_are_here');
}

?>