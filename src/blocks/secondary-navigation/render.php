<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 * The following variables are exposed to the file:
 * 
 * $attributes (array): The block attributes.
 * $content (string): The block default content.
 * $block (WP_Block): The block instance.
 */
namespace UTK\WebDesignSystem;

$post_id = get_the_ID();
$post_parent = get_post_parent( $post_id );

function get_secondary_navigation( $post_id, $post_parent) {  

  echo "<menu>";

  if ( $post_parent ) : ?>
    <li class="page_parent">
      <a href="<?php echo get_permalink( $post_parent ); ?>">
        <?php echo get_the_title( $post_parent ); ?>
      </a>
    </li>

  <?php endif; ?>

  <?php
  
  $siblings = get_pages( array( 'parent' => $post_parent->ID ) );

  foreach ( $siblings as $page ) {

    $page_id = $page->ID;
    $current = false;
    
    if ( $page_id == $post_id ){
      $current = true;
    }
    
    ?>
    
    <li class="page_item page-item-<?php echo $page_id; ?> <?php if ( $current ) { echo 'current_page_item';} ?>">
      <a href="<?php echo get_permalink( $page_id );?>" <?php if ($current) { echo 'aria-current="page"';}?>>
        <?php echo get_the_title( $page_id ); ?>
      </a>

    <?php 
  
      if ( $current ){

        $children = wp_list_pages(
          array(
            'title_li' => '',
            'parent' => $page_id,
            'echo' => ''
          )
        );

        if ( ! empty( $children ) ){
          echo "<ul class='children'>$children</ul>";
        }
        
      } ?>

    </li>

    <?php
  }
  echo "</menu>";
  
}

?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?> >

  <button class="utkwds-section-nav-menu-mobile-button" data-bs-toggle="collapse" data-bs-target="#section-nav-menu-mobile-dropdown" aria-expanded="false" aria-controls="section-nav-menu-mobile-dropdown">In This Section</button>

  <div id="section-nav-menu-mobile-dropdown" class="utkwds-section-nav-menu-mobile collapse">
  
    <?php get_secondary_navigation( $post_id, $post_parent ); ?>

  </div>

  <div class="utkwds-section-nav-menu">

    <?php get_secondary_navigation( $post_id, $post_parent ); ?>

  </div>

</div>