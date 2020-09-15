<?php

namespace App\Form\Field;

use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\ListboxField;
use SilverStripe\ORM\Map;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\FormField;

class DependentListboxField extends ListboxField
{
    private static $allowed_actions = [
        'load',
    ];

    protected $depends;

    protected $unselected;

    protected $sourceCallback;

    public function __construct($name, $title = null, \Closure $source = null, $value = '', $form = null, $emptyString = null)
    {
        parent::__construct($name, $title, [], $value, $form, $emptyString);

        // we are unable to store Closure as a normal source
        $this->sourceCallback = $source;
        $this
            ->addExtraClass('dependent-dropdown')
            ->addExtraClass('dropdown');
    }

    public function load($request)
    {
        $response = new HTTPResponse();
        $response->addHeader('Content-Type', 'application/json');

        $items = call_user_func($this->sourceCallback, $request->getVar('val'));
        $results = [];
        if ($items) {
            foreach ($items as $k => $v) {
                $results[] = ['k' => $k, 'v' => $v];
            }
        }

        $response->setBody(Convert::array2json($results));

        return $response;
    }

    public function getDepends()
    {
        return $this->depends;
    }

    public function setDepends(FormField $field)
    {
        $this->depends = $field;

        return $this;
    }

    public function getUnselectedString()
    {
        return $this->unselected;
    }

    public function setUnselectedString($string)
    {
        $this->unselected = $string;

        return $this;
    }

    public function getSource()
    {
        $val = $this->depends->Value();

        if (!$val) {
            $source = [];
        } else {
            $source = call_user_func($this->sourceCallback, $val);
            if ($source instanceof Map) {
                $source = $source->toArray();
            }
        }

        return $source;
    }

    public function setSource($source)
    {
        $this->sourceCallback = $source;
        return $this;
    }

    public function Field($properties = [])
    {
        Requirements::javascript('app/client/cms/dependentlistboxfield.js');

        $this->setAttribute('data-link', $this->Link('load'));
        $this->setAttribute('data-depends', $this->getDepends()->getName());
        $this->setAttribute('data-unselected', $this->getUnselectedString());

        return parent::Field($properties);
    }
}
