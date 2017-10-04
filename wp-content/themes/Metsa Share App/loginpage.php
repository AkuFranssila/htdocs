<?php /* Template Name: Login_page */ ?>

<?php get_header(); ?>


    <div class="app-container">
        <div id="login-logo">
        </div>
        <div class="login-info">
            
            <form>
                <input class="username" type="text" value="Username">
                <br>
                <input class="password" type="text" value="Password">
                <br>
                <input class="login-button" type="submit" value="Login">
            </form>
        </div>
    </div>
	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>