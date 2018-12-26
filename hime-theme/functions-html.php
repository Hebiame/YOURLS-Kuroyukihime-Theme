<?php

/**
 * Display HTML head and <body> tag
 *
 * @param string $context Context of the page (stats, index, infos, ...)
 * @param string $title HTML title of the page
 */
function hime_html_head( $context = 'index', $title = '' )
{

	yourls_do_action( 'pre_html_head', $context, $title );

	// All components to false, except when specified true
	$share = $insert = $tablesorter = $tabs = $cal = $charts = false;

	// Load components as needed
	switch ( $context ) {
		case 'infos':
			$share = $tabs = $charts = true;
			break;

		case 'bookmark':
			$share = $insert = $tablesorter = true;
			break;

		case 'index':
			$insert = $tablesorter = $cal = $share = true;
			break;

		case 'plugins':
		case 'tools':
			$tablesorter = true;
			break;

		case 'install':
		case 'login':
		case 'new':
		case 'upgrade':
			break;
	}

	// Force no cache for all admin pages
	if( yourls_is_admin() && !headers_sent() ) {
		header( 'Expires: Thu, 23 Mar 1972 07:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
		header( 'Pragma: no-cache' );
		yourls_content_type_header( yourls_apply_filter( 'html_head_content-type', 'text/html' ) );
		yourls_do_action( 'admin_headers', $context, $title );
	}

	// Store page context
	yourls_set_html_context($context);

	// Body class
	$bodyclass = yourls_apply_filter( 'bodyclass', '' );
	$device = yourls_is_mobile_device() ? 'mobile' : 'desktop';
	$bodyclass .= $device;

	// Page title
	$_title = HTML_TITLE;
	$title = $title ? $title . " &laquo; " . $_title : $_title;
	$title = yourls_apply_filter( 'html_title', $title, $context );

	?>
<!DOCTYPE html>
<html <?php yourls_html_language_attributes(); ?>>
<head>
	<title><?php echo $title ?></title>
	<?php yourls_do_action('html_head_meta', $context); ?>
	<meta http-equiv="Content-Type" content="<?php echo yourls_apply_filter( 'html_head_meta_content-type', 'text/html; charset=utf-8' ); ?>" />
	<meta name="author" content="Hebiame, Kenstin">
	<meta name="keywords" content="awesome, hime, url, shortener">
	<meta name="description" content="Awesome Hime URL Shortener at <?php yourls_site_url(); ?>" />
	<meta name="referrer" content="always" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
	<link rel="icon" type="image/png" href="/hime-theme/img/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="/hime-theme/img/favicon-16x16.png" sizes="16x16" />
	<link rel="stylesheet" href="<?php yourls_site_url(); ?>/hime-theme/styles/main.css" type="text/css" media="screen" />
	<script src="<?php yourls_site_url(); ?>/js/jquery-2.2.4.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<script src="<?php yourls_site_url(); ?>/js/common.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<script src="<?php yourls_site_url(); ?>/js/jquery.notifybar.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php if ( $device == 'mobile' ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/hime-theme/styles/mobile.css" type="text/css" media="screen" />
	<?php } else { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/hime-theme/styles/desktop.css" type="text/css" media="screen" />
	<?php } ?>
	<?php if ( $tabs ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/infos.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/infos.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $tablesorter ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/tablesorter.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/jquery.tablesorter.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $insert ) { ?>
		<script src="<?php yourls_site_url(); ?>/js/insert.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $share ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/hime-theme/styles/share.css" type="text/css" media="screen" />
		<script src="<?php yourls_site_url(); ?>/js/share.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
		<script src="<?php yourls_site_url(); ?>/js/clipboard.min.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $cal ) { ?>
		<link rel="stylesheet" href="<?php yourls_site_url(); ?>/css/cal.css?v=<?php echo YOURLS_VERSION; ?>" type="text/css" media="screen" />
		<?php yourls_l10n_calendar_strings(); ?>
		<script src="<?php yourls_site_url(); ?>/js/jquery.cal.js?v=<?php echo YOURLS_VERSION; ?>" type="text/javascript"></script>
	<?php } ?>
	<?php if ( $charts ) { ?>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
					 google.load('visualization', '1.0', {'packages':['corechart', 'geochart']});
			</script>
	<?php } ?>
	<script type="text/javascript">
	//<![CDATA[
		var ajaxurl  = '<?php echo yourls_admin_url( 'admin-ajax.php' ); ?>';
	//]]>
	</script>
	<?php yourls_do_action( 'html_head', $context ); ?>
</head>
<body class="<?php echo $context; ?> <?php echo $bodyclass; ?>">
<main>
	<div id="thanks-section">
		<ul>Thanks <span style="font-size: 30px">&#10084</span>
			<li>Filip, Aleksandra</li>
		</ul>
	</div> 
	<?php
}

