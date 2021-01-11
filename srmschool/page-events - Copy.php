<?php
/**
 * 
 * Template Name: Events
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
<section class="sec-6 grid-inner-fix grid-bng-16">
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
    <section class="sec-7">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div class="side-mb-tab">Events</div>
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
                <div class="col-7">   
			   <div class="txt-wrap">
			   <?php
				$lastposts = get_posts( array(
					//'posts_per_page' => 3,
					//'category' => 4
					'post_type' => 'event'
				) );
			 
				if ( $lastposts ) {
				foreach ( $lastposts as $post ) :
				setup_postdata( $post ); 

				?>
				<h3 class="h3col"><?php the_title(); ?></h3>
				<?php
				if (get_the_post_thumbnail($post->ID)!='')
				{
					echo  get_the_post_thumbnail($post->ID,array(300, 300)); 
				}
				else
				{ 
				?>				
				<img src="wp-content/themes/srmschool/assets/images/news/img2.jpg"  alt="SRM Public school">
				<?php } ?>
				<p class="txt-grid"><?php the_content(); ?></p>
				<?php				
				 endforeach; 
				 wp_reset_postdata();
				}
				?>
			   </div>

        </div>
    </section>
 <?php get_footer();
