<?php
if (!defined('ABSPATH')) {
    exit;
}


if (!function_exists('RPKH_related_post_output')) {
    add_filter('the_content', 'RPKH_related_post_output');
    function RPKH_related_post_output($default)
    {
        if (is_single()) {

            $post_from = get_option('option');
            $related_post = null;

            // if show post according to post type
            if ($post_from['posts_according_to'] == "Post Type") {
                $post_type = get_post_type();
                // get data
                $related_post = new WP_Query(
                    array(
                        'post_type' => $post_type,
                        'post_status' => 'publish',
                        'post__not_in' => array(get_the_ID())
                    )
                );
            }

            // if show post according to Category
            else if ($post_from['posts_according_to'] == "Category") {
                $post_type = get_post_type();

                $tax = get_the_taxonomies();
                $cat = array_keys($tax)[0];

                $category = get_the_terms(get_the_ID(), $cat);
                $category_in = array();

                foreach ($category as $term) {
                    $category_in[] = $term->term_taxonomy_id;
                    $taxonomy = $term->taxonomy;
                    $taxonomy_name = $term->name;
                }
                $term = $tax[array_keys($tax)[0]];

                // get Data
                $related_post = new WP_Query(
                    array(
                        'post_type' => $post_type,
                        'post_status' => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'slug',
                                'terms' => $taxonomy_name
                            )
                        ),
                        'post__not_in' => array(get_the_ID())
                    )
                );
            }

            // how to display data
            $val = get_option('option');
            if ($val['posts_display'] == 'DESC')
                $related_post->posts = array_reverse($related_post->posts);

            // Max Posts Count
            if ($val['max_posts_count'] && $val['max_posts_count'] <= count($related_post->posts))
                $related_post->posts = array_slice($related_post->posts, 0, $val['max_posts_count']);
            else echo '<div class="alert" role="alert">
        Please Select Post Count To Display! (Amazing Related Post Plugin)
          </div>
          ';

            // Posts Desgin 
            $val['posts_design'] === 'Grid' ? $desgin = 'grid' : $desgin =  'list';

            // Html content
            if ($val['max_posts_count']) {
                $default .=  "<h4 class='heading'>" .  __("Related Posts :") . "</h4>";
                $default .= '<div class="post-container ' . $desgin . '">';
                foreach ($related_post->posts as $item) {
                    if ($desgin == "grid")
                        $post_content = substr($item->post_content, 0, 50);
                    else
                        $post_content = substr($item->post_content, 0, 200);


                    // if post have image
                    if (get_the_post_thumbnail_url($item->ID)) {
                        $img = '<div class="img-container">
                        <img src="' . get_the_post_thumbnail_url($item->ID) . '">
                    </div>';


                        $separator = '<span class="separator"> </span>';
                    } else {
                        $img = null;
                        $separator = null;
                    }

                    $default .= sprintf('
                        <div class="post">
                        %s
                        <div class="text">
                        %s
                        <a href="%s" >
                        %s
                        <p class="content">
                        %s ...
                        </p>
                        </a>
                        </div>
                        </div>', $img, $separator, $item->guid, __($item->post_title), wp_strip_all_tags(__($post_content)));
                }
                $default .= "</div>";
            }
            return $default;
        }
    }
}
