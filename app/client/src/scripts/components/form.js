import { on } from 'delegated-events'
// import IMask from 'imask'
import { handleValidation, handleBlur } from '../common/validation'

const fn = {
  init: () => {
    // fn.handleMasking
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
  },

  // handleMasking: () => {
  //   const $form = document.querySelector('.sign-in-form')
  //   const $field = $form.querySelector('input[type="number"]')
  //   let mask = IMask($field, {
  //     mask: '0000',
  //   })
  //   return mask
  // },

  handleAjax: (e) => {
    e.preventDefault()

    const $form = e.target
    const isValid = handleValidation($form)
    const isLoginForm = $form.classList.contains('sign-in-form')

    if (isValid) {
      const $formMessages = $form.parentElement.querySelector('.form-messages')
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
          if (isLoginForm) {
            setTimeout(() => {
              location.reload()
            }, 3000)
          }
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
    $submitButton.classList.toggle('btn-loading')
  },

  showFormMessages: ($holder, message, hide = false) => {
    $holder.innerHTML = message
    $holder.style.display = 'block'

    if (hide) {
      setTimeout(() => {
        $holder.style.display = 'none'
      }, 5000)
    }
  },
}

export default {
  can: () => document.querySelectorAll('form').length,
  run: fn.init,
}
