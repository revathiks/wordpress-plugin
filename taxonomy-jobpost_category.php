<?php
/**
 * Template Name: News and Events
 * The template for displaying event page.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package TM Atomlab
 * @since   1.0
 */
get_header();
?>	
<?php get_template_part( 'components/title-bar' ); ?>
	<div id="page-content" class="page-content srm-custom-page-content">
		<!--<div class="container">-->
		   <div>
			<?php
			global $post;
			$paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
			$perpage = 9;
			$currentYear = date("Y"); 
			$postcat = get_queried_object();
			$postTermTaxonomy_id = $postcat->term_taxonomy_id;
			$postTermTaxonomy_slug = $postcat->slug;			
			?>
					
			<!-- banner and desc -->
        	<div class="row">
				<div class="col-md-12 cat-img-desc">
					<?php 
					 $catDesc= category_description($postTermTaxonomy_id);
					?>
					<div class="col-md-6" id="custom-job-desc">
					<h3><?php echo  $postcat->name;?></h3>
						<?php 
						echo $catDesc;
						?>
					</div>
					<div class="col-md-6">			
						<img src="<?php echo z_taxonomy_image_url($postTermTaxonomy_id); ?>" />
					</div>
					
				</div>
        	</div>
            <!-- end banner and desc -->	
			<div class="row" id="srm_row_id">
				<?php Atomlab_Templates::render_sidebar( $page_sidebar_position, $page_sidebar1, $page_sidebar2, 'left' ); ?>
				
				<!--<div class="page-main-content">-->
				<div class="srm-custom-post-main-content">
				<div class="col-md-12">
				<div><h3>Find Opportunities</h3></div>
					<div class="archivesS-category">		
						<div class="archivesS colm-7">
							<div class="srm_select_style">
									<?php
									
									$tax_query=array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'jobpost_category',
											'field'    => 'slug',
											'terms'    => $postTermTaxonomy_slug,
											
										),
									);
								
									$arg = array(                                  
										'post_type' => 'jobpost',
										'post_status'=>'publish',
										'posts_per_page' => $perpage,
										'paged' => $paged,                                    
										'tax_query'=>$tax_query,
										'order' => 'DESC',
									);									
									$pageposts = new WP_Query($arg);  
									
									/*   print_r($pageposts);
									echo $wpdb->last_query */;
								
									?>
									
								</div>
							
						</div>
					</div> 	
					<?php               
					if ($pageposts->have_posts()) :
                    // the loop
                    while ($pageposts->have_posts()) : $pageposts->the_post();
                     $post_date = get_the_date( 'd-m-Y' ); 
					?>
                        <a href="<?php the_permalink(); ?>">						
                        <div class="srm_job_post_section">	
                       		<div class="srm-job-date"><?php echo $post_date;?> </div>				                     
                            <h3 class="h3col"><?php the_title(); ?></h3>
							<div class="srm-job-location">
							<?php 
							$post_id = get_the_id();
							$locations = wp_get_post_terms($post_id, 'jobpost_location');
							$location = $locations[0]->name ??  'NA';
							$location = $location ?? 'NA';
							echo $location;
							?>
							
							</div>					
                        	<div class="blue-lin-3"></div>
                        </div>
                        </a>
                        <?php
                    endwhile;
                    echo "<div class='paginationListSRM'>";
                    $big = 999999999; // need an unlikely integer
                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $pageposts->max_num_pages,
                        'add_args' => array('cpage' => "cGFnZQ=="),
                    ));
                    echo "</div>";
                    // clean up after our query
                    wp_reset_postdata();
                    ?>
				</div>				 
                <?php else: ?>
                    <p class="srm_no_record_found"><?php _e('Sorry, no record found.'); ?></p>
                <?php endif; ?>
				 <!-- End dynamic code -->
				</div>

				<?php Atomlab_Templates::render_sidebar( $page_sidebar_position, $page_sidebar1, $page_sidebar2, 'right' ); ?>

			</div>
		</div>
	</div>
<?php
get_footer();