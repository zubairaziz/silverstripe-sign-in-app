<?php

namespace App\View;

use App\Form\FormController;
use App\Util\AssetUtil;
use App\Util\TextUtil;
use App\Util\Util;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\TemplateGlobalProvider;

class SiteTemplateGlobalProvider implements TemplateGlobalProvider
{
    public static function get_template_global_variables()
    {
        return [
            'PhoneLink' => 'PhoneLink',
            'PhoneLinker' => [
                'method' => 'PhoneLinker',
                'casting' => 'HTMLFragment'
            ],
            'GetPageByType' => 'GetPageByType',
            'SignInForm' => 'SignInForm',
            'SignOutForm' => 'SignOutForm',
            'LunchOutForm' => 'LunchOutForm',
            'AppointmentOutForm' => 'AppointmentOutForm',
            'LunchInForm' => 'LunchInForm',
            'AppointmentInForm' => 'AppointmentInForm',
            'SiteCSS' => 'SiteCSS',
            'SiteLiveCSS' => 'SiteLiveCSS',
            'SiteJS' => 'SiteJS',
            'Asset' => 'Asset',
            'AssetInline' => [
                'method' => 'AssetInline',
                'casting' => 'HTMLFragment'
            ],
            'AssetIcon' => [
                'method' => 'AssetIcon',
                'casting' => 'HTMLFragment'
            ],
            'AssetIconInline' => [
                'method' => 'AssetIconInline',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasize' => [
                'method' => 'TextEmphasize',
                'casting' => 'HTMLFragment'
            ],
            'TextDeemphasize' => [
                'method' => 'TextDeemphasize',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasizeFromStart' => [
                'method' => 'TextEmphasizeFromStart',
                'casting' => 'HTMLFragment'
            ],
            'TextEmphasizeFromEnd' => [
                'method' => 'TextEmphasizeFromEnd',
                'casting' => 'HTMLFragment'
            ],
            'IsLive' => 'IsLive'
        ];
    }

    public static function SignInForm()
    {
        $controller = FormController::create();

        return $controller->SignInForm();
    }

    public static function SignOutForm($isNavigation = false)
    {
        $controller = FormController::create();

        return $controller->SignOutForm($isNavigation);
    }

    public static function LunchOutForm()
    {
        $controller = FormController::create();

        return $controller->LunchOutForm();
    }

    public static function AppointmentOutForm()
    {
        $controller = FormController::create();

        return $controller->AppointmentOutForm();
    }

    public static function LunchInForm()
    {
        $controller = FormController::create();

        return $controller->LunchInForm();
    }

    public static function AppointmentInForm()
    {
        $controller = FormController::create();

        return $controller->AppointmentInForm();
    }

    public static function PhoneLink($number)
    {
        return sprintf('+1%s', Util::cleanPhoneNumber($number));
    }

    public static function PhoneLinker($number, $classes = '', $text = null)
    {
        $text = is_null($text) ? $number : $text;
        $cleanedNumber = sprintf('+1%s', Util::cleanPhoneNumber($number));
        $phoneLink = sprintf('<a href="tel:%s" class="phone-link %s">%s</a>', $cleanedNumber, $classes, $text);

        return $phoneLink;
    }

    public static function GetPageByType($pageType)
    {
        return DataObject::get_one('App\\Page\\' . $pageType);
    }

    public static function IsLive()
    {
        return Director::isLive();
    }

    public static function SiteCSS()
    {
        AssetUtil::requireSiteCSS();
    }

    public static function SiteLiveCSS()
    {
        $css = '';
        $vendor = Director::baseFolder() . '/public/_resources/app/client/dist/vendor.css';
        $main = Director::baseFolder() . '/public/_resources/app/client/dist/app.css';
        $vendorCss = '';
        $mainCss = '';
        if (file_exists($vendor)) {
            $vendorCss = file_get_contents($vendor);
        }
        if (file_exists($main)) {
            $mainCss = file_get_contents($main);
        }
        $css = $vendorCss . $mainCss;
        return $css;
    }

    public static function SiteJS()
    {
        AssetUtil::requireSiteJS();
    }

    public static function Asset($path)
    {
        return AssetUtil::getAsset($path);
    }

    public static function AssetInline($path)
    {
        return AssetUtil::getAssetInline($path);
    }

    public static function AssetIcon($name)
    {
        return AssetUtil::getAssetIcon($name);
    }

    public static function AssetIconInline($name)
    {
        return AssetUtil::getAssetIconInline($name);
    }

    public static function TextEmphasize($text)
    {
        return TextUtil::emphasize($text);
    }

    public static function TextDeemphasize($text)
    {
        return TextUtil::deemphasize($text);
    }

    public static function TextEmphasizeFromStart($text, $numWords = 1)
    {
        return TextUtil::emphasizeFromStart($text, $numWords);
    }

    public static function TextEmphasizeFromEnd($text, $numWords = 1)
    {
        return TextUtil::emphasizeFromEnd($text, $numWords);
    }
}
