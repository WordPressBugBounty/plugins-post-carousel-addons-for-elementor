<?php

class  Eshuzu_Post_Carousel_Custom_Function {
    public function eshuzu_carousel_setting($eshuzu_carousel_setting) {
        return ($eshuzu_carousel_setting);
    }

    public function eshuzu_get_post_type() {
        $exclude = array('elementor_library' => 'My Templates', 'attachment' => 'attachment');
        return array_diff_key(array_column(get_post_types(array('public' => true), 'objects'), 'label', 'name'), $exclude);
    }

    public function eshuzu_get_term_list() {
        return array_column(get_categories(), 'name', 'term_id');
    }

    public function eshuzu_get_tag_list() {
        return array_column(get_tags(), 'name', 'term_id');
    }

    public function eshuzu_get_author_list() {
        $authors = get_users( array(
            'has_published_posts' => array( 'post' ),
            'fields' => array( 'ID', 'display_name' ),
        ) );

        $author_list = array();
        foreach ( $authors as $author ) {
            $author_list[ $author->ID ] = $author->display_name;
        }

        return $author_list;
    }

    public function eshuzu_posts_query($args) {
        $value = $args;
        $args = array(
            'post_type' => $value['post_type']
        );

        // Posts per page
        if ($value['posts_per_page'] == 0):
            $args['posts_per_page'] = -1;
        else:
            $args['posts_per_page'] = $value['posts_per_page'];
        endif;

        // Build tax_query for includes
        $tax_query = array();
        $relation = isset($value['query_relation']) ? $value['query_relation'] : 'AND';

        if (!empty($value['include_select_term'])) {
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $value['include_select_term'],
                'operator' => 'IN',
            );
        }

        if (!empty($value['include_select_tags'])) {
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $value['include_select_tags'],
                'operator' => 'IN',
            );
        }

        // Apply tax_query with relation if we have taxonomy filters
        if (!empty($tax_query)) {
            $tax_query['relation'] = $relation;
            $args['tax_query'] = $tax_query;
        }

        // Handle excludes separately (always use AND for exclusions)
        if (!empty($value['exclude_select_term'])) {
            $args['category__not_in'] = $value['exclude_select_term'];
        }
        if (!empty($value['exclude_select_tags'])) {
            $args['tag__not_in'] = $value['exclude_select_tags'];
        }

        // Author includes/excludes
        if (!empty($value['include_select_author'])) {
            $args['author__in'] = $value['include_select_author'];
        }
        if (!empty($value['exclude_select_author'])) {
            $args['author__not_in'] = $value['exclude_select_author'];
        }

        // Other options
        if ($value['ignore_sticky_post'] == 'yes') {
            $args['ignore_sticky_posts'] = true;
        }
        if (!empty($value['post_order'])) {
            $args['order'] = $value['post_order'];
        }
        if (!empty($value['post_order_by'])) {
            $args['orderby'] = $value['post_order_by'];
        }

        return new WP_Query($args);
    }
}