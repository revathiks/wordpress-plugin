<?php
/**
 * 
 * Template Name: ApplyOnline
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <section class="sec-6 grid-inner-fix grid-bng-2">
         <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2>
         </div>
      </section>
 <section class="sec-7">
         <div class="container">
            <div class="row">
               <div class="col-7">
              <?php dynamic_sidebar( 'footer-8' ); ?>
                  <!--Admission -->
                  <div class="col-7-row2"><?php dynamic_sidebar( 'sidebar-1' ); ?> </div>
                   <!-- Watch Video -->
                   <?php dynamic_sidebar( 'sidebar-3' ); ?>
               </div>
               <div class="col-7">
				<?php if(is_page( 'thank-you' )): 
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/page/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
			
				 else:
					echo do_shortcode('[cr_online_registration]');
				endif;
			  ?>
               </div>
            </div>
         </div>
      </section>     
<?php get_footer();