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
										'title'			=> 'Academic Calendar',
										'theme_location' => 'main',
                                        'menu_id'		 =>	'side-site-map',
                                        'container'     => 'div',
                                        'container_class' => 'menu-in',
										'submenu' => 'Learning',
									);
										wp_nav_menu( $args );
						
						?>
                <div class="col-7-row2">
                    <?php dynamic_sidebar('sidebar-1'); ?>                                     
                </div>
            </div>            
            <div class="col-7">
                <?php 
                global $post;
                $postcat = get_category_by_slug('academic-calendar');                  
                $postTermTaxonomy_id=$postcat->term_taxonomy_id;
                $currentpage = $_GET['pagenum'] ? $_GET['pagenum'] : 1;
                $perpage = 10;
                ?>
                               
                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style"><?php echo $postcat->cat_name . '  ';  ?></div>
                        <div class="select_style">
                            <?php
                            if(empty($_POST['academic_month']) && empty($_POST['academic_year']) && empty($_GET['pagenum']))
                           {                               
                            unset($_SESSION["academic_year"]);unset($_SESSION["academic_month"]);   
                           }
                            if(isset($_POST['academic_month']))
                            {   
                                unset($_SESSION["month"]);
                                $currentpage=1;
                                $_SESSION["academic_month"]=$_POST['academic_month'];
                            }
                           if(isset($_POST['academic_year'])){
                               $currentpage=1;
                               $_SESSION["academic_year"]=$_POST['academic_year'];
                           }			   
                            $submittedYear= $_SESSION["academic_year"];
                            $submittedMonth=$_SESSION["academic_month"];                           
                            
                            
                            ?>
                            <select id="academic_YearId" class="select-year">
                                <option value="">Select Year</option>
                                <?php
                               //echo $firstpost;
                                $curyear = date('Y', strtotime($firstpost));
                               
                                ?>
                            </select>
                        </div>
                        <div class="select_style">
                            <select class="select-month">
                                <option value="">Select Month</option>
                                <?php
                                echo $curmonth = date('F', strtotime($firstpost));
                                $postmonths = array('4' => 'April',
                                    '5' => 'May',
                                    '6' => 'June',
                                    '7' => 'July',
                                    '8' => 'August',
                                    '9' => 'September',
                                    '10' => 'October',
                                    '11' => 'November',
                                    '12' => 'December',
                                    '1' => 'January',
                                    '2' => 'February',
                                    '3' => 'March'
                                );
                                foreach ($postmonths as $months) {                                   
                                    if ($submittedMonth == $months || ($_POST['academic_month'] && $submittedMonth == $months)) {
                                        $selected = "selected=selected";
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
                $year = $monthnum = '';
                if ($_POST['academic_year']) {
                    $year = $_POST['academic_year'];
                } else {
                     $year=$submittedYear;
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
                if ($_POST['academic_month']) {
                $monthval=$_POST['academic_month'];
                }
                else{$monthval=$submittedMonth;}
                $date = date_parse($monthval);
                $monthnum = $date['month'];
                
                $monthQuery = $yearQry = $customQry = "";               
                $monthQuery = " AND MONTH(" . $wpdb->prefix . "posts.post_date)=" . $monthnum;
                
                $where = " AND ( " . $wpdb->prefix . "term_relationships.term_taxonomy_id IN (".$postTermTaxonomy_id.") )";
                if (!empty($submittedYear) && empty($submittedMonth)) {

                    $customQry = " AND ( ( YEAR(" . $wpdb->prefix . "posts.post_date)=" . $startYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $startYearMonthStart . " AND " . $startYearMonthEnd . ") OR 
  (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $endYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $endYearMonthStart . " AND " . $endYearMonthEnd . ") )";
                } elseif (!empty($submittedYear) && !empty($submittedMonth)) {

                    $customQry = " AND ( (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $startYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $startYearMonthStart . " AND " . $startYearMonthEnd . ") OR 
  (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $endYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $endYearMonthStart . " AND " . $endYearMonthEnd . ") )" . $monthQuery;
                } elseif(empty($submittedYear) && !empty($submittedMonth)){
                    $customQry=$monthQuery;
                }
                else
                {
                 $customQry="";   
                }               

// The Query

                $querystr = "SELECT " . $wpdb->prefix . "posts.* 
                 FROM " . $wpdb->prefix . "posts LEFT JOIN " . $wpdb->prefix . "term_relationships ON (" . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "term_relationships.object_id) WHERE 1=1" . $where . $customQry . "  AND srmps_posts.post_type = 'post' AND (" . $wpdb->prefix . "posts.post_status = 'publish') GROUP BY srmps_posts.ID ORDER BY srmps_posts.post_date DESC ";
                $totalPosts = $wpdb->get_results($querystr, OBJECT);
                $totalRows = $wpdb->num_rows;

                $num = $currentpage - 1;
                $startAt = $perpage * $num;

                $x = $totalRows % $perpage;
                if ($x != 0) {
                    $totalpages = (int) ($totalRows / $perpage) + 1;
                } else {
                    $totalpages = (int) ($totalRows / $perpage);
                }
                
                //dispaly records
                $eventsQry = "SELECT " . $wpdb->prefix . "posts.* 
                 FROM " . $wpdb->prefix . "posts LEFT JOIN " . $wpdb->prefix . "term_relationships ON (" . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "term_relationships.object_id) WHERE 1=1" . $where . $customQry . "  AND srmps_posts.post_type = 'post' AND (" . $wpdb->prefix . "posts.post_status = 'publish') GROUP BY srmps_posts.ID ORDER BY srmps_posts.post_date DESC LIMIT " . $startAt . ',' . $perpage;
                $pageposts = $wpdb->get_results($eventsQry, OBJECT);
                //echo $wpdb->last_query;

                // The Loop
                if ($pageposts) {
                    foreach ($pageposts as $post): setup_postdata($post);
                        $post_id = get_the_id();
                        ?>

                        <div class="academicCalendar">
                            <h3 class="h3col"><a href="<?php echo get_permalink($post_id);?>"><?php the_title(); ?></a></h3>
                            <div class="content"><?php the_content(); ?></div>
                        </div>

                        <?php
                        //get_template_part( 'template-parts/page/content', 'page' );
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endforeach; // End of the loop.		
                }else {
                    ?>
                    <p>No content Available..</p>
                    <?php
                }
                // Reset Query
                wp_reset_query();
                ?>
                <?php
                if ($totalpages > 1) {
                    echo "<div style='clear:both;' class='paginationList'>";
                    for ($i = 1; $i <= $totalpages; $i++) {

                        if ($currentpage == $i) {
                            echo "<a class='active'>\n";
                            echo $i;
                            echo "</a>\n";
                        } else {
                            echo "<a href=\" " . get_site_url() . "/".$postcat->slug."?pagenum=$i\">\n";
                            echo $i;
                            echo "</a>\n";
                        }
                    }
                    echo "</div>";
                }
                ?>

            </div>


        </div>
    </div>
</section>

<form id="academic_form" method="POST" action="">
    <input type="hidden" name="academic_year" class="year"></input>
    <input type="hidden" name="academic_month" class="month"></input>
</form>

<script>
    $(document).ready(function () {
        $('.select-year').on('change', function () {
            $('.year').val(this.value);
            var month = $('.select-month').val();
            $('.month').val(month);
            $("#academic_form").submit();
        });
        $('.select-month').on('change', function () {
            $('.month').val(this.value);
            var year = $('.select-year').val();
            $('.year').val(year);
            $("#academic_form").submit();
        })

        //dynamic financial year dropdown
        var min = new Date().getFullYear() - 9, //Past 10 years
                // max = min + 19,
                max = min + 9,
                select = document.getElementById('academic_YearId');
        currentYear = new Date().getFullYear();
        var j = 1;
        for (var i = min; i <= max; i++) {
            min1 = new Date().getFullYear() - 9 + j; // Future 10 years
            var opt = document.createElement('option');
            var valuesign = i + "-" + min1;
            var single = i + "-" + min1;
            opt.value = valuesign;
            opt.innerHTML = single;
            select.appendChild(opt);
            j++;
        }
        var selectedYear = "<?php echo $submittedYear; ?>";
        $("#academic_YearId").val(selectedYear);
    })
</script>
<?php
get_footer();