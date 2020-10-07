// eslint-disable-next-line prettier/prettier
import { on } from 'delegated-events'
// eslint-disable-next-line prettier/prettier
import { handleValidation, handleBlur } from '../common/validation'
import Imask from 'imask'

const fn = {
  init: () => {
    on('blur', '.has-error', handleBlur, {
      capture: true,
    })
    on('change', '.has-error', handleBlur, {
      capture: true,
    })
    on('change', '.has-error blur', handleBlur, {
      capture: true,
    })
    on('submit', '[data-form-ajax]', fn.handleAjax)
    on('submit', '.sign-in-form', fn.handleSignInAjax)
    fn.setupPINMasking()
  },

  handleAjax: (e) => {
    e.preventDefault()

    const $form = e.target
    const isValid = handleValidation($form)

    if (isValid) {
      const $formMessages = document.querySelector('.form-messages')
      const $submitButton = $form.querySelector('[type=submit]')
      fn.toggleSubmit($submitButton)

      ajax
        .url($form.action)
        .body(new FormData($form))
        .post()
        .json((res) => {
          if (res.success) {
            $form.reset()

            if ($form.dataset.formHideOnSubmit) {
              $form.style.display = 'none'
            }

            fn.removeBlur()
          }

          if (res.message) {
            $formMessages.classList.add('py-4')
            fn.showFormMessages($formMessages, res.message)
          }
        })
        .catch(() => {
          fn.showFormMessages(
            $formMessages,
            'Sorry, there was a problem with your submission'
          )
        })
        .finally(() => {
          fn.toggleSubmit($submitButton)
          // if (isLoginForm) {
          setTimeout(() => {
            location.reload()
          }, 2500)
          // }
        })
    }
  },

  handleSignInAjax: (e) => {
    e.preventDefault()

    const $form = e.target
    const $signInModal = document.querySelector('.sign-in-modal')
    const isValid = handleValidation($form)

    if (isValid) {
      const $formMessages = document.querySelector('.form-messages')
      const $submitButton = $form.querySelector('[type=submit]')
      const $pinInput = $form.querySelector('input[name="PIN"]')
      const mask = Imask($pinInput, {
        mask: '0 0 0 0',
      })
      fn.toggleSubmit($submitButton)
      $pinInput.value = mask.unmaskedValue

      ajax
        .url($form.action)
        .body(new FormData($form))
        .post()
        .json((res) => {
          if (res.success) {
            $form.reset()

            if (res.message) {
              $form.style.display = 'none'
            } else {
              $signInModal.style.display = 'none'
              setTimeout(() => {
                location.reload()
              }, 250)
            }

            fn.removeBlur()
          }

          if (res.message) {
            $formMessages.classList.add('py-4')
            fn.showFormMessages($formMessages, res.message)
          }
        })
        .catch((err) => {
          fn.showFormMessages(
            $formMessages,
            'Sorry, there was a problem signing in'
          )
          console.log(err)
        })
        .finally(() => {
          fn.toggleSubmit($submitButton)
          setTimeout(() => {
            location.reload()
          }, 2500)
        })
    }
  },

  setupPINMasking: () => {
    const $pinInput = document.querySelector('input[name="PIN"]')
    if ($pinInput) {
      Imask($pinInput, {
        mask: '0 0 0 0',
      })
    }
  },

  removeBlur: () => {
    const $labels = document.querySelectorAll('label')
    $labels.forEach((label) => {
      if (label.classList.contains('blur')) {
        label.classList.remove('blur')
      }
    })
  },

  toggleSubmit: ($submitButton) => {
    $submitButton.disabled = !$submitButton.disabled
    $submitButton.classList.toggle('button-loading')
  },

  showFormMessages: ($holder, message) => {
    $holder.innerHTML = message
    $holder.style.display = 'block'
  },
}

export default {
  can: () => document.querySelectorAll('form').length,
  run: fn.init,
}
