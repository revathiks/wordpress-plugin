<?php
/**
 * 
 * Template Name: Testimonials
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

     <section class="sec-6 grid-inner-fix grid-bng-1">
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
      <section class="sec-7">
         <div class="container">
            <div class="row">
                  <div class="col-7">
                    <div class="side-mb-tab">Testimonials</div>                  
					<?php
									/*$menu_items = wp_get_nav_menu_items( 'Main Menu' );
									$this_item = current( wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) ) );
									
									
									$list = wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) );
									
									print_r($list);exit;
									$parent_menu = $this_item->menu_item_parent;	
									echo $parent_menu;
									$child = wp_get_nav_menu_items($parent_menu);
									print_r($child);
									$arr = wp_get_menu_array( 'Main Menu');
									print_r($arr);*/
									
									$args = array(
										'title'			=> 'AboutUs',
										'theme_location' => 'main',
                                        'menu_id'		 =>	'side-site-map',
                                        'container'     => 'div',
                                        'container_class' => 'menu-in',
										'submenu' => 'About Us',
									);
										//wp_nav_menu( $args );
									/*$menu_items = wp_get_nav_menu_items( 'Main Menu' );
									$this_item = current( wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) ) );
									$parent_menu = $this_item->menu_item_parent;	
									echo $parent_menu;
									$child = wp_get_nav_menu_items($parent_menu);
									print_r($child);exit;*/
									
									/*$activePagename = basename(get_permalink());
									$primaryNav = wp_get_nav_menu_items('Main Menu');
									print_r($primaryNav);exit;
									foreach ( $primaryNav as $navItem ) {
										$pagename = basename($navItem->url); 
										if($pagename == $activePagename):
										   $active = 'active2';
									   else:
										   $active = '';
									   endif;
									 echo '<li><a href="'.$navItem->url.'" title="'.$navItem->title.'" class="aw '.$active.'">'.$navItem->title.'</a></li>';
								   }  */
							?>
                    
                   <!-- Watch Video -->
                   <?php dynamic_sidebar( 'sidebar-3' );
							
				   ?>
                </div>
               <div class="col-7">   
					<div class="row">
						<div class="colm-9 col7-2 gallery-tit">                        
							<h3><?php the_title(); ?></h3>
						</div>	
				   </div>
					<?php
					// The Query
					query_posts( array ( 'category_name' => 'testimonials', 'posts_per_page' => 10 ) );
					?>
					
                <?php
				//The Loop..
				
					while ( have_posts() ) : the_post();
						?>
						<section class="items has_sidebar txt-wrap">
							<h4 class="margin-collapse"><?php echo get_post_meta(get_the_ID(), 'event-link-label', true); ?></h4>
							<div class="mydiv"><?php the_content(); ?></div>
						</section>
						<?php
					endwhile; // End of the loop.
				// Reset Query
				wp_reset_query();
				?>
               </div>
            </div>
         </div>
      </section>

<?php get_footer();
