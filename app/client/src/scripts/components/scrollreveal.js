import ScrollReveal from 'scrollreveal'

const fn = {
  init: () => {
    ScrollReveal().reveal('[data-reveal]', { duration: 300, scale: 0.75 })
  },
}

export default {
  can: () => document.querySelectorAll('[data-reveal]').length,
  run: fn.init,
}
