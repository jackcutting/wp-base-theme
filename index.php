<!DOCTYPE html>
<head>

	<title><?php wp_title(); ?></title>

	<meta name="viewport" content="width=device-width">

	<?php wp_head(); ?>

</head>
<body <?php echo body_class(); ?>>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<h1><?php the_title(); ?></h1>
	
		<?php the_content(); ?>
	
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; wp_reset_query(); ?>

<?php wp_footer(); ?>

</body>
</html>