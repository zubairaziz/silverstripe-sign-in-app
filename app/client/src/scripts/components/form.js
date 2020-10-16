import { on } from 'delegated-events'
import { handleValidation, handleBlur } from '../common/validation'
import IMask from 'imask'

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
    fn.setupSignInForm()
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
      const $inputs = $form.querySelectorAll('input')

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
              $form.reset()
              $inputs.forEach(($input) => {
                $input.value = ''
              })
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
          $form.reset()
          $inputs.forEach(($input) => {
            $input.value = ''
          })
          setTimeout(() => {
            location.reload()
          }, 2500)
        })
    }
  },

  setupSignInForm: () => {
    const $form = document.querySelector('.sign-in-form')
    if ($form) {
      const $pinInput1 = $form.querySelector('input[name="PIN1"]')
      const $pinInput2 = $form.querySelector('input[name="PIN2"]')
      const $pinInput3 = $form.querySelector('input[name="PIN3"]')
      const $pinInput4 = $form.querySelector('input[name="PIN4"]')
      const $submitButton = $form.querySelector('[type=submit')
      const maskOptions = {
        mask: Number,
        signed: false, // disallow negative
        thousandsSeparator: '', // any single char
        min: 0,
        max: 9,
      }
      const mask1 = IMask($pinInput1, maskOptions)
      const mask2 = IMask($pinInput2, maskOptions)
      const mask3 = IMask($pinInput3, maskOptions)
      const mask4 = IMask($pinInput4, maskOptions)
      $pinInput1.addEventListener('keypress', () => {
        mask1.updateValue()
        $pinInput2.focus()
      })
      $pinInput2.addEventListener('keypress', () => {
        mask2.updateValue()
        $pinInput3.focus()
      })
      $pinInput3.addEventListener('keypress', () => {
        mask3.updateValue()
        $pinInput4.focus()
      })
      $pinInput4.addEventListener('keyup', () => {
        mask4.updateValue()
        if ($pinInput4.value.length > 0) {
          $submitButton.click()
        }
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
