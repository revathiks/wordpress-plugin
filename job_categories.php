<?php
/**
 * Template Name: Job Category
 * The template for displaying event page.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package TM Atomlab
 * @since   1.0
 */
get_header();
?>
<div class="col-md-12" id="srm_banner" style="margin-bottom:1em;"></div>
<?php get_template_part( 'components/title-bar' ); ?>
	<div id="page-content" class="page-content srm-custom-page-content">
		<!--<div class="container">-->
		<div>
			<div class="row" id="srm_row_id">
				<?php Atomlab_Templates::render_sidebar( $page_sidebar_position, $page_sidebar1, $page_sidebar2, 'left' ); ?>
				
				
				<div class="srm-custom-post-main-content">
				
				<div class="col-md-12">
					<?php
					// Things that you want to do.
					$categoryargs = array(
					'taxonomy' => 'jobpost_category',
					'orderby' => 'ID',
					'order'   => 'DESC'
					);
					
					$jobpost_categorys = get_categories($categoryargs);
					?>
						<?php
            		       foreach ($jobpost_categorys as $jobpost_category) 
            		       {
            		           $joblink= get_category_link( $jobpost_category->term_id );
            			?>	
            			<a href="<?php echo $joblink; ?>">				
                        <div class="srm_job_post">					                     
                            <h3 class="h3col"><?php echo $jobpost_category->name; ?></h3>
							<img src="http://172.16.5.104/SRM-TECH-LIVE/wp-content/uploads/temp_icon.svg"/>
						 </div>
						 </a>
                        <?php } ?>
				</div>				 
                
				
				</div>

				<?php Atomlab_Templates::render_sidebar( $page_sidebar_position, $page_sidebar1, $page_sidebar2, 'right' ); ?>

			</div>
			
			<div class="row">
    			<div class="col-md-12">    			
    			<?php 
    			echo do_shortcode( '[jobpost]' );
    			?>
    			</div>
			</div>
		</div>
	</div>
<?php
get_footer();