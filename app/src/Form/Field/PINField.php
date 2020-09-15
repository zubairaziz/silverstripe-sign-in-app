<?php

namespace App\Form\Field;

use SilverStripe\Forms\TextField;

/**
 * Text input field with validation for correct email format according to RFC 2822.
 */
class PINField extends TextField
{
    protected $inputType = 'number';
    /**
     * {@inheritdoc}
     */
    public function Type()
    {
        return 'pin text';
    }

    /**
     *
     * @param Validator $validator
     *
     * @return string
     */
    public function validate($validator)
    {
        $this->value = trim($this->value);

        if (strlen($this->value) !== 4) {
            $validator->validationError(
                $this->name,
                'Please enter a PIN of exactly 4 digits',
                'validation'
            );

            return false;
        }

        if (!is_numeric($this->value)) {
            $validator->validationError(
                $this->name,
                'PIN field can only accept numeric values as valid input',
                'validation'
            );

            return false;
        }

        return true;
    }
}
