<?php

namespace App\Form\Field;

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;

class IconField extends DropdownField
{
    /**
     * List of icons made availabe to select in the dropdown
     * Icon names should be just the name without .svg extension
     * This list will be used to find icons located in [theme-dir]/src/icons/[$name.svg]
     */
    protected $list = [
        'america',
        'america-outlined',
        'book-open',
        'book-stack',
        'book-stack-alt',
        'briefcase-checkmark',
        'chart',
        'check',
        'checkmark',
        'email',
        'globe-alt',
        'globe-arrows',
        'hand-outreach',
        'hands-together',
        'handshake-circle',
        'health-cross',
        'heart',
        'house',
        'immigration',
        'interpretation',
        'megaphone',
        'people-connected',
        'people-group',
        'people-group-alt',
        'people-talking',
        'person-briefcase',
        'person-desk',
        'person-folder',
        'person-magnify',
        'stocks',
        'tax-bill',
        'text-bubbles-circle',
        'traffic400',
        'translation-bubbles',
    ];

    protected $extraClasses = ['dropdown'];

    public function __construct($name, $title = null, $source = [], $value = '', $form = null)
    {
        if (!empty($source)) {
            $this->setList($source);
        }

        $this->setEmptyString('Select an Icon');

        parent::__construct($name, ($title === null) ? $name : $title, $source, $value, $form);

        $helper = DBField::create_field(
            'HTMLText',
            '<a href="/dev/tasks/App-Task-IconFieldIcons" target="_blank">View available icons</a>'
        );

        $this->setRightTitle($helper);
    }

    public function setList($list = [])
    {
        if (!is_array($list)) {
            trigger_error("The \$source passed isn't an array.", E_USER_ERROR);
        }

        if (empty($list)) {
            $list = $this->list;
        }

        $this->list = array_combine($list, $list);

        return $this;
    }

    public function getList()
    {
        $this->list = array_combine($this->list, $this->list);

        ksort($this->list);

        return $this->list;
    }

    public function setSource($source = [])
    {
        $this->setList($source);
        return $this;
    }

    public function getSource()
    {
        return $this->getList();
    }
}
