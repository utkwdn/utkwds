// Unregister block styles

wp.domReady(() => {
  wp.blocks.unregisterBlockStyle('core/image', 'rounded');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
  wp.blocks.unregisterBlockStyle('core/table', 'stripes');
  wp.blocks.unregisterBlockStyle('core/separator', 'wide');
  wp.blocks.unregisterBlockStyle('core/separator', 'dots');
  wp.blocks.unregisterBlockStyle('core/social-links', 'logos-only');
  wp.blocks.unregisterBlockStyle('core/social-links', 'pill-shape');
  wp.blocks.unregisterBlockStyle('core/social-links', 'outline');
});