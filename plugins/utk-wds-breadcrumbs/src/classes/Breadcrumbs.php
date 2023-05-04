<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utk-web-design-system
 */

 namespace UTK\WebDesignSystem;

 require_once( 'Navigation.php' );

 class Breadcrumbs {
    protected $post;
    protected $links;

    public function __construct( WP_Post|int $post = 0 ) {
        if ( is_front_page() ) {
            $this->post = 0;
        } elseif ( $post ) {
            $this->post = get_post( $post );
        } else {
            $this->post = get_post();
        }

        $this->links = $this->default_breadcrumb_links();
    }

    public function get_links( ): array {
        return $this->links;
    }

    protected function default_initial_links(): array {
        return array(
            array(
                'title' => __( 'Home', 'utk-web-design-system' ),
                'url' => home_url(),
                'isCurrent' => false,
            ),
        );
    }

    protected function default_breadcrumb_links(): array {

        if (! $this->post) {
            return array();
        }
        
        $initial_links = static::default_initial_links();

        $current_link = Navigation::convert_post_to_link( $this->post, get_the_ID($this->post) );

        $ancestors = get_post_ancestors( $this->post );
        if ( is_array( $ancestors ) && count( $ancestors ) > 0 ) {
            $breadcrumb_links = array_map( function ( $ancestor ) {
                return Navigation::convert_post_to_link( $ancestor, get_the_ID($this->post) );
            }, $ancestors );
        } else {
            $breadcrumb_links = array();
        }

        return array_merge( $initial_links, $breadcrumb_links, array( $current_link ) );
    }

 }