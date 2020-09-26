import jump from 'jump.js'

const scrollTo = ($target, additionalOffset = 0, callback) => {
  jump($target, { duration: 750, additionalOffset, callback })
}

export default scrollTo
