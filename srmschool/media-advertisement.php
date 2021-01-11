<?php
/**
 * 
 * Template Name: Media Advertisement
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

                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <!--<div class="label_style">Archives:</div> -->
                        <div class="select_style">
                            <?php
                            if (empty($_POST['media_month']) && empty($_POST['media_year']) && empty($_GET['cpage'])) {
                                unset($_SESSION["media_year"]);
                                unset($_SESSION["media_month"]);
                            }
                            if (isset($_POST['media_month'])) {
                                unset($_SESSION["media_month"]);
                                $_SESSION["media_month"] = $_POST['media_month'];
                            }
                            if (isset($_POST['media_year'])) {
                                $_SESSION["media_year"] = $_POST['media_year'];
                            }
                            $submittedYear = isset($_SESSION["media_year"]) ? $_SESSION["media_year"] : "";
                            $submittedMonth = isset($_SESSION["media_month"]) ? $_SESSION["media_month"] : "";
                            $submittedYear = !empty($submittedYear) ? $submittedYear : $ayear;

                            //$submittedYear= $_SESSION["media_year"];
                            //$submittedMonth=$_SESSION["media_month"]; 
                            //newly placed here
                            $year = $monthnum = '';
                            if (isset($_POST['media_year'])) {
                                $year = $_POST['media_year'];
                            } else {
                                $year = $submittedYear;
                            }
                            if (!empty($year)) {
                                $yearSep = explode("-", $year);
                                $startYear = $yearSep[0];
                                $startYearMonthStart = 6;
                                $startYearMonthEnd = 12;
                                $endYear = $yearSep[1];
                                $endYearMonthStart = 1;
                                $endYearMonthEnd = 5;
                            }
                            if (isset($_POST['media_month'])) {
                                $monthval = $_POST['media_month'];
                            } else {
                                $monthval = $submittedMonth;
                            }
                            $date = date_parse($monthval);
                            $monthnum = $date['month'];
                            //end new place

                            /*
                             * Qury builder for fetch month which have posts
                             */
                            if ((!empty($submittedYear))) {
                                $date_query_month = array(
                                    'relation' => 'AND',
                                    array(array(
                                            'after' => array(
                                                'year' => $startYear,
                                                'month' => '6'
                                            ),
                                            'inclusive' => true
                                        ),
                                        array(
                                            'before' => array(
                                                'year' => $endYear,
                                                'month' => '5'
                                            ),
                                            'inclusive' => true
                                        )
                                    ),
                                );
                            } else {
                                $date_query_month = "";
                            }
                            // The Query
                            //query_posts(array('category_name' => $page, 'posts_per_page' => '-1', 'order' => 'DESC'));
                            $monthArg = array('cat' => $postTermTaxonomy_id,
                                'posts_per_page' => -1,
                                'order' => 'DESC',
                                'date_query' => $date_query_month
                            );
                            $monthResult = new WP_Query($monthArg);
                            //echo "<pre>";print_r($monthResult);
                            // The Loop
                            $postMonthList = array();

                            if ($monthResult->have_posts()) {
                                while ($monthResult->have_posts()) : $monthResult->the_post();

                                    $post_id = get_the_id();

                                    $query = "SELECT post_date FROM " . $wpdb->prefix . "posts WHERE ID=" . $post_id;
                                    $results = $wpdb->get_row($query);
                                    $dates[] = date('F Y', strtotime($results->post_date));
                                    $post_month[] = date('F', strtotime($results->post_date));
                                    $post_year[] = date('Y', strtotime($results->post_date));
                                    $postMonthList[date("m", strtotime($results->post_date))] = date('F', strtotime($results->post_date));


                                endwhile; // End of the loop.
                                // Reset Query
                                wp_reset_query();
                                $postyears = array_unique($post_year);
                                $postmonths = array_unique($post_month);
                                //order month from jan to dec
                                ksort($postMonthList);
                                $curmonthyear = date('F Y');
                            }
                            wp_reset_query();

                            /*
                             * end month query
                             */

                            /*
                             * Query build to dispaly post based on submitted year and month
                             */
                            //date query: condition based on submitted values
                            if ((!empty($submittedYear)) && empty($submittedMonth)) {
                                $date_query = array(
                                    'relation' => 'AND',
                                    array(array(
                                            'after' => array(
                                                'year' => $startYear,
                                                'month' => '6'
                                            ),
                                            'inclusive' => true
                                        ),
                                        array(
                                            'before' => array(
                                                'year' => $endYear,
                                                'month' => '5'
                                            ),
                                            'inclusive' => true
                                        )
                                    ),
                                );
                            } elseif (!empty($submittedYear) && !empty($submittedMonth)) {

                                $date_query = array(
                                    'relation' => 'AND',
                                    array(array(
                                            'after' => array(
                                                'year' => $startYear,
                                                'month' => '6'
                                            ),
                                            'inclusive' => true
                                        ),
                                        array(
                                            'before' => array(
                                                'year' => $endYear,
                                                'month' => '5'
                                            ),
                                            'inclusive' => true
                                        )
                                    ),
                                    array(
                                        'month' => $monthnum,
                                    ),
                                );
                            } elseif (empty($submittedYear) && !empty($submittedMonth)) {
                                $date_query = array(
                                    'relation' => 'AND',
                                    array(
                                        'month' => $monthnum,
                                    ),
                                );
                            } else {
                                $date_query = "";
                            }


                            $arg = array(
                                'cat' => $postTermTaxonomy_id,
                                //'post_type' => 'post',
                                //'post_status'=>'publish',
                                'order' => 'DESC',
                                'posts_per_page' => $perpage,
                                'paged' => $paged,
                               // 'date_query' => $date_query
                            );
                            $pageposts = new WP_Query($arg);
                            //echo $wpdb->last_query;

                            /*
                             * END Query build to dispaly post based on submitted year and month
                             */
                            ?>
                           
                        </div>
                        
                    </div>
                </div>
                <?php
                // The Loop
                if ($pageposts->have_posts()) {
                    while ($pageposts->have_posts()) : $pageposts->the_post();
                    
                    echo "<pre>";print_r($post->post_content);echo "</pre>";
                        $htmlRaw = do_shortcode($post->post_content);
                        echo "<pre>";print_r($post->$htmlRaw);echo "</pre>";
                        $checkimg = preg_match('/(<img[^>]+>)/i', $htmlRaw, $matches);
                        if ($checkimg) {
                            preg_match('@src="([^"]+)"@', $htmlRaw, $match);
                            $src = array_pop($match);
                        } else {
                            $hrefsep = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $htmlRaw, $matches);
                            $src = $matches[0][0];
                        }
                        ?> 
                        <div class="wrapper colm-4 pright pleft eventsImg">
                            <div class="title"><?php the_title(); ?></div>
                            <div class="content">
                                <?php //the_content(); echo $src;    ?>
                                <div class="media" data-src="<?php echo $src; ?>#t=0.01" data-width="640" data-height="360">
                                    <?php
                                    if (get_the_post_thumbnail($post->ID) != '') {
                                        echo get_the_post_thumbnail($post->ID, array(225, 300));
                                    } else {
                                        echo "Click here to view";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php
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
                echo "<div style='clear:both;' class='paginationList'>";
                $big = 999999999; // need an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $pageposts->max_num_pages,
                    'add_args' => array('cpage' => "cGFnZQ=="),
                ));
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

<script>
    $(document).ready(function () {
        // video lightbox
        $('.media').mediaBox({
            closeImage: '<?php echo $templateurl; ?>/assets/images/close.png',
            openSpeed: 1000,
            closeSpeed: 800
        });
    })
</script>
<?php
get_footer();
