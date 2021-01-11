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
            $category=$categoryname[0];
            ?>
            <div class="col-7">
                <?php  
                global $post;
                $postcat = get_category_by_slug($category); 
                $postTermTaxonomy_id=$postcat->term_taxonomy_id;
                $currentpage = $_GET['page'] ? $_GET['page'] : 1;
                $perpage = 10;
                // The Query
                query_posts(array('category_name' => $page, 'posts_per_page' => '-1', 'order' => 'DESC'));
                // The Loop
                if (have_posts()) {
                    while (have_posts()) : the_post();
                        $post_id = get_the_id();
                        $query = "SELECT post_date FROM " . $wpdb->prefix . "posts WHERE ID=" . $post_id;
                        $results = $wpdb->get_row($query);
                        $dates[] = date('F Y', strtotime($results->post_date));
                        $post_month[] = date('F', strtotime($results->post_date));
                        $post_year[] = date('Y', strtotime($results->post_date));

                    endwhile; // End of the loop.
                    // Reset Query
                    wp_reset_query();
                    $postyears = array_unique($post_year);
                    $postmonths = array_unique($post_month);
                    $curmonthyear = date('F Y');

                    /* foreach($dates as $galposts){

                      if(strtotime($curmonthyear) == strtotime($galposts)){
                      $firstpost = $curmonthyear;
                      break;
                      }else
                      {
                      $curmonthyear = Date('F Y', strtotime($curmonthyear . " last month"));
                      }
                      } */

                    do {
                        if (strtotime($curmonthyear) == strtotime($dates[0])) {
                            $firstpost = $curmonthyear;
                            break;
                        }
                        $curmonthyear = Date('F Y', strtotime($curmonthyear . " last month"));
                    } while (strtotime($curmonthyear) >= strtotime($dates[0]));
                }
                ?>
                <?php
                $link = $_SERVER['REQUEST_URI'];
                $link_array = explode('/', $link);
                $page = end($link_array);
                ?>
                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style"><?php echo $postcat->cat_name . '  ';  ?>Filter:</div>
                        <div class="select_style">
                            <?php
                            if(empty($_POST['month']) && empty($_POST['year']) && empty($_GET['page']))
                           {                               
                            unset($_SESSION["year"]);unset($_SESSION["month"]);   
                           }
                            if(isset($_POST['month']))
                            {   
                                unset($_SESSION["month"]);
                                $currentpage=1;
                                $_SESSION["month"]=$_POST['month'];
                            }
                           if(isset($_POST['year'])){
                               $currentpage=1;
                               $_SESSION["year"]=$_POST['year'];
                           }			   
                            $submittedYear= $_SESSION["year"];
                            $submittedMonth=$_SESSION["month"];                           
                            
                            
                            ?>
                            <select id="academicYearId" class="select-year">
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
                                    if ($submittedMonth == $months || ($_POST['month'] && $submittedMonth == $months)) {
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
                if ($_POST['year']) {
                    $year = $_POST['year'];
                } else {
                    //$year = date('Y', strtotime($firstpost));
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
                if ($_POST['month']) {
                $monthval=$_POST['month'];
                }
                else{$monthval=$submittedMonth;}
                $date = date_parse($monthval);
                $monthnum = $date['month'];
                
                $monthQuery = $yearQry = $customQry = "";
                $monthQuery = " AND MONTH(" . $wpdb->prefix . "posts.post_date)=" . $monthnum;
                
                $where = " AND ( " . $wpdb->prefix . "term_relationships.term_taxonomy_id IN (".$postTermTaxonomy_id.") )";
                if ( (!empty($_POST['year']) || !empty($submittedYear)) && empty($submittedMonth)) {

                    $customQry = " AND ( ( YEAR(" . $wpdb->prefix . "posts.post_date)=" . $startYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $startYearMonthStart . " AND " . $startYearMonthEnd . ") OR 
  (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $endYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $endYearMonthStart . " AND " . $endYearMonthEnd . ") )";
                } 
                elseif (( !empty($_POST['year']) || !empty($submittedYear) ) && !empty($submittedMonth)) {
                    $customQry = " AND ( (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $startYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $startYearMonthStart . " AND " . $startYearMonthEnd . ") OR 
  (YEAR(" . $wpdb->prefix . "posts.post_date)=" . $endYear . " AND MONTH(" . $wpdb->prefix . "posts.post_date) BETWEEN " . $endYearMonthStart . " AND " . $endYearMonthEnd . ") )" . $monthQuery;
                } elseif(empty($_POST['year']) && !empty($submittedMonth)){
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
                //echo $wpdb->last_query;

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


                // The Loop
                if ($pageposts) {
                    foreach ($pageposts as $post): setup_postdata($post);
                        //$post_id = get_the_id();
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

                    endforeach; // End of the loop.		
                }else {
                    ?>
                    <p>No Galleries Available..</p>
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
                            echo "<a href=\" " . get_site_url() . "/category/".$postcat->slug."?page=$i\">\n";
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

<form id="cat_form" method="POST" action="">
    <input type="hidden" name="year" class="year"></input>
    <input type="hidden" name="month" class="month"></input>
</form>

<script>
    $(document).ready(function () {
        $('.select-year').on('change', function () {
            $('.year').val(this.value);
            var month = $('.select-month').val();
            $('.month').val(month);
            $("#cat_form").submit();
        });
        $('.select-month').on('change', function () {
            $('.month').val(this.value);
            var year = $('.select-year').val();
            $('.year').val(year);
            $("#cat_form").submit();
        })

        //dynamic financial year dropdown
        var min = new Date().getFullYear() - 9, //Past 10 years
                // max = min + 19,
                max = min + 9,
                select = document.getElementById('academicYearId');
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
        $("#academicYearId").val(selectedYear);
    })
</script>
<?php
get_footer();
