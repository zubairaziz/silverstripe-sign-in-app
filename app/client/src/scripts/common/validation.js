import * as validator from 'validate.js'
import scrollTo from '../common/scrollTo'

const findFieldWrapper = ($el) => {
  if ($el) {
    if ($el.closest('.form-field-wrapper')) {
      return $el.closest('.form-field-wrapper')
    }

    if ($el.closest('.field')) {
      return $el.closest('.field')
    }
  }
}

export const handleBlur = (e) => {
  const $fieldWrapper = findFieldWrapper(e.target)

  if ($fieldWrapper) {
    $fieldWrapper.classList.remove('has-error')
    $fieldWrapper.classList.add('blur')

    const $existingErrorMessage = $fieldWrapper.querySelector(
      '.form-field-message'
    )

    if ($existingErrorMessage) {
      $existingErrorMessage.remove()
    }
  }

  if (e.target.classList.contains('has-error')) {
    e.target.classList.remove('has-error')
  }
}

export const buildRules = ($form) => {
  const rules = {}

  $form.querySelectorAll('[required]').forEach(($field) => {
    // Ignore hidden fields
    if (
      (findFieldWrapper($field) &&
        findFieldWrapper($field).offsetHeight === 0) ||
      $field.getAttribute('readonly')
    ) {
      return
    }

    const fieldName = $field.dataset.name ? $field.dataset.name : $field.name

    rules[fieldName] = {
      presence: {
        message: '^Required',
      },
    }

    if ($field.type === 'email') {
      rules[$field.name].email = true
    }
  })

  $form.querySelectorAll('[pattern]').forEach(($field) => {
    // Ignore hidden fields
    if (findFieldWrapper($field).offsetHeight === 0 || $field.readonly) {
      return
    }

    rules[$field.name] = {
      format: {
        pattern: $field.getAttribute('pattern'),
        message: '^Required',
      },
    }
  })

  $form.querySelectorAll('[aria-required]').forEach(($field) => {
    // Ignore hidden fields
    if (
      (findFieldWrapper($field) &&
        findFieldWrapper($field).offsetHeight === 0) ||
      $field.readonly
    ) {
      return
    }

    if ($field.classList.contains('optionset')) {
      const $radio = $field.querySelector('input[type=radio]')
      const $checkbox = $field.querySelector('input[type=checkbox]')

      if ($radio) {
        rules[$radio.name] = {
          presence: {
            message: '^Required',
          },
        }
      }

      if ($checkbox) {
        rules[$checkbox.name] = {
          checkboxGroup: $checkbox.closest('.optionset'),
        }
      }
    }
  })

  return rules
}

export const handleValidation = ($form) => {
  const rules = buildRules($form)
  const result = validate($form, rules)

  if (result !== undefined) {
    for (const [name, messages] of Object.entries(result)) {
      const $field = $form.querySelector(`[name="${name}"]`)
      const $fieldWrapper = findFieldWrapper($field)

      // Place error message
      if ($fieldWrapper) {
        const $existingErrorMessage = $fieldWrapper.querySelector(
          '.form-field-message'
        )

        if ($existingErrorMessage) {
          $existingErrorMessage.remove()
        }

        const message = `
                <div class="form-field-message bad text-xs text-red-700 right-0">
                    ${messages[0]}
                </div>
                `
        $fieldWrapper.insertAdjacentHTML('beforeend', message)
        $fieldWrapper.classList.add('has-error')
      }

      $field.classList.add('has-error')
    }

    const shouldScroll = $form.dataset.formScroll !== undefined

    const $firstError = $form.querySelector('.field.has-error')

    if (shouldScroll && $firstError) {
      scrollTo(
        $firstError,
        100,
        () =>
          $firstError.querySelector('input') &&
          $firstError.querySelector('input').focus()
      )
    }

    return false
  }

  return true
}

export const validate = validator
