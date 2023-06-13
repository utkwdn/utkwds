<?php
/**
 * Houses the static \UTK\WebDesignSystem\Navigation class
 *
 * @package utk-web-design-system
 */

 namespace UTK\WebDesignSystem;
 use WP_Post;

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

        $this->menu_items = $this->build_menu_hierarchy($this->get_wp_menu());
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
            if (WP_DEBUG) {
                echo 'WordPress could not find a menu called "' . $this->menu_name .'"';
            }
            return array();
        }
        return $menu_items;
    }

    // function to organize menu items into a hierarchical array with parent and child items
    protected function build_menu_hierarchy( $menu_items, $parent_id = 0 ) {
        $menu = array();
        foreach( $menu_items as $menu_item ) {
            if( $menu_item->menu_item_parent == $parent_id ) {
                $submenu = $this->build_menu_hierarchy( $menu_items, $menu_item->ID );
                if( !empty( $submenu ) ) {
                    $menu_item->submenu = $submenu;
                }
                $menu[$menu_item->ID] = $menu_item;
            }
        }
        return $menu;
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

    protected function build_menu_links( array $menu_items = array() ): array {
        if ( ! count( $menu_items ) ) {
            $menu_items = $this->get_menu_items();
        }

        return array_map( function( $item ) {
            $item_link = array(
                'title' => $item->title,
                'url' => $item->url,
                'isCurrent' => $this->item_is_current( $item ),
            );

            if (isset( $item->submenu)) {
                $item_link['submenu'] = $this->build_menu_links( $item->submenu );
            }

            return $item_link;
        }, $menu_items );
    }

    protected function item_is_current( $menu_item ): bool {
        if ( $this->post ) {
            return $this->post->ID === $menu_item->object_id;
        }

        return false;
    }

    protected function get_menu_item_markup( array $link, array $args, int $current_depth = 1 ): string {
        $default_args = array(
            'depth' => 0,
            'list_item_classes' => '',
            'link_classes' => '',
            'top_level_links' => true,
            'submenu_id' => '',
        );

        $args = wp_parse_args( $args, $default_args );

        $submenu = '';

        if ( $current_depth <= $args['depth'] && isset( $link['submenu'] ) ) {
            
            $submenu_args = array(
                'list_element' => 'ul',
                'list_classes' => 'collapse',
                'list_item_classes' => $args['list_item_classes'],
                'link_classes' => $args['link_classes'],
                'top_level_links' => $args['top_level_links'],
                'id' => $args['submenu_id'],
            );

            do_action('qm/debug', $submenu_args);
            $submenu = $this->get_menu_markup( $submenu_args, $link['submenu'], $current_depth + 1 );
        }
        if (! $submenu || ( $submenu && $args['top_level_links'] ) ) {
            $item_element_open = 'a href="' . $link['url'] . '"';
            $item_element_close = 'a';
        } else {
            $item_element_open = 'button';
            $item_element_close = 'button';
        }

        if ($submenu) {
            $item_element_open .= ' data-bs-toggle="collapse" data-bs-target="#' . $args['submenu_id'] . '"  aria-expanded="false" aria-controls="' . $args['submenu_id'] . '"';
        }

        $list_item_markup = '<li class="' . $args['list_item_classes'] . '"><'. $item_element_open . ' class="' . $args['link_classes'] . '" ';
        if ($link['isCurrent']){ 
            $list_item_markup .= 'aria-disabled="true" ';
        }
        $list_item_markup .= '>' . $link['title'] . '</' . $item_element_close . '>' . $submenu . '</li>';
        return $list_item_markup;
    }

    public function get_menu_markup( array $args = array(), array|null $links = null, $current_depth = 1 ) {
        if ( $links === null ) {
            $links = $this->links;
        }

        $default_args = array(
            'depth' => 0,
            'list_element' => 'menu',
            'list_classes' => '',
            'list_item_classes' => '',
            'link_classes' => '',
            'id' => ''
        );

        
        $args = wp_parse_args( $args, $default_args );
    
        if ( ! count ($this->links) ) {
            return '';
        }

        if ($args['id']) {
            $args['submenu_id'] = $args['id'] . '-submenu';
        }
        do_action('qm/debug', $args);
        $menu_items = '';

        foreach ( $links as $link ) {
            $menu_items .= $this->get_menu_item_markup( $link, $args, $current_depth );
        }

        return '<' . $args['list_element'] . ' id="' . $args['id'] . '"' . ' class="' . $args['list_classes'] . '">' . $menu_items . '</' . $args['list_element'] . '>';
    }

 }