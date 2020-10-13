import { slideToggle } from '../common/slide'
import { on } from 'delegated-events'

const fn = {
  init: () => {
    on('click', '.dashboard-toggle', fn.handleToggle, { capture: true })
  },

  handleToggle: (e) => {
    const $container = e.target.closest('.dashboard-card')
    const $content = $container.querySelector('.dashboard-content')
    slideToggle($content)
  },
}

export default {
  can: () => document.querySelectorAll('.dashboard-card'),
  run: fn.init,
}
