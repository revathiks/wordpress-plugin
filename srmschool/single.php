<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

  <section class="sec-6 grid-inner-fix grid-bng-7">
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
   
    <section class="sec-7">
        <div class="container">
            <div class="row">
                <div class="col-7">                    
                    <div class="menu-in">
                       <?php dynamic_sidebar("sidebar-4"); ?>
                    </div>
                     <div class="col-7-row2">
                         <?php dynamic_sidebar( 'sidebar-1' ); ?>                                     
                     </div>
            </div>
                <div class="col-7">                                   
			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					/*if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					the_post_navigation( array(
						'prev_text' => '<span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'srmschool' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . srmschool_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
						'next_text' => '<span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'srmschool' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . srmschool_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
					) );*/

				endwhile; // End of the loop.
			?>

	      </div>
        </div>
    </section>

<?php get_footer();
