<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utk-web-design-system
 */

namespace UTK\WebDesignSystem;
use WP_Post;

/**
 * Navigation
 *
 * Collection of functions for building links based on WordPress context
 */
class Navigation {


    public static function get_current_post( $custom_post_id = 0) {
        global $post;

        if ( is_front_page() ) {
            return 0;
        }
        
        if ( $custom_post_id ) {
            $custom_post_object = get_post( $custom_post_id );
            if ( $custom_post_object instanceof WP_Post ) {
                return $custom_post_object;
            }
        } 

        if ($post instanceof WP_Post ) {
            return $post;
        }

        return 0;
    }

    public static function get_top_ancestor( $post_id = null, $exclude_current = false ): int {
        $post_id = $post_id ?? get_the_ID();

        $all_ancestors = get_post_ancestors( $post_id );

        if ( ! is_array( $all_ancestors ) || ! count( $all_ancestors ) ) {
            if ( $exclude_current ) {
                return false;
            }

            return $post_id;
        }

        return $all_ancestors[ count( $all_ancestors ) - 1 ];
    }

    public static function top_link( ?int $post_id, array $additional_properties = array() ): array {
        $top_ancestor = static::get_top_ancestor( $post_id );

        if ( $top_ancestor ) {
            $link = array(
                'title' => get_the_title( $top_ancestor ),
                'url' => get_permalink( $top_ancestor ),
            );

            return array_merge( $link, $additional_properties );
        }
        return 0;
    }

    public static function get_child_posts( int|object $post = 0 ): array|bool {
        $post = get_post( $post );
        $post_id = $post ? $post->ID : get_the_ID();

        if ( ! $post_id ) {
            return false;
        }

        $args = array(
            'orderby' => 'menu_order',
            'post_parent' => $post_id,
            'order' => 'ASC',
            'post_type' => get_post_type( $post_id ),
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $child_posts = get_posts( $args );

        if ( ! is_array( $child_posts ) ) {
            return false;
        }

        return $child_posts;
    }

    public static function get_sibling_posts( int|object $post = 0 ): array|bool {
        if ( is_object( $post ) ) {
            $post_id = $post->ID;
        } else {
            $post_id = is_int( $post ) && $post > 0 ? $post : get_the_ID();
        }

        if ( ! $post_id ) {
                return false;
        }

        if ( ! has_post_parent( $post_id ) ) {
                return false;
        }

        $parent = get_post_parent( $post_id );

        return static::get_child_posts( $parent->ID );
    }

    public static function convert_post_to_link( WP_Post|int $post, ?int $current_post_id = null ) {
        $post = get_post( $post );
        if ( $post ) {
            $link = array(
                'title' => Navigation::get_title_safe( $post ),
                'url' => get_permalink( $post ),
            );

            if ( $current_post_id ) {
                $link['isCurrent'] = $post->ID === $current_post_id;
            }

            return $link;
        }

        return false;
    }

    public static function get_title_safe( WP_Post|int $post ) {
        $post = get_post( $post );
        if ( $post ) {
            $hidden_by_editorskit = get_post_meta( $post->ID, '_editorskit_title_hidden', true );

            if ( $hidden_by_editorskit ) {
                update_post_meta( $post->ID, '_editorskit_title_hidden', false );
                $post_title = get_the_title( $post );
                update_post_meta( $post->ID, '_editorskit_title_hidden', $hidden_by_editorskit );
            } else {
                $post_title = get_the_title( $post );
            }

            return $post_title;
        }

        return '';
    }

}
