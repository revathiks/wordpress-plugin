<?php
/**
 * 
 * Template Name: PhotoGallery
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
                    <div class="side-mb-tab">Photo Gallery <button type="button" class="menu-toggle"> <span class="fa fa-caret-down"></span> </button></div>
					
                    <?php 
							$args = array(
								'title'			=> 'Photo Gallery',
								'theme_location' => 'main',
								'menu_id'		 =>	'side-site-map',
								'container'     => 'div',
								'container_class' => 'menu-in custom-galley',
								'menu' => 'Gallery',
							);
								wp_nav_menu( $args );
					?>
                     <div class="col-7-row2">
                         <?php dynamic_sidebar( 'sidebar-1' ); ?>                                     
                     </div>
            </div>
			
            <div class="col-7  gallery_section pull-md-4">
				<div class="row">
					<div class="colm-8">
						<?php 
						// Custom Image Archive code goes here..
							global $wpdb;
							$pattern = get_shortcode_regex();
							preg_match('/'.$pattern.'/s', $post->post_content, $matches);
							preg_match('/Best_Wordpress_Gallery id="([^"]+)"/', $matches[0], $galid);
							$gallery_id = $galid[1];
							
							$shortcode = $wpdb->get_var($wpdb->prepare("SELECT tagtext FROM " . $wpdb->prefix . "bwg_shortcode WHERE id='%d'", $gallery_id));
							
							if ($shortcode) {
							  $shortcode_params = explode('" ', $shortcode);
								foreach ($shortcode_params as $shortcode_param) {
									$shortcode_param = str_replace('"', '', $shortcode_param);
									$shortcode_elem = explode('=', $shortcode_param);
									$params[str_replace(' ', '', $shortcode_elem[0])] = $shortcode_elem[1];
								}
							}
							$gal_id = $params['gallery_id'];
							$query = "SELECT gal.id,ter.name,ter.term_id FROM ".$wpdb->prefix."terms ter
									  INNER JOIN ".$wpdb->prefix."bwg_image_tag tag ON ter.term_id=tag.tag_id
									  INNER JOIN ".$wpdb->prefix."bwg_image img ON tag.image_id=img.id
									  INNER JOIN ".$wpdb->prefix."bwg_gallery gal ON img.gallery_id=gal.id  
									  WHERE gal.id =$gal_id  GROUP BY ter.term_id ORDER BY STR_TO_DATE(ter.name, '%M %d %Y') DESC";
							$results = $wpdb->get_results($query);
							if($results){
							?>
							<div class="arch-tit-mobile"  id="archives-gallery" >
							<div class="arch-tit">Archives</div>
							<ul class="archive-ul text-left">
							<?php
							foreach($results as $date){
								 $archivedate = date('F Y',strtotime($date->name));
								 echo "<li class='archive-li'><a href='archive?gallery=$date->id&archive=$date->term_id' class='arch-val'>".$archivedate."</a></li>";
							}
						//Ends here..
						?>
						</ul>
						<?php } ?>
					</div>
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
					<?php 
					if($results){
					?>
					<div class="colm-4">
						<div class="arch-tit-disktop"  id="archives-gallery">
						<div class="arch-tit">Archives</div>
						<ul class="archive-ul text-left">
							<?php
							foreach($results as $date){
								 $archivedate = date('F Y',strtotime($date->name));
								 echo "<li class='archive-li'><a href='archive?gallery=$date->id&archive=$date->term_id' class='arch-val'>".$archivedate."</a></li>";
							}
						//Ends here..
						?>
						</ul>
						</div>
				   </div>
				  <?php } ?>
               </div>
			</div>
        </div>
    </section>
	<script>
	$('document').ready(function() {
		
    $(".menu-toggle").click(function() {
        $('.menu-in.custom-galley').toggle();
        return false;
    });
});
	</script>
 <?php get_footer();
