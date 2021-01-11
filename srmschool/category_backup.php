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
                // print_r($_POST['year'] );
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
            ?>
            <div class="col-7">

                <?php
                /* get sub category under academic year parent */
                $category = get_category_by_slug('academic_year');
                $args = array(
                    'type' => 'post',
                    'child_of' => $category->term_id,
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => FALSE,
                    'hierarchical' => 1,
                    'taxonomy' => 'category',
                );
                $academicYears = get_categories($args);
                
                $category = get_category_by_slug('month');
                $args = array(
                    'type' => 'post',
                    'child_of' => $category->term_id,
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => FALSE,
                    'hierarchical' => 1,
                    'taxonomy' => 'category',
                );
                $academicMonths = get_categories($args);
               
                
                
                //print_r($pageposts);exit;

                // The Query
                //query_posts(array('category_name' => $page, 'posts_per_page' => '-1', 'order' => 'DESC'));
                // The Loop               
                ?>
                <?php
                $link = $_SERVER['REQUEST_URI'];
                $link_array = explode('/', $link);
                $page = end($link_array);                
                ?>
                <div class="archivesS-category">		
                    <div class="archivesS colm-7">
                        <div class="label_style"><?php echo ucfirst($page) . ' '; ?>Archives:</div>
                        <div class="select_style">
                            <select class="select-year">
                                <option value="">Select Year</option>
                                <?php
                                
                                foreach ($academicYears as $years) {
                                    if ($_POST['year'] && $_POST['year'] == $years->cat_ID) {
                                        $selected = "selected=selected";
                                    } else  {
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $years->cat_ID; ?>" <?php echo $selected; ?>><?php echo $years->name; ?></option>
                                    <?php
                                    $selected = '';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="select_style">
                            <select class="select-month">
                                <option value="">Select Month</option>
                                <?php                                
                                foreach ($academicMonths as $months) {
                                    if ($_POST['month'] && $_POST['month'] == $months->cat_ID) {
                                        $selected = "selected=selected";
                                    } else  {
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $months->cat_ID; ?>" <?php echo $selected; ?>><?php echo $months->name; ?></option>

                                    <?php
                                    $selected = '';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                $CaId=array();
                $CaId[]=38;
                $year = $monthnum = '';
                if (!empty($_POST['year'])) {
                    $CaId[] = $_POST['year'];
                } 
                if (!empty($_POST['month'])) {
                    $CaId[] = $_POST['month'];
                }
                $selectedCategories=implode(',', $CaId);
              // The Query                 
                $where = " AND ( " . $wpdb->prefix . "term_relationships.term_taxonomy_id IN (".$selectedCategories.") )";

                $querystr = "SELECT " . $wpdb->prefix . "posts.* 
                 FROM " . $wpdb->prefix . "posts LEFT JOIN " . $wpdb->prefix . "term_relationships ON (" . $wpdb->prefix . "posts.ID = " . $wpdb->prefix . "term_relationships.object_id) WHERE 1=1" . $where . "  AND srmps_posts.post_type = 'post' AND (" . $wpdb->prefix . "posts.post_status = 'publish') GROUP BY srmps_posts.ID ORDER BY srmps_posts.post_date DESC ";
                echo $querystr;
                $pageposts = $wpdb->get_results($querystr, OBJECT);              
  
                if ($pageposts) {global $post;
                    foreach ($pageposts as $post): setup_postdata($post)
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
    })
</script>
<?php
get_footer();
