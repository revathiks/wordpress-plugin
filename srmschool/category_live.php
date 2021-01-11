<?php
/**
 * 
 * Template Name: Gallery Events
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
<section class="sec-6 grid-inner-fix grid-bng-11">
        <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2> </div>
    </section>
    <section class="sec-7">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <div class="side-mb-tab">Photo Gallery</div>
                     <?php
					// print_r($_POST['year'] );
									$args = array(
										'title'			=> 'Photo Gallery',
										'theme_location' => 'main',
                                        'menu_id'		 =>	'side-site-map',
                                        'container'     => 'div',
                                        'container_class' => 'menu-in',
										'submenu' => 'Photo Gallery',
									);
										wp_nav_menu( $args );
						
						?>
                     <div class="col-7-row2">
                         <?php dynamic_sidebar( 'sidebar-1' ); ?>                                     
                     </div>
            </div>
				<?php 
					$link = $_SERVER['REQUEST_URI'];
					$link_array = explode('/',$link);
					$page = end($link_array);
				?>
                <div class="col-7">
				
				<?php
					// The Query
					query_posts( array ( 'category_name' => $page, 'posts_per_page' => '-1','order' => 'DESC' ) );
					// The Loop
					if(have_posts()){
					while ( have_posts() ) : the_post();
					
					$post_id = get_the_id();
					
					$query = "SELECT post_date FROM ".$wpdb->prefix."posts WHERE ID=".$post_id;
					$results = $wpdb->get_row($query);
					$dates[] = date('F Y',strtotime($results->post_date));
					$post_month[] = date('F',strtotime($results->post_date));
					$post_year[] = date('Y',strtotime($results->post_date));
					
					endwhile; // End of the loop.
					
					// Reset Query
					wp_reset_query();
					$postyears = array_unique($post_year);
					$postmonths = array_unique($post_month);

					$curmonthyear = date('F Y');

					/* foreach($dates as $galposts){
						
						if(strtotime($curmonthyear) == strtotime($galposts)){
							$firstpost = $curmonthyear;
							break;
						}else
						{
							$curmonthyear = Date('F Y', strtotime($curmonthyear . " last month"));
						}
					} */
					
					do{
						if(strtotime($curmonthyear) == strtotime($dates[0])){
							$firstpost = $curmonthyear;
							break;
						}
						$curmonthyear = Date('F Y', strtotime($curmonthyear . " last month"));
					}while(strtotime($curmonthyear)>=strtotime($dates[0]));
					
				}
				?>
				<?php 
					$link = $_SERVER['REQUEST_URI'];
					$link_array = explode('/',$link);
					$page = end($link_array);
				?>
				<div class="archivesS-category">		
					<div class="archivesS colm-7">
					<div class="label_style"><?php echo ucfirst($page).' '; ?>Archives:</div>
				<div class="select_style">
					<select class="select-year">
					<option value="novalue">Select Year</option>
					<?php
					//echo $firstpost;
						$curyear = date('Y',strtotime($firstpost));						
						foreach($postyears as $years){
							if($_POST['year'] && $_POST['year'] == $years){ 
								$selected = "selected=selected";
							}else if(!$_POST['year'] && $curyear == $years){
								$selected = "selected=selected";
							}
						?>
						<option value="<?php echo $years; ?>" <?php echo $selected; ?>><?php echo $years; ?></option>
						<?php
						$selected='';
						}
					?>
					</select>
				</div>
				<div class="select_style">
					<select class="select-month">
						<option value="novalue">Select Month</option>
						<?php
						$curmonth =  date('F',strtotime($firstpost));
						foreach($postmonths as $months){
							if($_POST['month'] && $_POST['month'] == $months){ 
								$selected = "selected=selected";
							}else if(!$_POST['month'] && $curmonth == $months){
								$selected = "selected=selected";
							}
						?>
						<option value="<?php echo $months; ?>" <?php echo $selected; ?>><?php echo $months; ?></option>
						
						<?php
						$selected='';
						}
						?>
					</select>
				</div>
				</div>
				</div>
                  <?php
					$year = $monthnum = '';
					if($_POST['year']){ 
						$year = $_POST['year']; 
					}
					 else
					{
						$year = date('Y',strtotime($firstpost));
					}
					if($_POST['month']){  
						$date = date_parse($_POST['month']);
						$monthnum = $date['month'];
					}
					else
					{
						$monthnum = date('m',strtotime($firstpost));
					}
					// The Query
					query_posts( array ( 'category_name' => $page, 'posts_per_page' => '-1', 'year' => $year, 'monthnum' => $monthnum,'order' => 'DESC', ) );
					echo $wpdb->last_query;
					// The Loop
					if(have_posts()){
					while ( have_posts() ) : the_post();
					$post_id = get_the_id();
					?>
					
					<div class="wrapper colm-4 pright pleft eventsImg">
					<div class="title"><?php the_title(); ?></div>
					<div class="content"><?php the_content(); ?></div>
					</div>
					
					<?php
					//get_template_part( 'template-parts/page/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					endwhile; // End of the loop.		
					}else
					{
						?>
						<p>No Galleries Available..</p>
						<?php
					}
					// Reset Query
					wp_reset_query();
					?>
               </div>
			</div>
        </div>
    </section>
	
<form id="cat_form" method="POST" action="">
    <input type="hidden" name="year" class="year"></input>
    <input type="hidden" name="month" class="month"></input>
</form>

<script>
$(document).ready(function(){
	$('.select-year').on('change', function() {
	  $('.year').val(this.value);
	  var month = $('.select-month').val();
	  $('.month').val(month);
	  $("#cat_form").submit();
	});
	$('.select-month').on('change', function() {
	  $('.month').val(this.value);
	  var year = $('.select-year').val();
	  $('.year').val(year);
	  $("#cat_form").submit();
	})
})
</script>
 <?php get_footer();
