import './styles/index.css'
import 'alpinejs'
import 'what-input'
import FastClick from 'fastclick'

document.addEventListener(
  'DOMContentLoaded',
  () => {
    FastClick.attach(document.body)
  },
  false
)

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

// if ('serviceWorker' in navigator) {
//   window.addEventListener('load', () => {
//     const swUrl = '/_resources/app/client/dist/service-worker.js'
//     navigator.serviceWorker.register(swUrl)
//   })
// }
