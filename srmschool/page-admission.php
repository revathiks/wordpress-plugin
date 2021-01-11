<?php
/**
 * 
 * Template Name: Admission
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
 $( function() {
	 var icons = {
      header: "ui-icon-plusthick",
      activeHeader: "ui-icon-minusthick"
    };	
    $( "#accordion" ).accordion({
	  icons: icons,
      heightStyle: "content"
    });
	$( "#toggle" ).button().on( "click", function() {
      if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
        $( "#accordion" ).accordion( "option", "icons", null );
      } else {
        $( "#accordion" ).accordion( "option", "icons", icons );
      }
    });
  } );
  </script>
 <section class="sec-6 grid-inner-fix grid-bng-4">
         <div class="container banner-txt-2">
            <h1>EDUCATING MINDS.</h1>
            <h2>ENRICHING LIVES.</h2>
         </div>
      </section>
      <section class="sec-7">
         <div class="container">
            <div class="row">
               <div class="col-7">
                  <div class="side-mb-tab">Admissions</div>
                  <?php
									$args = array(
										'title'			=> 'Admissions',
										'theme_location' => 'main',
                                        'menu_id'		 =>	'side-site-map',
                                        'container'     => 'div',
                                        'container_class' => 'menu-in',
										'submenu' => 'Admissions',
									);
										wp_nav_menu( $args );
						
						?>
                    <!--Admission -->
                  <div class="col-7-row2"><?php dynamic_sidebar( 'sidebar-1' ); ?> </div>
                   <!-- Watch Video -->
                   <?php dynamic_sidebar( 'sidebar-3' ); ?>
                  <!--div class="txt-wrap col-bg">
                     <h4>Admissions Requirements:</h4>
                     <p class="txt-grid">As part of the application process, parents are requested to prepare the following documents for submission to the school:</p>
                     <ul>
                        <li>Application form, duly filled</li>
                        <li>3 colour photos</li>
                        <li>Report from Pre-School (if available)</li>
                        <li>Copy of the student's passport (if available)</li>
                        <li>Copy of the student's birth certificate in case of PIO holders</li>
                        <li>
                           Copy of any one of the following as proof of residence for parents 
                           <ul>
                              <li>Passport</li>
                              <li>Aadhaar</li>
                              <li>Ration</li>
                              <li>Voter ID card</li>
                           </ul>
                        </li>
                        <li>Most recent water / telephone / electricity / gas bill</li>
                        <li>Statement of running bank account</li>
                     </ul>
                  </div-->
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
