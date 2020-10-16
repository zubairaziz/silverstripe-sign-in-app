import Chart from 'chart.js'

const fn = {
  init: () => {
    fn.setupTimePickers()
  },

  setupTimePickers: () => {
    const $charts = document.querySelectorAll('.week-chart')
    $charts.forEach(($chart) => {
      new Chart($chart, {
        // Options
      })
    })
  },
}

export default {
  can: () => document.querySelectorAll('.week-chart'),
  run: fn.init,
}
