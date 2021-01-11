<?php
/**
 * 
 * Template Name: Events
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
?>
<script src="wp-content/themes/srmschool/assets/js/jscroll-master/jquery.jscroll.js"></script>
<section class="sec-6 grid-inner-fix grid-bng-7" >
    <div class="container banner-txt-2">
        <h1>EDUCATING MINDS.</h1>
        <h2>ENRICHING LIVES.</h2> </div>
</section>
<section id="content" class="sec-7">
    <div class="container smart_scroll_container">
        <div class="row">
            <div class="col-7">
                <div class="side-mb-tab">Events</div>
                <?php
                $args = array(
                    'title' => 'News and Events',
                    'theme_location' => 'main',
                    'menu_id' => 'side-site-map',
                    'container' => 'div',
                    'container_class' => 'menu-in',
                    'submenu' => 'News and Events',
                );
                wp_nav_menu($args);
                ?>
                <div class="col-7-row2">
                    <?php dynamic_sidebar('sidebar-1'); ?>                                     
                </div>
            </div>
            <div id="content"  class="col-7">  

                <?php
                global $post;
                $postcat = get_category_by_slug('news');
                $postTermTaxonomy_id = $postcat->term_taxonomy_id;
                $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
                $perpage = 10;
                $currentYear = date("Y");
                //previous academic year
                $today = date("Ymd");
                  //$today = date("20180401");
                $currentyear = substr($today, 0, 4);
                if (intval(substr($today, 4, 2)) < 4) {
                    $ayear = ($currentyear - 2) . '-' . ($currentyear -1);
                } else {
                    $ayear = ($currentyear -1 ) . '-' . ($currentyear);
                }
                ?>

                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style">Events Archives</div> 
                        <div class="select_style">
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
                                $submittedYear = isset($_SESSION["event_year"]) ? $_SESSION["event_year"] : "";
                                $submittedMonth = isset($_SESSION["event_month"]) ? $_SESSION["event_month"] : "";
                                $submittedYear = !empty($submittedYear) ? $submittedYear : $ayear;

//                            $submittedYear= $_SESSION["academic_year"];
//                            $submittedMonth=$_SESSION["academic_month"];
                                //newly place here
                                $year = $monthnum = '';
                                if (isset($_POST['event_year'])) {
                                    $year = $_POST['event_year'];
                                } else {
                                    $year = $submittedYear;
                                }
                                if (!empty($year)) {
                                    $yearSep = explode("-", $year);
                                    $startYear = $yearSep[0];
                                    $startYearMonthStart = 4;
                                    $startYearMonthEnd = 12;
                                    $endYear = $yearSep[1];
                                    $endYearMonthStart = 1;
                                    $endYearMonthEnd = 3;
                                }
                                if (isset($_POST['event_month'])) {
                                    $monthval = $_POST['event_month'];
                                } else {
                                    $monthval = $submittedMonth;
                                }
                                $date = date_parse($monthval);
                                $monthnum = $date['month'];
                                //end new


                                /*
                                 * Qury builder for fetch month which have posts
                                 */
                                if ((!empty($submittedYear))) {
                                    $date_query_month = array(
                                        'relation' => 'AND',
                                        array(array(
                                                'after' => array(
                                                    'year' => $startYear,
                                                    'month' => '4'
                                                ),
                                                'inclusive' => true
                                            ),
                                            array(
                                                'before' => array(
                                                    'year' => $endYear,
                                                    'month' => '3'
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
                                }
                                wp_reset_query();

                                /*
                                 * end month query
                                 */


                                /*
                                 * Query build to dispaly post based on submitted year and month
                                 */
                                if ((!empty($submittedYear)) && empty($submittedMonth)) {
                                    $date_query = array(
                                        'relation' => 'AND',
                                        array(array(
                                                'after' => array(
                                                    'year' => $startYear,
                                                    'month' => '4'
                                                ),
                                                'inclusive' => true
                                            ),
                                            array(
                                                'before' => array(
                                                    'year' => $endYear,
                                                    'month' => '3'
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
                                                    'month' => '4'
                                                ),
                                                'inclusive' => true
                                            ),
                                            array(
                                                'before' => array(
                                                    'year' => $endYear,
                                                    'month' => '3'
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
                                    'date_query' => $date_query
                                );
                                $pageposts = new WP_Query($arg);
                                //echo $wpdb->last_query;

                                /*
                                 * END: Query build to dispaly post based on submitted year and month 
                                 */
                                ?>
                                <select id="event_YearId" class="select-year">
                                    <option value="">Select Year</option>                                
                                </select>
                            </div>
                        <div class="select_style">
                                <?php
                                $disableMonth = $pageposts->have_posts() ? "" : "disabled";
                                ?>
                                <select class="select-month" <?php echo $disableMonth; ?> >
                                    <option value="">Select Month</option>
                                    <?php
                                    $curmonth = date('F', strtotime($firstpost));
//                                $postmonths = array('4' => 'April',
//                                    '5' => 'May',
//                                    '6' => 'June',
//                                    '7' => 'July',
//                                    '8' => 'August',
//                                    '9' => 'September',
//                                    '10' => 'October',
//                                    '11' => 'November',
//                                    '12' => 'December',
//                                    '1' => 'January',
//                                    '2' => 'February',
//                                    '3' => 'March'
//                                );
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
                        <div class="post">					                     
                            <h3 class="h3col"><?php the_title(); ?></h3>                                             

                            <p class="txt-grid ">
                                <?php the_content(); ?>
                            </p>
                        </div>
                        <?php
                    endwhile;
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



                    // clean up after our query
                    wp_reset_postdata();
                    ?>

                <?php else: ?>
                    <p><?php _e('Sorry, no events archives found.'); ?></p>
                <?php endif; ?>

            </div>


        </div>
    </div>
</section>
<form id="event_form" method="POST" action="<?php echo esc_url(the_permalink()); ?>">
                <input type="hidden" name="event_year" class="year"></input>
                <input type="hidden" name="event_month" class="month"></input>
            </form>

            <script>
                $(document).ready(function () {
                    $('.select-year').on('change', function () {
                        $('.year').val(this.value);
                        //var month = $('.select-month').val();
                        //$('.month').val(month);
                        var month = "";
                        $('.month').val(month);

                        if ($('.year').val() != "")
                        {
                            $("#event_form").submit();
                        }
                    });
                    $('.select-month').on('change', function () {
                        $('.month').val(this.value);
                        var year = $('.select-year').val();
                        $('.year').val(year);
                        if ($('.year').val() != "")
                        {
                            $("#event_form").submit();
                        }
                    })

                    //dynamic financial year dropdown
                    // 0-jan,1-feb ..11-dec
                    var startYear = 2017;
                    var current_year = new Date().getFullYear();
                    var current_month = new Date().getMonth();
//                            var current_year = 2018;
//                            var current_month = 3;
                    var max;
                    if (current_month <= 2) {
                        max = current_year - 1;
                    } else {
                        max = current_year;
                    }
                    //alert(startYear + "--" + max);

                    var j = 1;
                    var academicYears = [];
                    for (var i = startYear; i < max; i++) {
                        min1 = startYear + j;
                        var valuesign = i + "-" + min1;
                        var yearShort = min1.toString().substr(-2);
                        var single = i + "-" + yearShort;
                        academicYears.push({yrLabel: single, yrValue: valuesign});
                        j++;
                    }
                    //changed years order in reverse
                    academicYears.reverse();

                    //        for (i = 0; i < academicYears.length; i++) {
                    //            alert("yrLabel:- " + academicYears[i].yrLabel + " yrValue:- " + academicYears[i].yrValue);
                    //        }

                    select = document.getElementById('event_YearId');
                    currentYear = new Date().getFullYear();
                    for (i = 0; i < academicYears.length; i++) {
                        var opt = document.createElement('option');
                        opt.value = academicYears[i].yrValue;
                        opt.innerHTML = academicYears[i].yrLabel;
                        select.appendChild(opt);
                    }
                    var selectedYear = "<?php echo $submittedYear; ?>";
                    $("#event_YearId").val(selectedYear);
                })
            </script>
<?php
get_footer();