/**
 * Display HTML footer (including closing body & html tags)
 *
 * Function yourls_die() will call this function with the optional param set to false: most likely, if we're using yourls_die(),
 * there's a problem, so don't maybe add to it by sending another SQL query
 *
 * @param  bool $can_query  If set to false, will not try to send another query to DB server
 * @return void
 */
function hime_html_footer($can_query = true) {
	?>
	</main>
	<footer id="footer" role="contentinfo">
		<ul>
			<li><a href="https://pomf.hebia.me">Hime Pomf</a></li>
			<li><a href="#">Paste</a></li>
			<li><a href="/">URL Shortener</a></li>
		</ul>
		<?php
		$footer  = yourls_s( '' );
		echo yourls_apply_filter( 'html_footer_text', $footer );
		?>
	</footer>
	<?php if( defined( 'YOURLS_DEBUG' ) && YOURLS_DEBUG == true ) {
		echo '<div style="text-align:left"><pre>';
		echo join( "\n", yourls_get_debug_log() );
		echo '</div>';
	} ?>
	<?php yourls_do_action( 'html_footer', yourls_get_html_context() ); ?>
	</body>
	</html>
	<?php
}

/**
 * Display HTML form for URL shorting
 *
 * @return void
 */
function hime_html_form() {
	$site = YOURLS_SITE;
	echo <<<HTML
	<section class="main-content">
	<h2>Enter a new URL to shorten</h2>
	<form method="post" action="">
		<label class="long-url"><input id="long-url-in" type="text" class="text" name="url" value="" /></label>
		<p><label class="short-url">Optional custom short URL: $site/<input id="short-url-in" type="text" class="text" name="keyword" /></label></p>
		<input type="submit" class="button primary" value="Shorten" />
	</form>
	</section>
HTML;
}

/**
 * Display page for short link
 *
 * @return void
 */
function hime_html_share_page( $longurl, $shorturl, $title = '', $text='', $shortlink_title = '', $share_title = '', $hidden = false ) {

	$shortlink_title = '<h2>' . yourls__( 'Your short link' ) . '</h2>';
?>
<section class="main-content">
	<div id="shareboxes" <?php echo $hidden; ?>>
		<?php yourls_do_action( 'shareboxes_before', $longurl, $shorturl, $title, $text ); ?>

		<div id="copybox" class="share">
		<?php echo $shortlink_title; ?>
			<p><input id="copylink" class="text" size="32" value="<?php echo yourls_esc_url( $shorturl ); ?>" readonly="true"/></p>
			<?php if( yourls_do_log_redirect() ) { ?>
			<input type="hidden" id="titlelink" value="<?php echo yourls_esc_attr( $title ); ?>" />
			<?php } ?>
			</p>
		</div>
		<?php yourls_do_action( 'shareboxes_middle', $longurl, $shorturl, $title, $text ); ?>
	</div>
</section>
<script>init_clipboard();</script>
<?php
}