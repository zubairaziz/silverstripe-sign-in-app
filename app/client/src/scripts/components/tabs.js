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
    }
  },

  deactivateTabset: () => {
    const $tabset = document.querySelector('.tabset')
    if ($tabset.classList.contains('active')) {
      $tabset.classList.remove('active')
    }
  },

  handleLinkClick: () => {
    const tabs = document.querySelectorAll('.tab')
    const anchors = document.querySelectorAll('a')
    anchors.forEach((anchor) => {
      anchor.onclick = () => {
        fn.activateTabset()
        tabs.forEach((tab) => {
          if (tab.classList.contains('active')) {
            tab.classList.remove('active')
          }
        })
        fn.setDisplayedTab(`${anchor.getAttribute('data-tab')}`)
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
  can: () => true,
  run: fn.init,
}
