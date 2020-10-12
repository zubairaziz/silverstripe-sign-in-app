<?php

use App\Model\BackgroundSettings;
use App\Model\Employee;
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

    public function getAnimationDuration()
    {
        $backgroundSettings = BackgroundSettings::current_settings();
        if ($num = $backgroundSettings->BackgroundImages()->count()) {
            return $num * 6;
        }
        return null;
    }

    public function getSession()
    {
        $session = $this->getRequest()->getSession();
        Debug::show($session);
        return $session;
    }

    public function getDebug()
    {
        $this->getSession();
        return 'Debug';
    }
}
