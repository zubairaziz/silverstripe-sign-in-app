import wretch from 'wretch'

export default wretch().defaults({
  headers: { 'X-Requested-With': 'XMLHttpRequest' },
})
