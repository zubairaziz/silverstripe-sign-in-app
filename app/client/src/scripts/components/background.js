import Splide from '@splidejs/splide'

const fn = {
  init: () => {
    fn.setupSlides()
  },

  setupSlides: () => {
    new Splide('.splide', {
      type: 'fade',
      rewind: true,
      perPage: 1,
      easing: 'linear',
      arrows: false,
      pagination: false,
      autoplay: true,
      speed: 600,
      drag: false,
      cover: true,
      fixedHeight: '100vh',
      fixedWidth: '100vw',
      pauseOnHover: false,
      pauseOnFocus: false,
      keyboard: false,
    }).mount()
  },
}

export default {
  can: () => true,
  run: fn.init,
}
