<?php
/**
 * 
 * Template Name: NewsandEvents
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
<script src="wp-content/themes/srmschool/assets/js/jscroll-master/jquery.jscroll.js"></script>
<section class="sec-6 grid-inner-fix grid-bng-7" >
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
    <section id="content" class="sec-7">
        <div class="container smart_scroll_container">
            <div class="row">
                <div class="col-7">
                    <div class="side-mb-tab">News / Announcements</div>
                     <?php
									$args = array(
										'title'			=> 'News and Events',
										'theme_location' => 'main',
                                        'menu_id'		 =>	'side-site-map',
                                        'container'     => 'div',
                                        'container_class' => 'menu-in',
										'submenu' => 'News and Events',
									);
										wp_nav_menu( $args );
						
						?>
                     <div class="col-7-row2">
                         <?php dynamic_sidebar( 'sidebar-1' ); ?>                                     
                     </div>
            </div>
                <div id="content"  class="col-7">  
				
				
                    <?php
						// set the "paged" parameter (use 'page' if the query is on a static front page)
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

						// the query
						$the_query = new WP_Query( 'category_name=news&paged=' . $paged ); 
						?>

						<?php if ( $the_query->have_posts() ) : ?>



					  <?php
						// the loop
						while ( $the_query->have_posts() ) : $the_query->the_post(); 
						?>						
						<div class="post">					                     
                        <h3 class="h3col"><?php the_title(); ?></h3>                                             
					
						<p class="txt-grid ">
						<?php the_content(); ?>
						</p>
						</div>
						<?php endwhile; ?>
						<div class="paginationList mar-top">
							<?php
							// next_posts_link() usage with max_num_pages							
							previous_posts_link( 'Newer Announcements' );
							next_posts_link( 'Older Announcements', $the_query->max_num_pages );
							?>
						</div>
						

						<?php 
						// clean up after our query
						wp_reset_postdata(); 
						?>

						<?php else:  ?>
						<p><?php _e( 'Sorry, no news or announcements matched your criteria.' ); ?></p>
					<?php endif; ?>
				
               </div>

			   
</div>
        </div>
    </section>
	
 <?php get_footer();
