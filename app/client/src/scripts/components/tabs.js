const fn = {
  init: () => {
    fn.setTabsetHeight()
    fn.handleLinkClick()
    fn.handleCloseButton()
  },

  setTabsetHeight: () => {
    const $header = document.querySelector('header')
    const $headerRect = $header.getBoundingClientRect()
    document.documentElement.style.setProperty(
      '--tabset-height',
      `calc(100vh - ${$headerRect.height}px - 1rem)`
    )
    document.documentElement.style.setProperty(
      '--tabset-position',
      `translate3d(0, calc(100vh - ${$headerRect.height}px - 1rem), 0)`
    )
    document.documentElement.style.setProperty('--tabset-opacity', '1')
    window.setTimeout(() => {
      document.documentElement.style.setProperty(
        '--tabset-transition',
        'transform 0.5s linear'
      )
    }, 50)
  },

  setDisplayedTab: (tabname) => {
    const activeTab = document.querySelector(tabname)
    if (!activeTab.classList.contains('active')) {
      activeTab.classList.add('active')
    }
  },

  activateTabset: () => {
    const $tabset = document.querySelector('.tabset')
    if (!$tabset.classList.contains('active')) {
      $tabset.classList.add('active')
      window.setTimeout(() => {
        window.addEventListener('click', fn.handleClickOutside, {
          passive: true,
        })
      }, 250)
    }
  },

  handleClickOutside: (e) => {
    const $tabset = document.querySelector('.tabset')
    const $navigation = document.querySelector('nav')
    var isClickInsideElement =
      $tabset.contains(e.target) || $navigation.contains(e.target)
    if (!isClickInsideElement) {
      fn.deactivateTabset()
    }
  },

  deactivateTabset: () => {
    const $tabset = document.querySelector('.tabset')
    if ($tabset.classList.contains('active')) {
      $tabset.classList.remove('active')
      window.removeEventListener('click', fn.handleClickOutside, {
        passive: true,
      })
    }
  },

  handleLinkClick: () => {
    const $tabs = document.querySelectorAll('.tab')
    const $anchors = document.querySelectorAll('a:not(.dashboard-link)')
    $anchors.forEach(($anchor) => {
      $anchor.onclick = () => {
        fn.activateTabset()
        $tabs.forEach(($tab) => {
          if ($tab.classList.contains('active')) {
            $tab.classList.remove('active')
          }
        })
        fn.setDisplayedTab(`${$anchor.getAttribute('data-tab')}`)
        return false
      }
    })
  },

  handleCloseButton: () => {
    const buttons = document.querySelectorAll('.tabset-close')
    buttons.forEach((button) => {
      button.onclick = () => {
        fn.deactivateTabset()
        return false
      }
    })
  },
}

export default {
  can: () => document.querySelector('.tabset'),
  run: fn.init,
}
