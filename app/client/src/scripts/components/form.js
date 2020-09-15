import { on } from 'delegated-events'
import {
  handleValidation,
  handleBlur,
  handleBlurFlyField,
  handleFlyField,
  handleRemoveFlyField,
} from '../common/validation'

const fn = {
  init: () => {
    on('keyup', 'input', handleFlyField, { capture: true })
    on('focus', 'input', handleFlyField, { capture: true })
    on('blur', 'input', handleBlurFlyField, { capture: true })
    on('change', 'input', handleFlyField, { capture: true })
    on('change', 'input', handleRemoveFlyField, { capture: true })
    on('blur', '.has-error', handleBlur, { capture: true })
    on('change', '.has-error', handleBlur, { capture: true })
    on('change', '.has-error blur', handleBlur, { capture: true })
    on('submit', '[data-form-ajax]', fn.handleAjax)
  },

  handleAjax: (e) => {
    e.preventDefault()

    const $form = e.target
    const isValid = handleValidation($form)

    if (isValid) {
      const $formMessages = $form.querySelector('.form-messages')
      const $submitButton = $form.querySelector('[type=submit]')
      fn.toggleSubmit($submitButton)

      ajax
        .url($form.action)
        .body(new FormData($form))
        .post()
        .json((res) => {
          if (res.success) {
            $form.reset()

            if ($form.dataset.hideOnSubmit) {
              $form.style.display = 'none'
            }

            fn.removeBlur()
          }

          if (res.message) {
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

  showFormMessages: ($holder, message) => {
    $holder.innerHTML = message
    $holder.style.display = 'block'

    setTimeout(() => {
      $holder.style.display = 'none'
    }, 6000)
  },
}

export default {
  can: () => document.querySelectorAll('form').length,
  run: fn.init,
}
