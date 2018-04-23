<?php

require_once( dirname(__FILE__).'/includes/load-yourls.php' );
require_once "hime-theme/functions-html.php";
require_once "hime-theme/functions-messages.php";
require_once "hime-theme/config.php";

$page = YOURLS_SITE . '/index.php' ;

// Part to be executed if FORM has been submitted
if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

	// Get parameters -- they will all be sanitized in yourls_add_new_link()
	$url     = $_REQUEST['url'];
	$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
	$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
	$text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;

	// Create short URL, receive array $return with various information
	$return  = yourls_add_new_link( $url, $keyword, $title );
	
	$shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
	$message  = isset( $return['message'] ) ? $return['message'] : '';
	$title    = isset( $return['title'] ) ? $return['title'] : '';
	$status   = isset( $return['status'] ) ? $return['status'] : '';
}

hime_html_head();

if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {
	if( isset( $message ) ) {
		create_page( $message, $url, $shorturl, $title, $text );
	}
} else {
	hime_html_form();
}

hime_html_footer();	
