<?php

namespace App\Extension;

use SilverStripe\Core\Extension;

class FormField extends Extension
{
    /**
     * Displays a helper message for using variables
     */
    public function showVariableHelper()
    {
        $currentTitle = trim($this->owner->RightTitle());
        $helper = 'Available variables: [FirstName], [LastName], [FullName]';

        // If there is already a RightTitle, append our message to the end
        if ($currentTitle) {
            if (substr($currentTitle, -1) != '.') {
                $helper = "{$currentTitle}. {$helper}";
            } else {
                $helper = "{$currentTitle} {$helper}";
            }
        }

        $this->owner->setRightTitle($helper);

        return $this->owner;
    }

    /**
     * Displays a helper message for using special emphasis characters
     */
    public function showEmphasisHelper()
    {
        $currentTitle = trim($this->owner->RightTitle());
        $helper = 'Surround text in [ and ] brackets for emphasis styling.';

        // If there is already a RightTitle, append our message to the end
        if ($currentTitle) {
            if (substr($currentTitle, -1) != '.') {
                $helper = "{$currentTitle}. {$helper}";
            } else {
                $helper = "{$currentTitle} {$helper}";
            }
        }

        $this->owner->setRightTitle($helper);

        return $this->owner;
    }

    /**
     * Displays a helper message for suggested size
     */
    public function showSuggestedSizeHelper(string $sizeStr)
    {
        $currentTitle = trim($this->owner->RightTitle());
        $helper = "Suggested size: {$sizeStr}.";

        // If there is already a RightTitle, append our message to the end
        if ($currentTitle) {
            if (substr($currentTitle, -1) != '.') {
                $helper = "{$currentTitle}. {$helper}";
            } else {
                $helper = "{$currentTitle} {$helper}";
            }
        }

        $this->owner->setRightTitle($helper);

        return $this->owner;
    }

    /**
     * Displays a helper message for YouTube video url
     */
    public function showYouTubeHelper(bool $hidePlaceholder = false)
    {
        $currentTitle = trim($this->owner->RightTitle());
        $helper = 'Enter a YouTube video URL (ex: https://www.youtube.com/watch?v=xxxxx).';

        // If there is already a RightTitle, append our message to the end
        if ($currentTitle) {
            if (substr($currentTitle, -1) != '.') {
                $helper = "{$currentTitle}. {$helper}";
            } else {
                $helper = "{$currentTitle} {$helper}";
            }
        }

        if (!$hidePlaceholder) {
            $this->owner->setAttribute('placeholder', 'YouTube Video URL');
        }

        $this->owner->setRightTitle($helper);

        return $this->owner;
    }

    public function enableFlyField()
    {
        return $this->owner->addExtraClass('field-fly');
    }
}
