<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black" rel="stylesheet"> <!-- Custom google font for the page -->
        <!-- FOR SEARCH STUFF -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script> <!-- jQuery UI for canvas -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
        <!-- FOR SEARCH STUFF -->
        
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/barba.js/1.0.0/barba.min.js" type="text/javascript"></script>

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        Barba.Pjax.start();    
        </script>
        <script>
function openNav() {
    document.getElementById("mySidenav").style.width = "50%"; 
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
	</head>
	<body <?php body_class(); ?>>
        <div id="barba-wrapper">
  <div class="barba-container">
    <div class="static-background">
		<!-- wrapper -->
		<div class="wrapper">

			<!-- header -->
			<header class="header clear" role="banner">

					<!-- logo -->
					<div class="logo">
						<a href="<?php echo home_url(); ?>">
							<!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
							<img class="menu-logo" src="<?php echo get_template_directory_uri(); ?>/img/HORIZONTAL_LOGO.png" alt="Logo" class="logo-img">
						</a>
					</div>
                
                    <div class="burgermenu">
                            <span class="burgermenu-span" onclick="openNav()">☰</span> <!-- Burger icon for sidebar menu  -->
                    </div>
					<!-- /logo -->
                    <!-- SIDENAV -->
                    <div id="mySidenav" class="sidenav"> <!-- Sidenav div that opens -->
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> <!-- Close sidebar icon  -->
                        <a class="logout-link" href="<?php echo get_page_link(101); ?>">Map</a>  <!-- Link to map -->
                        <a class="logout-link" href="http://www.metsagroup.com/fi/Pages/default.aspx">Metsä Group</a> <!-- Link to metsägroup  -->
                        <a class="logout-link" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a> <!-- Logs out the user from wordpress  -->
                    </div>
                    <!-- SIDENAV END -->

			</header> 
			<!-- /header -->
