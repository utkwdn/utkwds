<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utk-web-design-system
 */

 namespace UTK\WebDesignSystem;

 require_once( 'Navigation.php' );

 class Menu {
    /** $menu_name
     * Name of the WordPress menu that contains the menu items.
     * 
     * @var string
     */
    protected $menu_name;

    /**
     * $post
     * Post object for the current post (if applicable)
     * Should be set to 0 if the current query is not a post.
     *
     * @var WP_Post|0
     */

    protected $post;

    /** $menu_items
     * Array of items to be used in the menu.
     * Array items should be WP_Post objects (that is the object type WordPress uses
     * to store menu item data).
     * 
     * @var WP_Post[]
     */
    protected $menu_items;

    /**
     * $links
     * Menu items that have been converted to simplified link arrays.
     *
     * @var array('title' => string, 'url' => string, 'isCurrent' => boolean)[]
     */
    protected $links;

    /**
     * Constructor for the Menu class.
     *
     * @param string  $menu_name
     * @param integer $custom_post
     */
    public function __construct( string $menu_name ) {

        $this->post = Navigation::get_current_post();
        $this->menu_name = $menu_name;

        $this->menu_items = $this->get_wp_menu();
        
    }

    /**
     * Passes the menu's name to wp_get_nav_menu_items().
     * If the result is false, returns an empty array.
     * Otherwise returns the resulting array.
     *
     * @return array
     */
    protected function get_wp_menu(): array {

        $menu_items = wp_get_nav_menu_items( $this->menu_name );

        if ( ! $menu_items ) {
            return array();
        }
    
        return $menu_items;
    }

    public function get_menu_items( ): array {
        return $this->menu_items;
    }
    public function get_links( ): array {
        if ( ! isset( $this->links ) ) {
            $this->links = $this->build_menu_links();
        }
        
        return $this->links;
    }

    protected function build_menu_links(): array {
        $menu_items = $this->get_menu_items();

        return array_map( function( $item ) {
            return array(
                'title' => $item->title,
                'url' => $item->url,
                'isCurrent' => $this->item_is_current( $item ),
            );
        }, $menu_items );
    }

    protected function item_is_current( $menu_item ): bool {
        if ( $this->post ) {
            return $this->post->ID === $menu_item->object_id;
        }

        return false;
    }

 }