<?php

function create_page( $message, $url='', $shorturl='', $title='', $text='' ) {
    switch ( $message ) {
        case 'Missing or malformed URL':
            missing_url();
            break;
        case 'URL is a short URL':
            url_is_short_url();
            break;
        case (preg_match("*already exists in database or is reserved*", $message) ? true : false):
	    short_url_exists_or_is_reserved();
	    break;
	case (preg_match("*added to database*", $message) ? true : false):
	    url_added_to_db( $url, $shorturl, $title, $text );
	    break;
	case 'Error saving url to database':
	    show_message( $message );
	    break;
	case (preg_match("*already exists in database*", $message) ? true : false):
	    long_link_already_exists( $url, $shorturl, $title, $text );
	    break;
        default:
	    show_message( $message );
	    break;
    }
}

function missing_url() {
    hime_html_form();
    echo( '<script>$( "#long-url-in" ).attr("placeholder", "Enter a proper link");</script>' );
}

function url_is_short_url() {
    hime_html_form();
    echo( '<script>$( "#long-url-in" ).attr("placeholder", "URL is a short URL");</script>' );
}

function short_url_exists_or_is_reserved() {
    hime_html_form();
    echo( '<script>$( "#short-url-in" ).attr("placeholder", "Already used");</script>' );
}

function url_added_to_db( $url, $shorturl, $title, $text ) {
    hime_html_share_page( $url, $shorturl, $title, $text );
}

function long_link_already_exists( $url, $shorturl, $title, $text ) {
    hime_html_share_page( $url, $shorturl, $title, $text );
}

function show_message( $message ) {
    echo('<section class="main-content"><h2>'.$message.'</h2></section>');
}