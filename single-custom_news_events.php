<?php

/**
 * The template for displaying all single custom news and events posts.
 *
 * @package TM Atomlab
 * @since   1.0
 */

get_header();
?>
	<?php get_template_part( 'components/title-bar' ); ?>
	<div id="page-content" class="page-content custom-page-content srm">
		<div class="row">
			<div class="col-md-12">
				<div class="srm_single_event_post_img">
					<?php echo the_post_thumbnail('full'); ?>
				</div>
				<?php
				$post_id = get_the_id();
				$metaInfo=get_post_meta($post_id);
				$event_on=$metaInfo['event_on'];
					if(!empty($event_on)) { 
						$event_at=date("d-m-Y", strtotime($event_on[0]));				
					} 
				?>
			</div>
			<div class="col-md-12 srm_event_date">
				<span><?php echo $event_at; ?></span>
			</div>				
			<div class="col-md-12 srm_title_content_single">
				<h3 class="h3col"><?php the_title(); ?></h3>
				<p><?php echo the_content();?></p>
				<div class="srm_go_back"><a href="<?php echo home_url().'/news_events/press-release'; ?>" class="tm-button style-flat tm-button-nm tm-button-secondary">Go Back</a></div>
			</div>
		</div>
	</div>

<?php
get_footer();