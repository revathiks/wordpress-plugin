<?php
/**
 * 
 * Template Name: Test Pagination
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
<section class="sec-6 grid-inner-fix grid-bng-7">
    <div class="container banner-txt-2">
        <h1>EDUCATING MINDS.</h1>
        <h2>ENRICHING LIVES.</h2> </div>
</section>
<section class="sec-7">
    <div class="container">
        <div class="row">
            <div class="col-7">
                <div class="side-mb-tab">News / Announcements</div>
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
            <div class="col-7">  
                <div class="">	

                    <?php
                    $paged = ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1;
                    $arg = array(
                        'cat' => 38,
                        'posts_per_page' => 2,
                        'paged' => $paged,
                        'date_query' => array(
//                            'relation' => 'OR',
//                            array(
//                                'year' => '2017',
//                                'month' => array( '4', '12' ),
//                                'compare' => 'BETWEEN',
//                            ),
//                              array(
//                                'year' => '2018',
//                                'month' => array( '1', '3' ),
//                                'compare' => 'BETWEEN',
//                            ),

                            'relation' => 'AND',
                            array(array(
                                'after' => array(
                                    'year' => '2017',
                                    'month' => '4'
                                ),
                                'inclusive' => true
                            ),
                            array(
                                'before' => array(
                                    'year' => '2018',
                                    'month' => '3'
                                ),
                                'inclusive' => true
                            )
                                ),
//                            array(
//                                'month' => '8'  ,
//                            ),
                        )
                    );
                    //$catquery = new WP_Query( 'cat=4&posts_per_page=2&paged='.$paged.'' );					
                    $catquery = new WP_Query($arg);

                    echo $wpdb->last_query;
                    //echo $catquery->request;
//                    echo "<pre>";
//                    print_r($catquery);
//                    echo "</pre>";exit
                    ?>
                    <ul>
                    <?php while ($catquery->have_posts()) : $catquery->the_post(); ?>
                            <li><h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                <ul><li><?php the_content(); ?></li>
                                </ul>
                            </li>
<?php endwhile; ?> 
                    </ul>
                        <?php
                        wp_reset_postdata();

                        $big = 999999999; // need an unlikely integer
                         echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $catquery->max_num_pages
                        ));
                        ?>
                </div>
            </div>


        </div>
    </div>
</section>
<?php
get_footer();
