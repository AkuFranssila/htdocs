<?php /* Template Name: Main_menu */ ?>

<?php get_header(); ?>

         
            <?php //prints the wordpress menu called "Main Menu" which has the create a report, reports, instructions and settings
                wp_nav_menu( array(
                'menu' => 'Main menu'
                ) ); 
            ?>
	<main role="main">

	</main>


<?php get_footer(); ?>