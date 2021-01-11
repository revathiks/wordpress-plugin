<?php
/**
 * 
 * Template Name: Media Advertisement video
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
get_header();
$templateurl = get_template_directory_uri();
?>
<link rel="stylesheet" href="<?php echo $templateurl; ?>/assets/css/jquery.media.box.css"/>
<script src="<?php echo $templateurl; ?>/assets/js/jquery.media.box.js"></script>
<section class="sec-6 grid-inner-fix grid-bng-11">
    <div class="container banner-txt-2">
        <h1>EDUCATING MINDS.</h1>
        <h2>ENRICHING LIVES.</h2> </div>
</section>
<section class="sec-7">
    <div class="container">
        <div class="row">
            <div class="col-7">
                <div class="side-mb-tab">Media and Advertisements</div>              

            </div>            
            <div class="col-7">
                <?php
                global $post;
                $postcat = get_category_by_slug('media-advertisement');
                $postTermTaxonomy_id = $postcat->term_taxonomy_id;
                $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
                $perpage = 10;

                //current academic year
                $today = date("Ymd");
                $currentyear = substr($today, 0, 4);
                if (intval(substr($today, 4, 2)) < 6) {
                    $ayear = ($currentyear - 1) . '-' . $currentyear;
                } else {
                    $ayear = ($currentyear) . '-' . ($currentyear + 1);
                }
                ?>

               
                <?php
                // The Loop
                if (have_posts()) {
                    while ( have_posts() ) : the_post();                     
                       get_template_part( 'template-parts/page/content', 'page' );
                        //get_template_part( 'template-parts/page/content', 'page' );
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.		
                }else {
                    ?>
                    <p>No Video Available.</p>
                    <?php
                }
                // Reset Query
                wp_reset_query();
                
                echo "</div>";
                ?>

            </div>


        </div>
    </div>
</section>

<form id="cat_form" method="POST" action="<?php echo esc_url(the_permalink()); ?>">
    <input type="hidden" name="media_year" class="year"></input>
    <input type="hidden" name="media_month" class="month"></input>
</form>

<?php
get_footer();
