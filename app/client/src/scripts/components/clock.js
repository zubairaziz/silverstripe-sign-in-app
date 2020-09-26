const addZero = (val) => (val <= 9 ? `0${val}` : val)

const fn = {
  init: () => {
    fn.getTime()
    fn.getAmPm()
    fn.getDate()
    setInterval(() => {
      fn.getTime()
      fn.getAmPm()
      fn.getDate()
    }, 30000) // 30 seconds
  },

  getTime: () => {
    let date = new Date()
    let hours = date.getHours()
    let minutes = date.getMinutes()

    //make clock a 12 hour clock instead of 24 hour clock
    hours = hours > 12 ? hours - 12 : hours
    hours = hours === 0 ? 12 : hours

    //invokes function to make sure number has at least two digits
    hours = addZero(hours)
    minutes = addZero(minutes)

    //changes the html to match results
    document.querySelector('.hours').innerHTML = hours
    document.querySelector('.minutes').innerHTML = minutes
  },

  getAmPm: () => {
    const date = new Date()
    const hours = date.getHours()
    const am = document.querySelector('.am').classList
    const pm = document.querySelector('.pm').classList

    hours >= 12 ? am.add('hidden') : pm.add('hidden')
    hours >= 12 ? pm.remove('hidden') : am.remove('hidden')
  },

  getDate: () => {
    var date = new Date()
    let currentDay = date.getDay()
    let currentMonth = date.getMonth()
    let currentDate = date.getDate()
    let dayField = document.querySelector('.day')
    let monthField = document.querySelector('.month')
    let dateField = document.querySelector('.date')
    let days = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
      ],
      months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
      ]
    dayField.innerHTML = days[currentDay]
    monthField.innerHTML = months[currentMonth]
    dateField.innerHTML = currentDate
  },
}

export default {
  can: () => true,
  run: fn.init,
}
