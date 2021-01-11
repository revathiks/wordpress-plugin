<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	
	<!-- /Startup Box -->
   <section class="sec-1">
        <div class="banner-slider">
            <div class="headerslider"> <?php echo do_shortcode('[sp_responsiveslider cat_id="6" design="design-2"]'); ?></div>
           <!--div class="banner banner_5">
                <div class="container banner-txt">
                    <h3>CHILDREN'S CARNIVAL</h3>                    
                    <h4>@SRM Public School</h4>
                    <div class="hr-ln"></div><a href="gallery.php" class="btn-1">KNOW MORE PHOTOS</a> </div>
            </div-->
            <!--div class="banner banner_1">
                <div class="container banner-txt">
                    <h1>EDUCATING MINDS. ENRICHING LIVES.</h1>
                    <h4>For the love of learning</h4>
                    <div class="hr-ln"></div><a href="our-school.php" class="btn-1">KNOW MORE</a> </div>
            </div>
            <div class="banner banner_2">
                <div class="container banner-txt">
                    <h2>EDUCATION THAT GOES BEYOND CLASSROOMS</h2>
                    <h4>Igniting a lifelong passion for learning</h4>
                    <div class="hr-ln"></div><a href="our-school.php" class="btn-1">KNOW MORE</a> </div>
            </div>
            <div class="banner banner_3">
                <div class="container banner-txt">
                    <h2>THINKING BEYOND CLASSROOMS</h2>
                    <h4>Setting learning beyond the classroom</h4>
                    <div class="hr-ln"></div><a href="our-school.php" class="btn-1">KNOW MORE</a> </div>
            </div>
            <div class="banner banner_4">
                <div class="container banner-txt">
                    <h3>FINDING PASSION IN EDUCATION</h3>
                    <h4>Nurturing bright minds for a better tomorrow</h4>
                    <div class="hr-ln"></div><a href="our-school.php" class="btn-1">KNOW MORE</a> </div>
            </div-->			
        </div>
		<div class="fluid-container bgcolor clearFix">
        <div class="container banner-bt" >
            <div class="row">
			<!--Commented by SRM Tech as per client request..-->
                <!--<div class="colm-4 col-1-nn colm-4-wrap">
                    <article>
                        <h3>About the School</h3>
                        <div class="hr-ln"></div>
                        <p>Welcome to SRM Public School, a premier educational institution with a unique learning platform. Established with a vision to inspire a passion for learning in each child.</p><a href="welcome" class="btn-1">KNOW MORE</a> </article>
                </div>-->
                <div class="colm-3 colm-4-wrap mBtm50">                  
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>                    
                </div>
                <div class="colm-9 col-8-wrap mBtm50 news-Announcements">
                    <div class="col-1-nn-3 news-slider">
                        <h3>News &frasl; Announcements</h3>
                        <div class="hr-ln"></div>
						<marquee direction="up" scrollamount="3" height="220" onmouseover="this.stop();" onmouseout="this.start();">
						<div class="">
						<!--News Post List -->
						<?php
						/* $lastposts = get_posts( array(
							'posts_per_page' => 3,
							//'category' => 4
							'post_type' => 'event'
						) ); */
						$lastposts = get_posts( array ( 'category_name' => 'news', 'posts_per_page' => 7 ) );
					 
					if ( $lastposts ) {
						foreach ( $lastposts as $post ) :
							setup_postdata( $post ); 
						
						?>
						 <div class="row">
                            <div class="colm_12_cust">
							<?php
							// Condition to display the event start date
							$eventDate = get_post_meta( $post->ID, "event-start-date", true);
							if ($eventDate !='')
							{
								$eventStartDate = date("d-m-Y",$eventDate);
							}
							else
							{
								$eventStartDate = '';
							}
							
							// Condition to display the latest event
							$latest = $anchor_class = '';
							if(in_category('Latest News'))
							{
								$latest = 'disp-img';
								$anchor_class = 'new-img';
							}
							?>
							
							<a href="<?php the_permalink(); ?>" class="ab text_color <?php echo $anchor_class; ?>">
							<i class="fa fa-bullhorn"></i>
							<span class="disptitle <?php echo $latest; ?>"><?php echo mb_strimwidth( strip_shortcodes(the_title()),0, 90, '...' ); ?>
							<span class="latest-img"></span>
							</span>
							</a> </div>						
                        </div>	
					<?php
						endforeach; 
						wp_reset_postdata();
					}?>
				
                    </div>
					</marquee>
					<a class="btn-1 btn-2 readmore" href="news">KNOW MORE</a>
					</div>
                </div>
            </div>
        </div>
    </div>
	</section>
<?php // Show the selected frontpage content.
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/page/content', 'front-page' );
			endwhile;
		else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
			get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>

		<?php
		// Get each of our panels and show the post data.
		if ( 0 !== srmschool_panel_count() || is_customize_preview() ) : // If we have pages to show.

			/**
			 * Filter number of front page sections in Twenty Seventeen.
			 *
			 * @since Twenty Seventeen 1.0
			 *
			 * @param $num_sections integer
			 */
			$num_sections = apply_filters( 'srmschool_front_page_sections', 4 );
			global $twentyseventeencounter;

			// Create a setting and control for each of the sections available in the theme.
			for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
				$twentyseventeencounter = $i;
				srmschool_front_page_section( null, $i );
			}

	endif; // The if ( 0 !== srmschool_panel_count() ) ends here. ?>
	

<?php get_footer();

