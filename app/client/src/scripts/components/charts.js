import Chart from 'chart.js'

const fn = {
  init: () => {
    fn.setupWeeklySnapshot()
  },

  setupWeeklySnapshot: () => {
    const $charts = document.querySelectorAll('.week-chart')
    $charts.forEach(($chart) => {
      const ctx = $chart.getContext('2d')
      const labels = $chart.dataset.labels.split(',')
      const signin = $chart.dataset.signin.split(',')
      // const signinlabels = $chart.dataset.signinlabels.split(',')
      const signout = $chart.dataset.signout.split(',')
      const lunchout = $chart.dataset.lunchout.split(',')
      const lunchin = $chart.dataset.lunchin.split(',')
      const appointmentout = $chart.dataset.appointmentout.split(',')
      const appointmentin = $chart.dataset.appointmentin.split(',')
      new Chart(ctx, {
        type: $chart.dataset.type,
        data: {
          labels,
          datasets: [
            {
              label: 'Sign-In',
              data: signin,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#5A527755'],
            },
            {
              label: 'Sign-Out',
              data: signout,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#514A6B55'],
            },
            {
              label: 'Lunch Out',
              data: lunchout,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#6BC04B55'],
            },
            {
              label: 'Lunch In',
              data: lunchin,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#60AD4455'],
            },
            {
              label: 'Appointment Out',
              data: appointmentout,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#FFD27F55'],
            },
            {
              label: 'Appointment In',
              data: appointmentin,
              lineTension: 0,
              spanGaps: true,
              backgroundColor: ['#0000'],
              borderColor: ['#E6BD7255'],
            },
          ],
        },
        options: {
          responsive: true,
          aspectRatio: 2.5,
          lineTension: 0,
          spanGaps: true,
          scales: {
            yAxes: [
              {
                // type: 'time',
                // time: {
                //   unit: 'minute',
                //   displayFormats: {
                //     minute: 'h:mm a',
                //   },
                // },
                ticks: {
                  maxTicksLimit: 16,
                  beginAtZero: false,
                },
              },
            ],
          },
        },
      })
    })
  },
}

export default {
  can: () => document.querySelectorAll('.week-chart'),
  run: fn.init,
}
