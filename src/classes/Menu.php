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
            
            $is_current = $this->item_is_current( $item, 'array' );

            $item_link = array(
                'title' => $item->title,
                'url' => $item->url,
                'isCurrent' => $is_current['isCurrent'],
                'isParent' => $is_current['isParent']
            );

            if (isset( $item->submenu)) {
                $item_link['submenu'] = $this->build_menu_links( $item->submenu );
            }

            return $item_link;
        }, $menu_items );
    }

    protected function item_is_current( $menu_item, $return_type = null ): bool|array {

        if ( $this->post ) {
            if( $this->post->ID === intval( $menu_item->object_id ) ){
                
                if ( $return_type === 'array') {
                    return array(
                        'isCurrent' => true,
                        'isParent' => false,
                    );
                } else {
                    return true;            
                }
            } 
        }

        //check children for current
        if ( isset( $menu_item->submenu ) ) {
            foreach ( $menu_item->submenu as $child ) {
                if ( $this->item_is_current( $child ) ) {
                
                    if ( $return_type === 'array') {
                        return array(
                            'isCurrent' => true,
                            'isParent' => true,
                        );
                    } else {
                        return true;            
                    }
                }
            }
        }

        if ( $return_type === 'array') {
            return array(
                'isCurrent' => false,
                'isParent' => false,
            );
        }
        return false;
    }

    protected function get_link_markup( array $link_args, string $interactive = '' ): string {
        $default_args = array(
            'interactive' => '',
            'list_item_classes' => '',
            'link_classes' => '',
            'top_level_links' => false,
            'submenu_id' => '',
            'bold_holder' => true,
        );
        $args = wp_parse_args( $link_args, $default_args );

        ['link' => $link, 'link_classes' => $link_classes, 'top_level_links' => $top_level_links, 'submenu_id' => $submenu_id ] = $args;
        if (isset($link_args['link']['submenu'])) {
            $submenu = $link_args['link']['submenu'];
        } else {
            $submenu = '';
        }
        
        if (! $submenu || ( $submenu && $top_level_links ) ) {
            $item_element_open = 'a href="' . $link['url'] . '"';
            $item_element_close = 'a';
        } else {
            $item_element_open = 'button';
            $item_element_close = 'button';
        }

        $link_attributes = array();

        if ( $submenu && trim($args['interactive']) === 'collapse' ) {
            $link_attributes[] = 'data-toggle="collapse"';
            $link_attributes[] = 'data-target="#' . $submenu_id . '"';
            $link_attributes[] = 'aria-expanded="false"';
            $link_attributes[] = 'aria-controls="' . $submenu_id . '"';
        }

        if ( $submenu && trim($args['interactive']) === 'dropdown' ) {
            $link_attributes[] = 'data-toggle="dropdown"';
            $link_attributes[] = 'data-display="static"';
            $link_attributes[] = 'aria-expanded="false"';
            $link_classes .= ' dropdown-toggle';
        }

        if ($submenu && count($link_attributes)) {
            $item_element_open .= ' ' . implode(' ', $link_attributes);
        }

        $html = '<'. $item_element_open . ' class="' . $link_classes . '" ';
        
        if ($link['isCurrent']){ 
            $html .= 'aria-current="page" ';
        }
        $html .= '>';
        if ($args['bold_holder']) {

            $html .= '<span class="bold-holder"><span class="real-title">' . $link['title'] . '</span><span class="bold-wrapper" aria-hidden="true">';
        }
        $html .= $link['title'];
        if ($args['bold_holder']) {
            $html .= '</span></span>';
        }
        $html .= '</' . $item_element_close . '>';

        return $html;
    }

    protected function duplicate_link_text( string $text ): string {
        return "$text Overview";
    }

    protected function get_menu_item_markup( array $link, array $args, int $current_depth = 1 ): string {
        $default_args = array(
            'depth' => 0,
            'interactive' => '',
            'list_item_classes' => '',
            'link_classes' => '',
            'top_level_links' => false,
            'submenu_id' => '',
            'duplicate_top_links' => false,
            'bold_holder' => true,
        );

        $args = wp_parse_args( $args, $default_args );

        $submenu = '';

        if ( $current_depth <= $args['depth'] && isset( $link['submenu'] ) ) {
            // echo '<pre>';
            // print_r($link);
            // echo '</pre>';
            $submenu_args = array(
                'list_element' => 'ul',
                'list_classes' => '',
                'list_item_classes' => $args['list_item_classes'],
                'link_classes' => $args['link_classes'],
                'top_level_links' => $args['top_level_links'],
                'id' => $args['submenu_id'],
                'interactive' => $args['interactive'],
                'bold_holder' => $args['bold_holder'],
            );
            
            if (trim($args['interactive']) === 'collapse') {
                // TODO: Change to `collapse` once BS is totally removed
                $submenu_args['list_classes'] .= ' collapse';
            } elseif (trim($args['interactive']) === 'dropdown') {
                $submenu_args['list_classes'] .= ' dropdown-menu';
                $submenu_args['list_item_classes'] .= ' dropdown';
            }

            $submenu_links = $link['submenu'];

            if ($args['duplicate_top_links']) {
                
                $top_link = array('title' => $this->duplicate_link_text($link['title']), 'url' => $link['url'], 'isCurrent' => $link['isCurrent'] && ! $link['isParent'] );

                array_unshift($submenu_links, $top_link);
            }
            
            if ( $args['interactive'] ) {
                $div_id = $submenu_args['id'];
                $div_classes = $submenu_args['list_classes'];

                unset( $submenu_args['list_classes'], $submenu_args['id'] );
                $submenu = $this->get_menu_markup( $submenu_args, $submenu_links, $current_depth + 1 );
                $submenu = '<div id="' . $div_id . '" class="' . $div_classes . '">' . $submenu . '</div>';
            } else {
                $submenu = $this->get_menu_markup( $submenu_args, $submenu_links, $current_depth + 1 );
            }
        }
        
        $link_args = array(
            'link' => $link,
            'submenu_id' => $submenu ? $args['submenu_id'] : '',
            'top_level_links' => $args['top_level_links'],
            'link_classes' => $args['link_classes'],
            'interactive' => $args['interactive'],
            'bold_holder' => $args['bold_holder'],
        );

        $link_html = $this->get_link_markup( $link_args );

        $list_item_markup = '<li class="' . $args['list_item_classes'] . '">' . $link_html . $submenu . '</li>';
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
            'id' => '',
            'interactive' => '',
            'duplicate_top_links' => false,
            'bold_holder' => true,
        );
        
        
        $args = wp_parse_args( $args, $default_args );

        if ( ! count ($this->links) ) {
            return '';
        }

        if ($args['id']) {
            // echo '<pre>';
            // print_r($args);
            // echo '</pre>';
            $args['submenu_id'] = $args['id'] . '-submenu';
        } else {
            $args['submenu_id'] = 'submenu';
        }
        
        $menu_items = '';

        foreach ( $links as $link ) {

            $item_args = $args;
            $item_args['submenu_id'] = $args['submenu_id'] . '-' . sanitize_title( $link['title'] );
            $menu_items .= $this->get_menu_item_markup( $link, $item_args, $current_depth );
        }

        return '<' . $args['list_element'] . ' id="' . $args['id'] . '"' . ' class="' . $args['list_classes'] . '">' . $menu_items . '</' . $args['list_element'] . '>';
    }

 }