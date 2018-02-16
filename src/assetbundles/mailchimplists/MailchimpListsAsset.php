<?php
/**
 * MailChimp Lists plugin for Craft CMS 3.x
 *
 * Create, manage and monitor your MailChimp Lists from within Craft.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\mailchimplists\assetbundles\MailchimpLists;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
/**
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 */

class MailchimpListsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@lukeyouell/mailchimplists/assetbundles/mailchimplists/dist";
        $this->depends = [
            CpAsset::class,
        ];
        $this->css = [
            'css/foundation.css',
        ];
        parent::init();
    }
}
