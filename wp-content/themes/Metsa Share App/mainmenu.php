<?php /* Template Name: Main_menu */ ?>

<?php get_header(); ?>


    <div class="app-container">
            
            <?php 
                wp_nav_menu( array(
                'menu' => 'Main menu'
                ) ); 
            ?>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>