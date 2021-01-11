<?php
/**
 * 
 * Template Name: Academic Calendar
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
                <div class="side-mb-tab">Academic Calendar</div>
                <?php
                $args = array(
                    'title' => 'Academic Calendar',
                    'theme_location' => 'main',
                    'menu_id' => 'side-site-map',
                    'container' => 'div',
                    'container_class' => 'menu-in',
                    'submenu' => 'Learning',
                );
                wp_nav_menu($args);
                ?>
                <div class="col-7-row2">
                    <?php dynamic_sidebar('sidebar-1'); ?>                                     
                </div>
            </div>            
            <div class="col-7">
                <?php
                global $post;
                $postcat = get_category_by_slug('academic-calendar');
                $postTermTaxonomy_id = $postcat->term_taxonomy_id;
                $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
                $perpage = 10;

                //current academic year
                $today = date("Ymd");
                $currentyear = substr($today, 0, 4);
                if (intval(substr($today, 4, 2)) < 4) {
                    $ayear = ($currentyear - 1) . '-' . $currentyear;
                } else {
                    $ayear = ($currentyear) . '-' . ($currentyear + 1);
                }
                ?>

                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style"><?php echo $postcat->cat_name . '  '; ?></div>
                        <div class="select_style">
                            <?php
                            if (empty($_POST['academic_month']) && empty($_POST['academic_year']) && empty($_GET['cpage'])) {
                                unset($_SESSION["academic_year"]);
                                unset($_SESSION["academic_month"]);
                            }
                            if (isset($_POST['academic_month'])) {
                                unset($_SESSION["month"]);
                                $_SESSION["academic_month"] = $_POST['academic_month'];
                            }
                            if (isset($_POST['academic_year'])) {
                                $_SESSION["academic_year"] = $_POST['academic_year'];
                            }
                            $submittedYear = isset($_SESSION["academic_year"]) ? $_SESSION["academic_year"] : "";
                            $submittedMonth = isset($_SESSION["academic_month"]) ? $_SESSION["academic_month"] : "";
                            $submittedYear = !empty($submittedYear) ? $submittedYear : $ayear;

//                            $submittedYear= $_SESSION["academic_year"];
//                            $submittedMonth=$_SESSION["academic_month"];
                            //newly place here
                            $year = $monthnum = '';
                            if (isset($_POST['academic_year'])) {
                                $year = $_POST['academic_year'];
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
                            if (isset($_POST['academic_month'])) {
                                $monthval = $_POST['academic_month'];
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
                            <select id="academic_YearId" class="select-year">
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

                        <div class="academicCalendar">
                            <h3 class="h3col"><a href="<?php echo get_permalink($post_id); ?>"><?php the_title(); ?></a></h3>
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
                    <p>No content Available.</p>
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

<form id="academic_form" method="POST" action="<?php echo esc_url(the_permalink()); ?>">
    <input type="hidden" name="academic_year" class="year"></input>
    <input type="hidden" name="academic_month" class="month"></input>
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
                $("#academic_form").submit();
            }
        });
        $('.select-month').on('change', function () {
            $('.month').val(this.value);
            var year = $('.select-year').val();
            $('.year').val(year);
            if ($('.year').val() != "")
            {
                $("#academic_form").submit();
            }
        })

        //dynamic financial year dropdown
        // 0-jan,1-feb ..11-dec
        var startYear = 2017;
        var current_year = new Date().getFullYear();
        var current_month = new Date().getMonth();
//        var current_year = 2019;
//        var current_month = 2;
        var max;
        if (current_month <= 2) {
            max = current_year;
        } else {
            max = current_year + 1;
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

        select = document.getElementById('academic_YearId');
        currentYear = new Date().getFullYear();
        for (i = 0; i < academicYears.length; i++) {
            var opt = document.createElement('option');
            opt.value = academicYears[i].yrValue;
            opt.innerHTML = academicYears[i].yrLabel;
            select.appendChild(opt);
        }
        var selectedYear = "<?php echo $submittedYear; ?>";
        $("#academic_YearId").val(selectedYear);
    })
</script>
<?php
get_footer();
