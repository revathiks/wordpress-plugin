<?php
/**
 * 
 * Template Name: AboutUs
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
                    <div class="side-mb-tab">About Us</div>                  
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
										wp_nav_menu( $args );
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
                     <?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
               </div>
            </div>
         </div>
      </section>
<?php get_footer();
