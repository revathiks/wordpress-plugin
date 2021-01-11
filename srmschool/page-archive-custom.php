<?php
/**
 * 
 * Template Name: Custom Archive
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
				
  <?php 
	//Custom Archive navigation code..
		global $wpdb;
		$gallery = $_GET['gallery'];
		$archive = $_GET['archive'];
		$perpage = 20;
		$page = $_POST['page_number_0']?$_POST['page_number_0']:1;
		$num = $page - 1;
		$startAt = $perpage * $num;
		
		$gal_name = $wpdb->get_row("SELECT name FROM ".$wpdb->prefix."bwg_gallery WHERE id=$gallery");
		
		$images = $wpdb->get_results("SELECT img.id AS imageid,img.image_url,img.thumb_url FROM 
									  ".$wpdb->prefix."bwg_image img INNER JOIN ".$wpdb->prefix."bwg_gallery gal ON gal.id=img.gallery_id INNER JOIN ".$wpdb->prefix."bwg_image_tag tag ON tag.gallery_id=img.gallery_id AND tag.image_id=img.id WHERE gal.id =$gallery AND tag.tag_id=$archive LIMIT ". $startAt.','.$perpage);
									   
		$totalimages = $wpdb->get_results("SELECT img.id AS imageid,img.image_url,img.thumb_url FROM 
										  ".$wpdb->prefix."bwg_image img INNER JOIN ".$wpdb->prefix."bwg_gallery gal ON gal.id=img.gallery_id INNER JOIN ".$wpdb->prefix."bwg_image_tag tag ON tag.gallery_id=img.gallery_id AND tag.image_id=img.id WHERE gal.id =$gallery AND tag.tag_id=$archive");
		$total = count($totalimages);
		$totalpages = $total/$perpage;
	//Ends here..
						
	//Image popup variable declarations..
	  global $wd_bwg_options;
	  $params['gallery_id'] = $gallery;
	  $params['image_enable_page'] = 0;
      $params['image_title'] = $wd_bwg_options->image_title_show_hover;
      $params['thumb_height'] = $params['height'];
      $params['thumb_width'] = $params['width'];
      $params['image_column_number'] = $params['count'];
      $params['popup_fullscreen'] = $wd_bwg_options->popup_fullscreen;
      $params['popup_autoplay'] = $wd_bwg_options->popup_autoplay;
      $params['popup_width'] = $wd_bwg_options->popup_width;
      $params['popup_height'] = $wd_bwg_options->popup_height;
      $params['popup_effect'] = $wd_bwg_options->popup_type;
      $params['popup_enable_filmstrip'] = $wd_bwg_options->popup_enable_filmstrip;
      $params['popup_filmstrip_height'] = $wd_bwg_options->popup_filmstrip_height;
      $params['popup_enable_ctrl_btn'] = $wd_bwg_options->popup_enable_ctrl_btn;
      $params['popup_enable_fullscreen'] = $wd_bwg_options->popup_enable_fullscreen;
      $params['popup_enable_info'] = $wd_bwg_options->popup_enable_info;
      $params['popup_info_always_show'] = $wd_bwg_options->popup_info_always_show;
      $params['popup_info_full_width'] = $wd_bwg_options->popup_info_full_width;
      $params['popup_hit_counter'] = $wd_bwg_options->popup_hit_counter;
      $params['popup_enable_rate'] = $wd_bwg_options->popup_enable_rate;
      $params['popup_interval'] = $wd_bwg_options->popup_interval;
      $params['popup_enable_comment'] = $wd_bwg_options->popup_enable_comment;
      $params['popup_enable_facebook'] = $wd_bwg_options->popup_enable_facebook;
      $params['popup_enable_twitter'] = $wd_bwg_options->popup_enable_twitter;
      $params['popup_enable_google'] = $wd_bwg_options->popup_enable_google;
      $params['popup_enable_pinterest'] = $wd_bwg_options->popup_enable_pinterest;
      $params['popup_enable_tumblr'] = $wd_bwg_options->popup_enable_tumblr;
      $params['watermark_type'] = $wd_bwg_options->watermark_type;
      $params['watermark_link'] = urlencode($wd_bwg_options->watermark_link);
      $params['watermark_opacity'] = $wd_bwg_options->watermark_opacity;
      $params['watermark_position'] = $wd_bwg_options->watermark_position;
      $params['watermark_text'] = $wd_bwg_options->watermark_text;
      $params['watermark_font_size'] = $wd_bwg_options->watermark_font_size;
      $params['watermark_font'] = $wd_bwg_options->watermark_font;
      $params['watermark_color'] = $wd_bwg_options->watermark_color;
      $params['watermark_url'] = urlencode($wd_bwg_options->watermark_url);
      $params['watermark_width'] = $wd_bwg_options->watermark_width;
      $params['watermark_height'] = $wd_bwg_options->watermark_height;
      $params['thumb_click_action'] = $wd_bwg_options->thumb_click_action;
      $params['thumb_link_target'] = $wd_bwg_options->thumb_link_target;
      $params['popup_effect_duration'] = isset($wd_bwg_options->popup_effect_duration) ? $wd_bwg_options->popup_effect_duration : 1;
	//Ends here..				
  ?>
				
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
						wp_nav_menu($args);
					
					//Get menu list if for current gallery..
						$menu = wp_get_nav_menu_items("Gallery");
						foreach($menu as $item){
							if($item->title==$gal_name->name){
								$menuid = $item->ID;
							}
						}
					//ends here..
				?>
			 <div class="col-7-row2">
				 <?php dynamic_sidebar( 'sidebar-1' ); ?>                                     
			 </div>
		</div>
			  
		<div class="col-7  gallery_section">
			<div class="colm-8">				
						<?php 
						// Cusatom Image Archive code goes here..
							global $wpdb;
							$title = the_title ('','',false);
							$query = "SELECT gal.id,ter.name,ter.term_id FROM ".$wpdb->prefix."terms ter
									  INNER JOIN ".$wpdb->prefix."bwg_image_tag tag ON ter.term_id=tag.tag_id
									  INNER JOIN ".$wpdb->prefix."bwg_image img ON tag.image_id=img.id
									  INNER JOIN ".$wpdb->prefix."bwg_gallery gal ON img.gallery_id=gal.id  
									  WHERE gal.name LIKE '%$gal_name->name%' GROUP BY ter.term_id ORDER BY STR_TO_DATE(ter.name, '%M %d %Y') DESC";
							$results = $wpdb->get_results($query);
							if($results){
							?>
							<div class="arch-tit-mobile"  id="archives-gallery" >
							<div class="arch-tit">Archives</div>
							<ul class="archive-ul">
							<?php
							foreach($results as $date){
								 $active_class="";
								 if($archive == $date->term_id){
									$active_class="active";
								 }
								 $archivedate = date('F Y',strtotime($date->name));
								 echo "<li class='archive-li ".$active_class."'><a href='archive?gallery=$date->id&archive=$date->term_id' class='arch-val'>".$archivedate."</a></li>";
							}
						//Ends here..
						?>
						</ul>
						<?php } ?>
			</div>
				 <div class="row">
					<div class="colm-9 col7-2 gallery-tit">                        
					   <h3><?php echo $gal_name->name?$gal_name->name:"Photo Gallery"; ?></h3>                                        
					</div>
				 </div>
			<div class="txt-wrap">
			  <div id="bwg_container1_0">      
				<div id="bwg_container2_0">        
					<form id="gal_front_form_0" method="post" action="#" data-current="0">                    
						<div style="background-color:rgba(0, 0, 0, 0); text-align: center; width:100%; position: relative;">
							<div id="ajax_loading_0" style="position:absolute;width: 100%; z-index: 115; text-align: center; height: 100%; vertical-align: middle; display:none;">              
								<div style="display: table; vertical-align: middle; width: 100%; height: 100%; background-color: #FFFFFF; opacity: 0.7; filter: Alpha(opacity=70);">                
									<div style="display: table-cell; text-align: center; position: relative; vertical-align: middle;">          
										 <div id="loading_div_0" class="bwg_spider_ajax_loading" style="display: inline-block; text-align:center; position:relative; vertical-align:middle; background-image:url(<?php echo get_site_url(); ?>/wp-content/plugins/photo-gallery/images/ajax_loader.gif); float: none; width:30px;height:30px;background-size:30px 30px;">                  
										 </div>                
									 </div>              
								 </div>            
							</div>
							
							<div id="bwg_standart_thumbnails_0" class="bwg_standart_thumbnails_0">
							<?php foreach($images as $image){ ?>
								  <a class="bwg_lightbox_0" href="<?php echo get_site_url(); ?>									/wp-content/uploads/photo-gallery<?php echo $image->image_url; ?>" data-image-id="<?php echo $image->imageid; ?>">                  
									<span class="bwg_standart_thumb_0">                                        
										<span class="bwg_standart_thumb_spun1_0">                      
											<span class="bwg_standart_thumb_spun2_0">                                                
												<img class="bwg_standart_thumb_img_0 bwg_img_clear bwg_img_custom" style="width:180px; height:119.88px; margin-left: 0px; margin-top: -14.94px;" id="<?php echo $image->imageid; ?>" src="<?php echo get_site_url(); ?>/wp-content/uploads/photo-gallery<?php echo $image->thumb_url; ?>" alt="<?php echo $image->imageid; ?>">                      
											</span>                    
										</span>                                      
									</span>                
								</a>
							<?php } ?>
							</div>	

							<?php
							//pagination starts here
							global $wd_bwg_options;
							$theme_row = WDWLibrary::get_theme_row_data(1);
								WDWLibrary::ajax_html_frontend_page_nav($theme_row, ceil($totalpages), $page, 'gal_front_form_0', $perpage, 0, 'bwg_standart_thumbnails_0', 0, 'album', $wd_bwg_options->enable_seo, 1);
							//Ends here..
							?>
					 </div>
				 </form>
				 
				 <!-- Popup for image view.. -->
				 <div id="bwg_spider_popup_loading_0" class="bwg_spider_popup_loading"></div>
				 <div id="spider_popup_overlay_0" class="spider_popup_overlay" onclick="spider_destroypopup(1000)"></div>
				 <!-- Ends here.. -->

				 
<script type="text/javascript"> 
 
  <!-- JS for pagination starts here.. -->
	function spider_page_0(cur, x, y, load_more) {
		if (typeof load_more == "undefined") {
			var load_more = false;
		}
		if (jQuery(cur).hasClass('disabled')) {
			return false;
		}
		var items_county_0 = 3;
		switch (y) {
			case 1:
				if (x >= items_county_0) {
					document.getElementById('page_number_0').value = items_county_0;
				} else {
					document.getElementById('page_number_0').value = x + 1;
				}
				break;
			case 2:
				document.getElementById('page_number_0').value = items_county_0;
				break;
			case -1:
				if (x == 1) {
					document.getElementById('page_number_0').value = 1;
				} else {
					document.getElementById('page_number_0').value = x - 1;
				}
				break;
			case -2:
				document.getElementById('page_number_0').value = 1;
				break;
			default:
				document.getElementById('page_number_0').value = 1;
		}
		
	   spider_frontend_ajax('gal_front_form_0', '0', 'bwg_standart_thumbnails_0', '0', '', 'album', 0, '', '', load_more);

	}
	jQuery('.first-page disabled').on('click', function() {
		spider_page_0(this, 1, -2);
	});
	jQuery('.prev-page disabled').on('click', function() {
		spider_page_0(this, 1, -1);
		return false;
	});
	jQuery('.next-page-0').on('click', function() {
		spider_page_0(this, 1, 1);
		return false;
	});
	jQuery('.last-page-0').on('click', function() {
		spider_page_0(this, 1, 2);
	});
	jQuery('.bwg_load_btn_0').on('click', function() {
		spider_page_0(this, 1, 1, true);
		return false;
	});
	jQuery('#menu-item-'+<?php echo $menuid; ?>).addClass('current-menu-item');

  <!-- JS for pagination ends here.. -->
  
	<?php
	//Variable declarations for image popup view..
		  $params_array = array(
          'action' => 'GalleryBox',
          'tags' => (isset($params['tag']) ? $params['tag'] : 0),
          'current_view' => 0,
          'gallery_id' => $params['gallery_id'],
          'theme_id' => $params['theme_id'],
          'thumb_width' => $params['thumb_width'],
          'thumb_height' => $params['thumb_height'],
          'open_with_fullscreen' => $params['popup_fullscreen'],
          'open_with_autoplay' => $params['popup_autoplay'],
          'image_width' => $params['popup_width'],
          'image_height' => $params['popup_height'],
          'image_effect' => $params['popup_effect'],
          'wd_sor' => (isset($params['type']) ? 'date' : (($params['sort_by'] == 'RAND()') ? 'order' : $params['sort_by'])),
          'wd_ord' => $sort_direction,
          'enable_image_filmstrip' => $params['popup_enable_filmstrip'],
          'image_filmstrip_height' => $params['popup_filmstrip_height'],
          'enable_image_ctrl_btn' => $params['popup_enable_ctrl_btn'],
          'enable_image_fullscreen' => $params['popup_enable_fullscreen'],
          'popup_enable_info' => $params['popup_enable_info'],
          'popup_info_always_show' => $params['popup_info_always_show'],
          'popup_info_full_width' => $params['popup_info_full_width'],
          'popup_hit_counter' => $params['popup_hit_counter'],
          'popup_enable_rate' => $params['popup_enable_rate'],
          'slideshow_interval' => $params['popup_interval'],
          'enable_comment_social' => $params['popup_enable_comment'],
          'enable_image_facebook' => $params['popup_enable_facebook'],
          'enable_image_twitter' => $params['popup_enable_twitter'],
          'enable_image_google' => $params['popup_enable_google'],
          'enable_image_pinterest' => $params['popup_enable_pinterest'],
          'enable_image_tumblr' => $params['popup_enable_tumblr'],
          'watermark_type' => $params['watermark_type'],
          'slideshow_effect_duration' => isset($params['popup_effect_duration']) ? $params['popup_effect_duration'] : 1
        );
        if ($params['watermark_type'] != 'none') {
          $params_array['watermark_link'] = urlencode($params['watermark_link']);
          $params_array['watermark_opacity'] = $params['watermark_opacity'];
          $params_array['watermark_position'] = $params['watermark_position'];
        }
        if ($params['watermark_type'] == 'text') {
          $params_array['watermark_text'] = urlencode($params['watermark_text']);
          $params_array['watermark_font_size'] = $params['watermark_font_size'];
          $params_array['watermark_font'] = $params['watermark_font'];
          $params_array['watermark_color'] = $params['watermark_color'];
        }
        elseif ($params['watermark_type'] == 'image') {
          $params_array['watermark_url'] = urlencode($params['watermark_url']);
          $params_array['watermark_width'] = $params['watermark_width'];
          $params_array['watermark_height'] = $params['watermark_height'];
        }
	//Ends here..
	?>

	//method for popup view of the images..
	function bwg_gallery_box(image_id) {
		  var filterTags = jQuery("#bwg_tags_id_bwg_standart_thumbnails_0" ).val() ? jQuery("#bwg_tags_id_bwg_standart_thumbnails_0" ).val() : 0;
		  var filtersearchname = jQuery("#bwg_search_input_0" ).val() ? "&filter_search_name_0=" + jQuery("#bwg_search_input_0" ).val() : '';
		  spider_createpopup('<?php echo addslashes(add_query_arg($params_array, admin_url('admin-ajax.php'))); ?>&image_id=' + image_id + "&filter_tag_0=" +  filterTags + filtersearchname, '0', '<?php echo $params['popup_width']; ?>', '<?php echo $params['popup_height']; ?>', 1, 'testpopup', 5, "<?php echo $theme_row->lightbox_ctrl_btn_pos ;?>");
		  }
		  
	function bwg_document_ready() {
			var bwg_touch_flag = false;
			jQuery(".bwg_lightbox_0").live("click", function () {
			  if (!bwg_touch_flag) {
				bwg_touch_flag = true;
				setTimeout(function(){ bwg_touch_flag = false; }, 100);
				bwg_gallery_box(jQuery(this).attr("data-image-id"));
				return false;
			  }
			});
		  }
		  
		jQuery(document).ready(function () {
			bwg_document_ready();
			
			$(".menu-toggle").click(function() {
				$('.menu-in.custom-galley').toggle();
			return false;
			});
		 });
	  //Ends here..

</script>
			</div>
		</div>
	</div>
</div>
			
		<div class="colm-4">
		<div class="arch-tit-disktop"  id="archives-gallery">
					<div class="arch-tit">Archives</div>
						<?php 
							if($results){
							?>
							<ul class="archive-ul">
							<?php
							foreach($results as $date){
								 $active_class="";
								 if($archive == $date->term_id){
									$active_class="active";
								 }
								 $archivedate = date('F Y',strtotime($date->name));
								 echo "<li class='archive-li ".$active_class."'><a href='archive?gallery=$date->id&archive=$date->term_id' class='arch-val'>".$archivedate."</a></li>";
							}
						//Ends here..
						?>
						</ul>
						<?php } ?>
						</div>
				   </div>
		
	</div>
    </div>
    </section>
 <?php get_footer();
