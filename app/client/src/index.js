import './styles/index.css'
import 'alpinejs'
import FastClick from 'fastclick'

if ('addEventListener' in document) {
  document.addEventListener(
    'DOMContentLoaded',
    () => {
      FastClick.attach(document.body)
    },
    false
  )
}

if ('serviceWorker' in navigator) {
  // Use the window load event to keep the page load performant
  window.addEventListener('load', () => {
    navigator.serviceWorker.register(
      '/_resources/app/client/dist/service-worker.js'
    )
  })
}

document.addEventListener('DOMContentLoaded', () => {
  ;((r) => {
    r.keys()
      .reduce((modules, script) => {
        const module = r(script).default
        module && modules.push(module)
        return modules
      }, [])
      .map((module) => (module.can === true || module.can()) && module.run())
  })(require.context('scripts', true, /^(?!.*(common)).*\.js$/))
})
