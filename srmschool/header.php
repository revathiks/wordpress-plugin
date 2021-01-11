<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage srmschool
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SRM Public School Curriculum - Language Arts, Mathematics, Social Studies, Science, Physical Education, Visual & Performing arts." />
    <link rel="stylesheet" type="text/css" href="style.css">
	<script>
	   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	   
	   ga('create', 'UA-87956421-1', 'auto');
	   ga('send', 'pageview');
	   
	</script>

	<?php 
	wp_head();
	//wp_enqueue_script( 'select2', plugins_url( get_template_directory_uri().'/assets/css/select2.css', __FILE__ ));
	wp_enqueue_style( 'select2', get_stylesheet_directory_uri() . '/assets/css/select2.css' );
	wp_enqueue_script( 'select2.full.min', get_stylesheet_directory_uri() . '/assets/js/select2.full.min.js');
	
	?>
</head>

<body <?php body_class(); ?>>
   <header>   
    <div class="container">
        
		<!-- For admission left side div contion -->
		<?php
		$post_id = 608;
		$queried_post = get_post($post_id);
		if ($queried_post->post_status =='publish')
		{
		?>
		<a href="application-for-admission" class="floatAdmission"><?php echo $queried_post->post_content; ?></a>
		<?php } ?>
		<!-- End of admission left side div contion -->
		
        <a href="index.php" class="brand pull-left"> <?php the_custom_logo(); ?> </a>
        <button type="button" class="navbar-toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>
    </div>
   </header>
<script>
            $(document).ready(function () {
                $('select').select2();
            });
        </script>