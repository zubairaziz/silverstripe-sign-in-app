import { on } from 'delegated-events'
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
    on('submit', '[data-form-ajax]', fn.handleSingleActionAjax)
    on('submit', '.sign-in-form', fn.handleSignInAjax)
    fn.setupPINMasking()
    fn.setupSpecialFields()
  },

  handleSingleActionAjax: (e) => {
    e.preventDefault()

    const $form = e.target
    const isValid = handleValidation($form)

    if (isValid) {
      const $employeeCard = document.querySelector('.employee-card')
      const $formMessages = document.querySelector('.form-messages')
      const $submitButton = $form.querySelector('[type=submit]')
      fn.toggleSubmit($submitButton)

      ajax
        .url($form.action)
        .body(new FormData($form))
        .post()
        .json((res) => {
          if (res.success) {
            if ($form.dataset.formHideOnSubmit) {
              $employeeCard.style.display = 'none'
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
          setTimeout(() => {
            location.reload()
          }, 2500)
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
        mask: '0000',
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
        mask: '0000',
      })
    }
  },

  setupSpecialFields: () => {
    document.querySelectorAll('form').forEach(($form) => {
      // Setup file inputs
      $form.querySelectorAll('input[type=file]').forEach(($input) => {
        const $placeholder = document.createElement('div')
        $placeholder.classList.add('file-input-placeholder')

        if ($input.value) {
          $placeholder.textContent = $input.files[0].name
        } else {
          $placeholder.textContent = $input.dataset.placeholder
        }

        $input.parentNode.insertBefore($placeholder, $input)

        $placeholder.addEventListener('click', () => $input.click())

        $input.addEventListener('change', (e) => {
          $placeholder.textContent = e.target.files[0].name
          $placeholder.classList.add('filled')
        })
      })
    })
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
