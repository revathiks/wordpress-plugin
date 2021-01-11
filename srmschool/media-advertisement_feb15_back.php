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
$templateurl= get_template_directory_uri();
?>
<link rel="stylesheet" href="<?php echo $templateurl;?>/assets/css/jquery.media.box.css"/>
<script src="<?php echo $templateurl;?>/assets/js/jquery.media.box.js"></script>
<section class="sec-6 grid-inner-fix grid-bng-11">
    <div class="container banner-txt-2">
        <h1>EDUCATING MINDS.</h1>
        <h2>ENRICHING LIVES.</h2> </div>
</section>
<section class="sec-7">
    <div class="container">
        <div class="row">
            <div class="col-7">
                <div class="side-mb-tab">Media & Advertisement</div>              
                          
            </div>
            <?php
            $link = $_SERVER['REQUEST_URI'];
            $link_array = explode('/', $link);
            $page = end($link_array);
            ?>
            <div class="col-7">
                <?php 
                $pagename = get_query_var('pagename');
                $pageid=get_the_ID();
                global $post;
                $postcat = get_category_by_slug('media-advertisement'); 
                //$postTermTaxonomy_id=$postcat[0]->term_taxonomy_id;
                $postTermTaxonomy_id=$postcat->term_taxonomy_id;
                $currentpage = $_GET['pageno'] ? $_GET['pageno'] : 1;
                $perpage = 10;                
                ?>
               
                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style"><?php //echo ucfirst($page) . ' ';  ?>Archives:</div>
                        <div class="select_style">
                            <?php                           
                            if(empty($_POST['media_month']) && empty($_POST['media_year']) && empty($_GET['pageno']))
                           {    
                            unset($_SESSION["media_year"]);unset($_SESSION["media_month"]);   
                           }
                            if(isset($_POST['media_month']))
                            {   
                                unset($_SESSION["media_month"]);
                                $currentpage=1;
                                $_SESSION["media_month"]=$_POST['media_month'];
                            }
                           if(isset($_POST['media_year'])){
                               $currentpage=1;
                               $_SESSION["media_year"]=$_POST['media_year'];
                           }			   
                            $submittedYear= $_SESSION["media_year"];
                            $submittedMonth=$_SESSION["media_month"];                           
                            
                            
                            ?>
                            <select id="mediaYearId" class="select-year">
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
                                    if ($submittedMonth == $months || ($_POST['media_month'] && $submittedMonth == $months)) {
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
                if ($_POST['media_year']) {
                    $year = $_POST['media_year'];
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
                if ($_POST['media_month']) {
                $monthval=$_POST['media_month'];
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
                    $htmlRaw=do_shortcode( $post->post_content);
                    //print_r(htmlentities($htmlRaw));
                    //$htmlRawElement= htmlentities(addslashes($htmlRaw));
                    
                    $checkimg=preg_match('/(<img[^>]+>)/i', $htmlRaw, $matches);
                    if($checkimg)
                    {
                        preg_match( '@src="([^"]+)"@' , $htmlRaw, $match );
                        $src=array_pop($match);
                    }
                    else
                    {                    
                    $hrefsep = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $htmlRaw, $matches);
                    $src=$matches[0][0]; 
                    }
                    
                    ?> 
                        <div class="wrapper colm-4 pright pleft eventsImg">
                            <div class="title"><?php the_title(); ?></div>
                            <div class="content">
                                <?php //the_content(); echo $src;?>
                                <div class="media" data-src="<?php echo $src;?>#t=0.01" data-width="640" data-height="360">
                    <?php
                    if (get_the_post_thumbnail($post->ID)!='')
			{
					echo get_the_post_thumbnail( $pid,array(225, 300));
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

                    endforeach; // End of the loop.		
                }else {
                    ?>
                    <p>No Video Available..</p>
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
                            echo "<a href=\" " . get_site_url() . "/".$postcat->slug."?pageno=$i\">\n";
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
    <input type="hidden" name="media_year" class="year"></input>
    <input type="hidden" name="media_month" class="month"></input>
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
                select = document.getElementById('mediaYearId');
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
        $("#mediaYearId").val(selectedYear);
        
        // video lightbox
        $('.media').mediaBox({
        closeImage: '<?php echo $templateurl;?>/assets/images/close.png',
        openSpeed: 1000,
        closeSpeed: 800
      });
    })
</script>
<?php
get_footer();
