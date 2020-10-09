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
