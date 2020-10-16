<?php

use App\Model\BackgroundSettings;
use App\Model\Employee;
use App\Util\Util;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Dev\Debug;

class PageController extends ContentController
{
    private static $allowed_actions = [
        'SignInForm'
    ];

    protected function init()
    {
        parent::init();
    }

    public function getIsLoggedIn()
    {
        return $this->getRequest()->getSession()->get('LoggedIn');
    }

    public function getLoggedInEmployee()
    {
        return $this->getRequest()->getSession()->get('Employee');
    }

    public function getAllEmployees()
    {
        if ($this->getIsLoggedIn()) {
            return Employee::get()
                ->filter(['ActiveEmployee' => true])
                ->exclude(['ID' => $this->getLoggedInEmployee()->ID]);
        }
        return Employee::get()->filter(['ActiveEmployee' => true]);
    }

    public function getBirthdayEmployees()
    {
        $date = Util::getTodaysDate();
        $d = date_parse_from_format("Y-m-d", $date);
        $month = $d["month"];
        $day = $d["day"];

        return Employee::get()
            ->filter([
                'ActiveEmployee' => true,
                'BirthdayMonth' => $month,
            ])
            ->exclude([
                'BirthdayDate:LessThan' => $day
            ]);
    }

    public function getAnniversaryEmployees()
    {
        $date = Util::getTodaysDate();
        $d = date_parse_from_format("Y-m-d", $date);
        $month = $d["month"];
        $day = $d["day"];

        return Employee::get()
            ->filter([
                'ActiveEmployee' => true,
                'AnniversaryMonth' => $month,
            ])
            ->exclude([
                'AnniversaryDate:LessThan' => $day
            ]);
    }

    public function getBackgroundColor()
    {
        $backgroundSettings = BackgroundSettings::current_settings();
        if ($backgroundSettings->UseBackgroundColor) {
            return $backgroundSettings->BackgroundColor;
        }
        return null;
    }

    public function getBackgroundImages()
    {
        $backgroundSettings = BackgroundSettings::current_settings();
        if ($backgroundSettings->BackgroundImages()->count()) {
            return $backgroundSettings->BackgroundImages();
        }
        return null;
    }

    public function getBackgroundVideo()
    {
        $backgroundSettings = BackgroundSettings::current_settings();
        if ($backgroundSettings->BackgroundVideo()->exists()) {
            return $backgroundSettings->BackgroundVideo();
        }
        return null;
    }

    public function getSession()
    {
        $session = $this->getRequest()->getSession();
        Debug::show($session);
        return $session;
    }
}
