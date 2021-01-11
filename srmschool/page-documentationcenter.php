<?php
/**
 * 
 * Template Name: Documentation Center
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

     <section class="sec-6 grid-inner-fix grid-bng-15">
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
      <section class="sec-7">
         <div class="container">
            <div class="row">
                  <div class="col-7">
                    <div class="side-mb-tab">Documentation Center</div>                  
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
				<?php
					//Get sub cat value..
					$catname = $_POST['category'];
					
					$categories=get_categories(
						array( 'parent' => '33' )
					);
					?>
					<div class="row page-title">
						<div class="colm-9 col7-2 gallery-tit">                        
							<h3><?php the_title(); ?></h3>
						</div>
						<div class="select_style">
							<select>
							<option value="">Select Category</option>
							<?php
							foreach($categories as $cat){
								$selected = '';
								if($cat->name == $catname){
									$selected="selected=selected";
								}
								echo "<option $selected value=$cat->name>$cat->name</option>";
							}
							?>
							</select>
						</div>	
				   </div>
					<?php
					// The Query
					query_posts( array ( 'category_name' => 'documents', 'posts_per_page' => 10 ) );
					?>
					
                <?php
				//The Loop..
				
					while ( have_posts() ) : the_post();
					if(isset($catname) && !empty($catname)){
						 if(in_category($catname))
							{
	
				?>	
					<section class="items has_sidebar">
						<div class="document-div list list_items not_in_carousel">
							<ul aria-labelledby="ListItems_list_labelledby_102813">
								<li class="autogen_class_views_shared_react_cells_document_cell object_cell list_item document visibility_tracked">
									<div class="document-inner react_cell_base">
										<div class="list_anchor_container">
											<div class="list_anchor" href="<?php the_permalink(); ?>">
												<div class="image">
													<div class="autogen_class_views_shared_react_document_image react_document_image">
													<?php if ( has_post_thumbnail() ) {
													the_post_thumbnail();
													} else { ?>
													<img src="<?php bloginfo('template_directory'); ?>/assets/images/news/img2.jpg" alt="<?php the_title(); ?>" />
													<?php } ?>
													<!--img alt="Proposed revised Richland 2 elementary attendance lines for 2011-2012" class="loaded" src="<?php the_post_thumbnail_url(); ?>"-->
													
													</div>
												</div>
                                                                                            </a>
												<div class="metadata">
													<a class="list_anchor" href="<?php the_permalink(); ?>"><div class="title document_title"><?php the_title(); ?></div></a>
													<div class="author_container"><span class="author"><?php the_content(); ?></span></div>
												</div>
                                                                                        </div>
											
										</div>
									</div>
								</li>
							</ul>
						</div>
					</section>
				<?php	
					}}else
					{
						?>
						<section class="items has_sidebar">
						<div class="document-div list list_items not_in_carousel">
							<ul aria-labelledby="ListItems_list_labelledby_102813">
								<li class="autogen_class_views_shared_react_cells_document_cell object_cell list_item document visibility_tracked">
									<div class="document-inner react_cell_base">
										<div class="list_anchor_container">
											<div class="list_anchor" >
                                                                                            <a href="<?php the_permalink(); ?>">
												<div class="image">
													<div class="autogen_class_views_shared_react_document_image react_document_image"><img alt="Proposed revised Richland 2 elementary attendance lines for 2011-2012" class="loaded" src="<?php the_post_thumbnail_url(); ?>"></div>
												</div>
                                                                                            </a>
												<div class="metadata">
                                                                                                    <a href="<?php the_permalink(); ?>"><div class="title document_title"><?php the_title(); ?></div></a>
													<div class="author_container"><span class="author"><?php the_content(); ?></span></div>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</section>
						<?php
						
					}
					endwhile; // End of the loop.
				// Reset Query
				wp_reset_query();
				?>
               </div>
            </div>
         </div>
      </section>
<form id="cat_form" method="POST" action="">
    <input type="hidden" name="category" class="category"></input>
</form>
<script>
$(document).ready(function(){
	$('select').on('change', function() {
	  $('.category').val(this.value);
	  $("#cat_form").submit();
	})
})
</script>
<?php get_footer();
