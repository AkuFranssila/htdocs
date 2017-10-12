<?php /* Template Name: Instructions */ ?>

<?php get_header(); ?>


    <div class="app-container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
the_content();
endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>