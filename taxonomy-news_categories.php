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

<div class="col-md-12" id="srm_banner" style="margin-bottom:1em;"></div>	
<?php get_template_part( 'components/title-bar' ); ?>
	<div id="page-content" class="page-content srm-custom-page-content">
		<!--<div class="container">-->
		<div>
			<div class="row" id="srm_row_id">
				<?php Atomlab_Templates::render_sidebar( $page_sidebar_position, $page_sidebar1, $page_sidebar2, 'left' ); ?>
				
				<!--<div class="page-main-content">-->
				<div class="srm-custom-post-main-content">
				 <!-- Event dynamic code start -->
				<div class="col-md-3 widget widget_categories" id="srm_sidebar_event">
					<h2 class="widget-title srm_category_h2">Categories</h2>
					<!-- for left menu content -->
					<?php
					$categoryargs = array(
					   'taxonomy' => 'news_categories',
					   'orderby' => 'ID',
					   'order'   => 'DESC'
					);

					$cats = get_categories($categoryargs);
					$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$orginal_url_explode = explode('/',$actual_link);
					//$home_url = home_url().'/'.$orginal_url_explode[4].'/'.$orginal_url_explode[5];
					
					$postcat = get_queried_object();
					$postTermTaxonomy_id = $postcat->term_taxonomy_id;
					$postTermTaxonomy_slug = $postcat->slug;
					?>
					
					<ul>
					<?php
						foreach($cats as $cat) {
							$link = get_category_link( $cat->term_id );							 							
							//$active = ($link==$actual_link)?'color:#172455;':'';
							$active = ($postTermTaxonomy_id==$cat->term_id)?'color:#172455;':''; 
							?>
								<li>
								<a href="<?php echo get_category_link( $cat->term_id ) ?>" class="srm_category_list" id="srm_category_list" style="<?php echo $active; ?>">
								   <?php echo $cat->name; ?>
								</a>
								</li>
							<?php
							}
						?>
					</ul>
					<!-- end left menu content -->				 
				</div>
				<div class="col-md-9">
					<?php
					global $post;
					
					$paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
					$perpage = 9;
					$currentYear = date("Y");                
					?>
					<div class="archivesS-category">		
						<div class="archivesS colm-7">
							<div class="srm_select_style">
									<?php
									if (empty($_POST['event_month']) && empty($_POST['event_year']) && empty($_GET['cpage'])) {
										unset($_SESSION["event_year"]);
										unset($_SESSION["event_month"]);
									}
									if (isset($_POST['event_month'])) {
										unset($_SESSION["event_month"]);
										$_SESSION["event_month"] = $_POST['event_month'];
									}
									if (isset($_POST['event_year'])) {
										$_SESSION["event_year"] = $_POST['event_year'];
									}
									$submittedYear = $_SESSION["event_year"] ?? date("Y");
									$submittedMonth = $_SESSION["event_month"] ??  "";
									$submittedYear = $submittedYear ??  $currentYear;
									
									$year = $monthnum = '';
									
									if (isset($_POST['event_month'])) {
										$monthval = $_POST['event_month'];
									} else {
										$monthval = $submittedMonth;
									}
								   
									$date = date_parse($monthval);
									$monthnum = $date['month'];
									//end new
									
 /*
									 * Qury builder for fetch year which have posts
									 */
								
									$tax_query=array(
									'relation' => 'AND',
    									array(
    									'taxonomy' => 'news_categories',
    									'field'    => 'slug',
    									'terms'    => $postTermTaxonomy_slug,
    									),
									);
									
									$yearArg = array(
									    'post_type' => 'custom_news_events',
									    'post_status'=>'publish',
									    'posts_per_page' => -1,
									    'order' => 'DESC',
									    'tax_query'=>$tax_query,
									);
									$yearResult = new WP_Query($yearArg);
									 /* echo "<pre>";print_r($yearResult);
									 echo $wpdb->last_query ;die; */
									// The Loop
									$postYearList = array();
									if ($yearResult->have_posts()) {
									    while ($yearResult->have_posts()) : $yearResult->the_post();
									    $post_id = get_the_id();
									    $query = "SELECT meta_id,meta_value FROM " . $wpdb->prefix . "postmeta WHERE meta_key='event_year' and post_id=" . $post_id;
									    $results = $wpdb->get_row($query);
									    // Declare month number and initialize it
									    $year_num =$results->meta_value;
									    $postYearList[$year_num] =$year_num;
									    endwhile; // End of the loop.
									    wp_reset_query();
									    rsort($postYearList);
									}
									wp_reset_query();
									
									/*
									 * end:end year fetch query
									 */									


									/*
									 * Qury builder for fetch month which have posts
									 */
									if ((!empty($submittedYear))) {
										$meta_query_month = array(
											//'relation' => 'AND',
											array('key'=>'event_month',
												'value'=>1,
												'type' => 'numeric', 
												'compare' => '>='
											),
											array('key'=>'event_year',
												'value'=>$submittedYear,
											),
										   
										);
									} else {
										$meta_query_month = "";
									}
								  
									// The Query
									$tax_query=array(
										'relation' => 'AND',
										array(
										'taxonomy' => 'news_categories',
										'field'    => 'slug',
										'terms'    => $postTermTaxonomy_slug,                                
										),
									);
									
								   
									//query_posts(array('category_name' => $page, 'posts_per_page' => '-1', 'order' => 'DESC'));
									$monthArg = array(
									'post_type' => 'custom_news_events',
									'post_status'=>'publish',
										'posts_per_page' => -1,
										'order' => 'DESC',
										'tax_query'=>$tax_query,
										'meta_query'=>$meta_query_month
									);
									$monthResult = new WP_Query($monthArg);
								   // echo "<pre>";print_r($monthResult);                               
								   // echo $wpdb->last_query ; 
									// The Loop
									$postMonthList = array();
									
									if ($monthResult->have_posts()) {
										while ($monthResult->have_posts()) : $monthResult->the_post();
										 $post_id = get_the_id();
											$query = "SELECT meta_id,meta_value FROM " . $wpdb->prefix . "postmeta WHERE meta_key='event_month' and post_id=" . $post_id;
											$results = $wpdb->get_row($query);
											// Declare month number and initialize it
											$month_num =$results->meta_value;
											$month_name = date("F", mktime(0, 0, 0, $month_num, 10));
											$postMonthList[$month_num] =$month_name;
										   
										endwhile; // End of the loop.
									   
										// Reset Query
										wp_reset_query();
									  
										$postmonths = array_unique($post_month);
										//order month from jan to dec
										ksort($postMonthList);
									}
									wp_reset_query();
									  // print_r($postMonthList);
									/*
									 * end month query
									 */

									/*
									 * Query build to dispaly post based on submitted year and month
									 */
									if ((!empty($submittedYear)) && empty($submittedMonth)) {
										$meta_query = array(
											//'relation' => 'AND',
											array(
												'key'=>'event_year',
												'value'=>$submittedYear,
											),
										);
									} elseif (!empty($submittedYear) && !empty($submittedMonth)) {

										$meta_query = array(
											'relation' => 'AND',
											array(
												array(
													'key'=>'event_year',
													'value'=>$submittedYear,
												),
											),
											array(
												array(
													'key'=>'event_month',
													'value'=>$monthnum,
												)
											),
										);
									} elseif (empty($submittedYear) && !empty($submittedMonth)) {
										$meta_query = array(
											'relation' => 'AND',
											array(
												'key'=>'event_month',
												'value'=>$monthnum,
											)
										);
									} else {
										$meta_query = "";
									}
									$tax_query=array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'news_categories',
											'field'    => 'slug',
											'terms'    => $postTermTaxonomy_slug,
											
										),
									);
								
									$arg = array(                                  
										'post_type' => 'custom_news_events',
										'post_status'=>'publish',
										//'order' => 'ASC',
										'posts_per_page' => $perpage,
										'paged' => $paged,                                    
										'tax_query'=>$tax_query,
										'orderby'  => 'meta_value',
										'meta_key' => 'event_on',
										'order' => 'DESC',
										'meta_type' => 'date',
										'meta_query'=>$meta_query,
									);									
									$pageposts = new WP_Query($arg);  
									
									/*   print_r($pageposts);
									echo $wpdb->last_query */; 

									/*
									 * END: Query build to dispaly post based on submitted year and month 
									 */
									?>
									<select id="event_YearIdSRM" class="select-year-srm">
										<option value="">Select Year</option> 
										<?php                           
										foreach ($postYearList as $yr) {
										    if ($submittedYear == $yr) {
												$selected = "selected=selected";
											} else {
												$selected = "";
											}
											if(!empty($yr)){
											?>
											<option value="<?php echo $yr; ?>" <?php echo $selected; ?>><?php echo $yr; ?></option>
											<?php
											$selected = '';
											}
										}
										?>                               
									</select>
								</div>
							<div class="srm_select_style">
									<?php
									$disableMonth = $pageposts->have_posts() ? "" : "disabled";
									?>
									<select class="select-month-srm" <?php echo $disableMonth; ?> >
										<option value="">Select Month</option>
										<?php
										$curmonth = date('F', strtotime($firstpost));
										//                                
										foreach ($postMonthList as $months) {
											if ($submittedMonth == $months) {
												$selected = "selected=selected";
											} else {
												$selected = "";
											}
											?>
											<option value="<?php echo $months; ?>" <?php echo $selected; ?>><?php echo $months; ?></option>

											<?php
											$selected = '';
										}
										?>
									</select>
								</div>
						</div>
					</div> 	
					<?php               
					if ($pageposts->have_posts()) :
                    // the loop
                    while ($pageposts->have_posts()) : $pageposts->the_post();
                        ?>
                        <a href="<?php the_permalink(); ?>">						
                        <div class="srm_custom_post">					                     
                            <h3 class="h3col"><?php the_title(); ?></h3>
							<?php if(get_the_post_thumbnail()){
									echo get_the_post_thumbnail();
								}else{
									?>
									<div class="srm_no_thumbnail">No Image Found</div>
									<?php 
								}
							?> 
							<?php 
							$post_id = get_the_id();
							$metaInfo=get_post_meta($post_id);
							//echo "<pre>";print_r($metaInfo);echo "<pre>";
							$event_on=$metaInfo['event_on'];
							if(!empty($event_on)) {
							?> 
							<div class="srm_event_at"><?php 
							$event_at=date("j M Y", strtotime($event_on[0]));
							//echo $event_at;
							?></div>
							<?php } ?>							
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
	<form id="event_form" method="POST" action="<?php echo get_site_url() . "/news_events/" . $postcat->slug; ?>">
		<input type="hidden" name="event_year" class="year"></input>
		<input type="hidden" name="event_month" class="month"></input>
    </form>
	<script>
		jQuery(document).ready(function () {
			jQuery('.select-year-srm').on('change', function () {
				jQuery('.year').val(this.value);
				//var month = jQuery('.select-month').val();
				//jQuery('.month').val(month);
				var month = "";
				jQuery('.month').val(month);

				if (jQuery('.year').val() != "")
				{
					jQuery("#event_form").submit();
				}
			});
			jQuery('.select-month-srm').on('change', function () {
				jQuery('.month').val(this.value);
				var year = jQuery('.select-year-srm').val();
				jQuery('.year').val(year);
				if (jQuery('.year').val() != "")
				{
					jQuery("#event_form").submit();
				}
			})

			var selectedYear = "<?php echo $submittedYear; ?>";
			jQuery("#event_YearIdSRM").val(selectedYear);
		})
	</script>
<?php
get_footer();