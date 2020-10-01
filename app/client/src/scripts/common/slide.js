import requestTimeout from './requestTimeout'

export const slideUp = (element, duration = 400) => {
  return new Promise(function (resolve) {
    element.style.height = element.offsetHeight + 'px'
    element.style.transitionProperty = `height, margin, padding`
    element.style.transitionDuration = duration + 'ms'
    element.offsetHeight
    element.style.overflow = 'hidden'
    element.style.height = 0
    element.style.paddingTop = 0
    element.style.paddingBottom = 0
    element.style.marginTop = 0
    element.style.marginBottom = 0

    requestTimeout(() => {
      element.style.display = 'none'
      element.style.removeProperty('height')
      element.style.removeProperty('padding-top')
      element.style.removeProperty('padding-bottom')
      element.style.removeProperty('margin-top')
      element.style.removeProperty('margin-bottom')
      element.style.removeProperty('overflow')
      element.style.removeProperty('transition-duration')
      element.style.removeProperty('transition-property')
      resolve(false)
    }, duration)
  })
}

export const slideDown = (element, duration = 400) => {
  return new Promise(function (resolve) {
    element.style.removeProperty('display')
    let display = window.getComputedStyle(element).display

    if (display === 'none') display = 'block'

    element.style.display = display
    let height = element.offsetHeight
    element.style.overflow = 'hidden'
    element.style.height = 0
    element.style.paddingTop = 0
    element.style.paddingBottom = 0
    element.style.marginTop = 0
    element.style.marginBottom = 0
    element.offsetHeight
    element.style.transitionProperty = `height, margin, padding`
    element.style.transitionDuration = duration + 'ms'
    element.style.height = height + 'px'
    element.style.removeProperty('padding-top')
    element.style.removeProperty('padding-bottom')
    element.style.removeProperty('margin-top')
    element.style.removeProperty('margin-bottom')

    requestTimeout(() => {
      element.style.removeProperty('height')
      element.style.removeProperty('overflow')
      element.style.removeProperty('transition-duration')
      element.style.removeProperty('transition-property')
      resolve(false)
    }, duration)
  })
}

export const slideToggle = (target, duration = 300) => {
  if (window.getComputedStyle(target).display === 'none') {
    return slideDown(target, duration)
  } else {
    return slideUp(target, duration)
  }
}
