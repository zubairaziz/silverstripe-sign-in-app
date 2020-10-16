import flatpickr from 'flatpickr'

const fn = {
  init: () => {
    fn.setupTimePickers()
  },

  setupTimePickers: () => {
    const $timePickers = document.querySelectorAll('.time-picker')
    $timePickers.forEach(($timePicker) => {
      flatpickr($timePicker, {
        noCalendar: true,
        enableTime: true,
        dateFormat: 'h:i K',
        defaultDate: $timePicker.dataset.defaultDate,
      })
    })
  },
}

export default {
  can: () => document.querySelectorAll('.time-picker'),
  run: fn.init,
}
