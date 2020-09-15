import { on } from 'delegated-events'
import scrollTo from '../common/scrollTo'

const fn = {
  init: () => {
    fn.bindEvents()
    fn.handleUrl()
  },

  bindEvents: () => {
    on('click', '[data-scroll]', fn.handleClick)
  },

  handleClick: (e) => {
    e.preventDefault()

    const $el = e.target.closest('[data-scroll]')

    let targetSelector = null

    if ($el.dataset.scroll) {
      targetSelector = $el.dataset.scroll
    } else if ($el.tagName === 'A') {
      targetSelector = $el.hash
    } else {
      return
    }

    const $target = document.querySelector(targetSelector)

    if ($target) {
      scrollTo($target)
    }
  },

  handleUrl: () => {
    if (window.location.hash) {
      const $target = document.querySelector(window.location.hash)

      if ($target) {
        scrollTo($target, 30)
      }
    }
  },
}

export default {
  can: () => true,
  run: fn.init,
}
