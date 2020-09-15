<?php

namespace App\Form\Field;

use SilverStripe\Core\Convert;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FormField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class CheckboxSetIconField extends CheckboxSetField
{
    public function Field($properties = [])
    {
        $properties = array_merge($properties, [
            'Options' => $this->getOptions()
        ]);

        return FormField::Field($properties);
    }

    public function getOptions()
    {
        $selectedValues = $this->getValueArray();
        $defaultItems = $this->getDefaultItems();
        $disabledItems = $this->getDisabledItems();

        // Generate list of options to display
        $odd = false;
        $formID = $this->ID();
        $options = new ArrayList();
        foreach ($this->getSource() as $itemValue => $opts) {
            $title = $opts[0];
            $icon = $opts[1];

            $itemID = Convert::raw2htmlid("{$formID}_{$itemValue}");
            $odd = !$odd;
            $extraClass = $odd ? 'odd' : 'even';
            $extraClass .= ' val' . preg_replace('/[^a-zA-Z0-9\-\_]/', '_', $itemValue);

            $itemChecked = in_array($itemValue, $selectedValues) || in_array($itemValue, $defaultItems);
            $itemDisabled = $this->isDisabled() || in_array($itemValue, $disabledItems);

            $options->push(new ArrayData([
                'ID' => $itemID,
                'Class' => $extraClass,
                'Name' => "{$this->name}[{$itemValue}]",
                'Value' => $itemValue,
                'Title' => $title,
                'Icon' => $icon,
                'isChecked' => $itemChecked,
                'isDisabled' => $itemDisabled,
            ]));
        }
        $this->extend('updateGetOptions', $options);
        return $options;
    }

    public function performReadonlyTransformation()
    {
        $field = $this->castedCopy(CheckboxSetIconField_Readonly::class);
        $field->setSource($this->getSource());
        $field->setReadonly(true);
        return $field;
    }
}
