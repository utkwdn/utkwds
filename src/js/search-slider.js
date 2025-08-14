const searchSlider = document.getElementById('search-slider');
const searchSliderButton = document.getElementById('search-slider-button');

searchSliderButton.addEventListener("click", function () {
  const isOpen = searchSlider.classList.toggle('show');
  const searchSliderField = document.getElementById('site-search-field-slider');
  
  searchSliderButton.setAttribute('aria-expanded', isOpen.toString());
  
  document.addEventListener('keydown', sliderCloseOnEsc);

  setTimeout(() => {
    searchSliderField.focus({ focusVisible: isOpen.toString() });
  }, 100);
});

const sliderCloseOnEsc = (evt) => {
  if (evt.key === 'Escape') {
    searchSlider.classList.remove('show');
    searchSliderButton.setAttribute('aria-expanded', false);
    document.removeEventListener('keydown', sliderCloseOnEsc);
  }
};
