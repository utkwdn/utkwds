<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utk-web-design-system
 */

 namespace UTK\WebDesignSystem;
 use WP_Post;

 require_once( 'Navigation.php' );

 class Breadcrumbs {
    /**
     * Post object for the current post (if applicable)
     * Should be set to 0 if the current query is not a post.
     *
     * @var WP_Post|0
     */
    protected $post;
    /**
     * Post type for the current post (if applicable))
     *
     * @var string|null
     */
    protected $post_type;

    /** $links
     * Array of links to be used in the menu.
     * Items should be of the format array( 'title' => string, 'url' => string, 'isCurrent' => true|false )
     * 
     * @var array
     */
    protected $links;

    public function __construct( WP_Post|int $custom_post = 0 ) {
        global $post_type;

        $this->post = Navigation::get_current_post( $custom_post );
        
        if ($post_type) {
            $this->post_type = $post_type;
        } else {
            $this->post_type = null;
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

    protected function add_current_link( array $links ): array {
        if (is_singular()) {
            $current_link = Navigation::convert_post_to_link( $this->post, get_the_ID($this->post) );
            return array_merge( $links, array( $current_link ) );
        }

        return $links;
    }

    protected function default_breadcrumb_links(): array {

        if (! $this->post && ! $this->post_type ) {
            do_action('qm/debug', 'No post or post type found for breadcrumbs.');
            return array();
        }
        
        $initial_links = static::default_initial_links();

        $ancestors = get_post_ancestors( $this->post );

        $breadcrumb_links = array();

        if ( is_array( $ancestors ) && count( $ancestors ) > 0 ) {
            $ancestor_links = array_map( function ( $ancestor ) {
                return Navigation::convert_post_to_link( $ancestor, get_the_ID($this->post) );
            }, $ancestors );
            $breadcrumb_links = array_merge( $breadcrumb_links, $ancestor_links );
        }

        if( $this->post_type && ! ($this->post_type === 'page' || $this->post_type === 'post') ) {
            $post_type_archive_url = get_post_type_archive_link( $this->post_type );
            if ( $post_type_archive_url ) {
                $archive_links = array(
                    array(
                        'title' => get_post_type_object( $this->post_type )->labels->name,
                        'url' => $post_type_archive_url,
                        'isCurrent' => is_post_type_archive($this->post_type) ? true : false,
                    ),
                );
                $breadcrumb_links = array_merge( $breadcrumb_links, $archive_links );
            }
        }

        return $this->add_current_link( array_merge( $initial_links, $breadcrumb_links ) );
    }

 }