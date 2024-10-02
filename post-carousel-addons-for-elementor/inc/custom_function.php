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
        $author = array();
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1 // this will retrive all the post that is published
        );
        $author_id = array_intersect(array_unique(array_column(get_posts($args), 'post_author')), array_column(get_users(), 'ID'));
        foreach ($author_id as $id) {
            $author[$id] = array_column(get_users(), 'display_name', 'ID')[$id];
        }
        return $author;
    }

    public function eshuzu_posts_query($args) {
        $value = $args;
        $args = array(
            'post_type' => $value['post_type']
        );
        if ($value['posts_per_page'] == 0):
            $args['posts_per_page'] = -1;
        else:
            $args['posts_per_page'] = $value['posts_per_page'];
        endif;
        if ($value['include_select_term'])
            $args['category__in'] = $value['include_select_term'];
        if ($value['include_select_tags'])
            $args['tag__in'] = $value['include_select_tags'];
        if ($value['include_select_author'])
            $args['author__in'] = $value['include_select_author'];
        //Excluded
        if ($value['exclude_select_term'])
            $args['category__not_in'] = $value['exclude_select_term'];
        if ($value['exclude_select_tags'])
            $args['tag__not_in'] = $value['exclude_select_tags'];
        if ($value['exclude_select_author'])
            $args['author__not_in'] = $value['exclude_select_author'];
        if ($value['ignore_sticky_post'] == 'yes')
            $args['ignore_sticky_posts '] = true;
        if ($value['post_order'])
            $args['order'] = $value['post_order'];
        if ($value['post_order_by'])
            $args['orderby'] = $value['post_order_by'];

        return $the_query = new WP_Query($args);
    }
}