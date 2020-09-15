export const isTouchDevice = () => {
  return 'ontouchstart' in document.documentElement
}
