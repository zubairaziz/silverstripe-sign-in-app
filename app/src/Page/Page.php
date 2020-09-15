<?php

use App\Form\FormController;
use App\Model\SortableImage;
use App\Page\HomePage;
use App\Util\Util;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Model\VirtualPage;
use SilverStripe\Dev\Debug;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class Page extends SiteTree
{
    private static $db = [
        'HidePageHeader' => 'Boolean',
        'HeaderTitle' => 'Varchar',
        'HeaderSubhead' => 'Varchar',
        'HeaderLeadIn' => 'HTMLText',
        'HeaderStyle' => 'Enum("Default,Hero","Default")',
    ];

    private static $has_one = [
        'HeaderBackground' => Image::class
    ];

    private static $owns = [
        'HeaderBackground'
    ];

    private static $has_many = [
        'AdditionalImages' => SortableImage::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $titleDescription = $this->exists() ?
            sprintf("Leave blank to use '%s'", $this->Title) :
            null;

        $headerBlacklist = [
            HomePage::class,
            VirtualPage::class,
            ErrorPage::class,
            RedirectorPage::class
        ];

        if (!in_array($this->ClassName, $headerBlacklist)) {
            $fields->addFieldsToTab('Root.Header', [
                FieldGroup::create(
                    'Hide Header',
                    CheckboxField::create('HidePageHeader'),
                ),
                DropdownField::create(
                    'HeaderStyle',
                    'Style',
                    [
                        'Default' => 'Default',
                        'Hero' => 'Large Hero'
                    ]
                ),
                TextField::create('HeaderTitle', 'Title')
                    ->showEmphasisHelper()
                    ->setDescription($titleDescription),
                TextField::create('HeaderSubhead', 'Subhead'),
                HTMLEditorField::create('HeaderLeadIn', 'Lead In'),
                Wrapper::create(
                    UploadField::create('HeaderBackground', 'Background Photo')
                        ->setAllowedFileCategories('image')
                        ->setFolderName('HeaderBackground'),
                    GridField::create(
                        'AdditionalImages',
                        'Additional Images',
                        $this->AdditionalImages(),
                        Util::getRecordEditorConfig()
                    ),
                )->displayIf('HeaderStyle')->isEqualTo('Hero')->end(),
                $this->buildCTAGrid('PageHeader')
            ]);
        }

        return $fields;
    }

    public function getPageBreadcrumbs()
    {
        if ($this->Parent()->exists()) {
            return Util::getFakeBreadcrumbs($this->getAncestors()->toArray(), $this->MenuTitle);
        }
    }

    public function getDropdownMenuChildren()
    {
        if ($this->ParentID) {
            $ancestors = $this->getAncestors()->column('ClassName');
        }

        return $this->Children();
    }

    public function getDropdownMenuLabel()
    {
        return 'Make A Selection';
    }

    public function getHasPageHeaderTopActions()
    {
        return false;
    }

    public function getHeaderSlides()
    {
        $urls = [];
        if ($this->AdditionalImages()->count()) {
            if ($this->HeaderBackground()) {
                $urls[] = $this->HeaderBackground()->URL;
            }
            foreach ($this->AdditionalImages() as $image) {
                $urls[] = $image->Image()->URL;
            }
        }
        $slides = ArrayList::create();
        foreach ($urls as $url) {
            $slides->push(['URL' => $url]);
        }
        // Debug::show($slides);
        return $slides;
    }

    public function getAbstract()
    {
        if ($this->MetaDescription) {
            return DBField::create_field('HTMLText', "<p>{$this->MetaDescription}</p>");
        }
    }

    public static function ContactForm()
    {
        $formController = FormController::create();

        return $formController->ContactForm();
    }

    public function PageCheck()
    {
        return $this->ID;
    }
}
