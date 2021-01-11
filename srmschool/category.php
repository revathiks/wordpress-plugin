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
get_header();
?>
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
                $args = array(
                    'title' => 'Photo Gallery',
                    'theme_location' => 'main',
                    'menu_id' => 'side-site-map',
                    'container' => 'div',
                    'container_class' => 'menu-in',
                    'submenu' => 'Photo Gallery',
                );
                wp_nav_menu($args);
                ?>
                <div class="col-7-row2">
                    <?php dynamic_sidebar('sidebar-1'); ?>                                     
                </div>
            </div>
            <?php
            $link = $_SERVER['REQUEST_URI'];
            $link_array = explode('/', $link);
            $page = end($link_array);
            $categoryname = explode('?', $page);
            $category = $categoryname[0];
            ?>
            <div class="col-7">
                <?php
                $postcat = get_queried_object();
                global $post;
                //$postcat = get_category_by_slug($category);
                $postTermTaxonomy_id = $postcat->term_taxonomy_id;
                $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
                $perpage = 10;
                $link = $_SERVER['REQUEST_URI'];
                $link_array = explode('/', $link);
                $page = end($link_array);
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
                        <div class="label_style"><?php echo $postcat->cat_name . '  '; ?>Filter:</div>
                        <div class="select_style">
                            <?php
                            if (empty($_POST['month']) && empty($_POST['year']) && empty($_GET['cpage'])) {
                                unset($_SESSION["year"]);
                                unset($_SESSION["month"]);
                            }
                            if (isset($_POST['month'])) {
                                unset($_SESSION["month"]);
                                $currentpage = 1;
                                $_SESSION["month"] = $_POST['month'];
                            }
                            if (isset($_POST['year'])) {
                                $currentpage = 1;
                                $_SESSION["year"] = $_POST['year'];
                            }
                            $submittedYear = isset($_SESSION["year"]) ? $_SESSION["year"]: "";
                            $submittedMonth = isset($_SESSION["month"]) ? $_SESSION["month"]: "";
                            $submittedYear = !empty($submittedYear) ? $submittedYear : $ayear;

                            //newly added here
                            $year = $monthnum = '';
                            if (isset($_POST['year'])) {
                                $year = $_POST['year'];
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
                            if (isset($_POST['month'])) {
                                $monthval = $_POST['month'];
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
                                do {
                                    if (strtotime($curmonthyear) == strtotime($dates[0])) {
                                        $firstpost = $curmonthyear;
                                        break;
                                    }
                                    $curmonthyear = Date('F Y', strtotime($curmonthyear . " last month"));
                                } while (strtotime($curmonthyear) >= strtotime($dates[0]));
                            }
                            wp_reset_query();

                            /*
                             * end month query
                             */



                            /*
                             * Query build to fetch post based on submitted month and submitted year
                             */

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
                                'order' => 'DESC',
                                'posts_per_page' => $perpage,
                                'post_type' => 'post',
                                'paged' => $paged,
                                'date_query' => $date_query
                            );
                            $pageposts = new WP_Query($arg);
                            /* echo "<pre>";print_r($pageposts);
                            echo $wpdb->last_query;  */      

                            /*
                             * END: Query build to fetch post based on submitted month and submitted year
                             */
                            ?>
                            <select id="academicYearId" class="select-year">
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
// The Loop
                if ($pageposts->have_posts()) {
                    while ($pageposts->have_posts()) : $pageposts->the_post();
                        ?>

                        <div class="wrapper colm-4 pright pleft eventsImg">
                            <div class="title"><?php the_title(); ?></div>
                            <div class="content"><?php the_content(); ?></div>
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
                    <p>No Galleries Available.</p>
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

<form id="cat_form" method="POST" action="<?php echo get_site_url() . "/category/" . $postcat->category_nicename; ?>">
    <input type="hidden" name="year" class="year"></input>
    <input type="hidden" name="month" class="month"></input>
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
                $("#cat_form").submit();
            }
        });
        $('.select-month').on('change', function () {
            $('.month').val(this.value);
            var year = $('.select-year').val();
            $('.year').val(year);
            if ($('.year').val() != "")
            {
                $("#cat_form").submit();
            }
        })

        //dynamic financial year dropdown   
        // 0-jan,1-feb ..11-dec
        var startYear = 2017;
        var current_year = new Date().getFullYear();
        var current_month = new Date().getMonth();
//        var current_year = 2019;
//        var current_month = 3;
        var max;
        if (current_month <= 5) {
            max = current_year;
        } else {
            max = current_year + 1;
        }
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

        select = document.getElementById('academicYearId');
        currentYear = new Date().getFullYear();
        for (i = 0; i < academicYears.length; i++) {
            var opt = document.createElement('option');
            opt.value = academicYears[i].yrValue;
            opt.innerHTML = academicYears[i].yrLabel;
            select.appendChild(opt);
        }

        var selectedYear = "<?php echo $submittedYear; ?>";
        $("#academicYearId").val(selectedYear);
    })
</script>
<?php
get_footer();
