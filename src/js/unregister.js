// Unregister block styles

wp.domReady(() => {
  wp.blocks.unregisterBlockStyle('core/image', 'rounded');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
});
