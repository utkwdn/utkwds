/**
 * After the bootstrap collapse animation is complete on the search field, focus on the search field.
 */
const searchSlider = document.getElementById('search-slider');
const searchSliderButton = document.getElementById('search-slider-button');

searchSlider.addEventListener('shown.bs.collapse', (event) => {
  const searchSliderField = document.getElementById('site-search-field-slider');
  searchSliderField.focus({ focusVisible: true });
  document.addEventListener('keydown', sliderCloseOnEsc);
});

const sliderCloseOnEsc = (evt) => {
  if (evt.key === 'Escape') {
    new bootstrap.Collapse(searchSlider, 'hide');
    searchSliderButton.focus({ focusVisible: true });
    document.removeEventListener('keydown', sliderCloseOnEsc);
  }
};
