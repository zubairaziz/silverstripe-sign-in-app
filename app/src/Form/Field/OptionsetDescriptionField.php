<?php

namespace App\Form\Field;

use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class OptionsetDescriptionField extends OptionsetField
{
    protected function getFieldOption($value, $title, $description)
    {
        return new ArrayData([
            'ID' => $this->getOptionID($value),
            'Class' => $this->getOptionClass($value, false),
            'Name' => $this->getOptionName(),
            'Value' => $value,
            'Title' => $title,
            'Description' => $description,
            'isChecked' => $this->isSelectedValue($value, $this->Value()),
            'isDisabled' => $this->isDisabledValue($value)
        ]);
    }

    public function Field($properties = [])
    {
        $options = [];
        $odd = false;

        // Add all options striped
        foreach ($this->getSourceEmpty() as $value => $opts) {
            $title = $opts[0];
            $description = $opts[1];

            $options[] = $this->getFieldOption($value, $title, $description);
        }

        $properties = array_merge($properties, [
            'Options' => new ArrayList($options)
        ]);

        return FormField::Field($properties);
    }

    public function performReadonlyTransformation()
    {
        $field = $this->castedCopy(OptionsetDescriptionField_Readonly::class);
        $field->setSource($this->getSource());
        $field->setReadonly(true);
        return $field;
    }
}
