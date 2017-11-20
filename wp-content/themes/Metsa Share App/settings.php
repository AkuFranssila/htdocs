<?php /* Template Name: Settings menu  */ ?>

<?php get_header(); ?>


    <div class="app-container">
        <?php 
                wp_nav_menu( array(
                'menu' => 'Settings menu'
                ) ); 
            ?>
        
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>