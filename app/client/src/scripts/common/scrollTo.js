import jump from 'jump.js'

// const getStuckHeaderHeight = () => {
//     const $header = document.querySelector('.site-header')

//     if ($header) {
//         return $header.offsetHeight - 0
//     }

//     return 0
// }

const scrollTo = ($target, additionalOffset = 0, callback) => {
  // const headerHeight = getStuckHeaderHeight()
  // const headerOffset = Math.floor(headerHeight + headerHeight / 3) * -1
  const headerOffset = 0
  const offset = headerOffset - additionalOffset

  jump($target, { duration: 750, offset, callback })
}

export default scrollTo
