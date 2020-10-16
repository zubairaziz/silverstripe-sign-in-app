import { slideDown, slideUp } from '../common/slide'
import { on } from 'delegated-events'

const fn = {
  init: () => {
    on('click', '.dashboard-toggle', fn.handleToggle, { capture: true })
  },

  handleToggle: (e) => {
    const $container = e.target.closest('.dashboard-card')
    const $content = $container.querySelector('.dashboard-content')
    const $allContents = document.querySelectorAll('.dashboard-content')
    if ($content) {
      if ($content.classList.contains('active')) {
        $allContents.forEach(($allContent) => {
          $allContent.classList.remove('active')
        })
      } else {
        $allContents.forEach(($allContent) => {
          $allContent.classList.remove('active')
        })
        $content.classList.add('active')
      }
      $allContents.forEach(($allContent) => {
        if ($allContent.classList.contains('active')) {
          slideDown($allContent)
        } else {
          slideUp($allContent)
        }
      })
    }
  },
}

export default {
  can: () => document.querySelectorAll('.dashboard-card'),
  run: fn.init,
}
