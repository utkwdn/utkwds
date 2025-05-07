<?php 

// Replace the site tagline block with a customizer tagline link

//add_filter( 'render_block_core/site-tagline', 'utkwds_render_block_core_tagline', 10, 2 );

function utkwds_render_block_core_tagline( $block_content, $block ) {

  if ( get_theme_mod( 'tagline_link' ) ) {
    $block_content ="<p class='header-site-tagline'><a href='" . esc_url( get_theme_mod( 'tagline_link' ) ) . "'>" . get_bloginfo( 'description' ) . "</a></p>";
  }

  return $block_content;
}

add_filter( 'render_block_core/embed', 'utkwds_render_block_core_embed', 10, 2 );

function utkwds_render_block_core_embed( $block_content, $block ) {

  if ( ! empty( $block['attrs']['providerNameSlug']) && $block['attrs']['providerNameSlug'] == 'youtube' ) {
    
    wp_enqueue_script_module( 'yt-lite-embed');
    
    $videoId = preg_replace('/^.*v=([^&]+).*$/', '$1', $block['attrs']['url']);

    // If the video ID is not found, return the original block content
    if ( empty( $videoId ) ) {
      return $block_content;
    }

    $embed = new WP_HTML_Tag_Processor( $block_content );
    $embed->next_tag( 'figure' );
    $embed->remove_class( 'wp-embed-aspect-16-9' );
    $embed->remove_class( 'wp-has-aspect-ratio' );
    $figure_class = $embed->get_attribute( 'class' ); 
    $embed->next_tag( 'div' );
    $div_class = $embed->get_attribute( 'class' );
    $embed->next_tag('iframe');
    $title = $embed->get_attribute( 'title' );

    $block_content = '<figure class="'. $figure_class .'"><div class="'. $div_class .'"><lite-youtube videoid="'. $videoId .'" videotitle="'. $title .'" playLabel="Play: '. $title .'"></lite-youtube></div></figure>';
    
  }
  
  return $block_content;

}