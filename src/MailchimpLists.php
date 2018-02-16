<?php
/**
 * MailChimp Lists plugin for Craft CMS 3.x
 *
 * Create, manage and monitor your MailChimp Lists from within Craft.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\mailchimplists;

use lukeyouell\mailchimplists\services\MailchimpListsService as MailchimpListsServiceService;
use lukeyouell\mailchimplists\variables\MailchimpListsVariable;
use lukeyouell\mailchimplists\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;

use yii\base\Event;

/**
 * Class MailchimpLists
 *
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 *
 * @property  MailchimpListsServiceService $mailchimpListsService
 */
class MailchimpLists extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var MailchimpLists
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.1.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['mailchimp-lists/list/<listId>'] = ['template' => 'mailchimp-lists/list/overview'];
                $event->rules['mailchimp-lists/list/<listId>/contacts'] = ['template' => 'mailchimp-lists/list/contacts'];
                $event->rules['mailchimp-lists/list/<listId>/contacts/<memberId>'] = ['template' => 'mailchimp-lists/list/member'];
                $event->rules['mailchimp-lists/list/<listId>/settings'] = ['template' => 'mailchimp-lists/list/settings'];
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('mailchimpLists', MailchimpListsVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                  Craft::$app->getResponse()->redirect(UrlHelper::cpUrl('settings/plugins/mailchimp-lists'))->send();
                }
            }
        );

        Craft::info(
            Craft::t(
                'mailchimp-lists',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        // Get and pre-validate the settings
        $settings = $this->getSettings();
        $settings->validate();

        // Get the settings that are being defined by the config file
        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return Craft::$app->view->renderTemplate(
            'mailchimp-lists/settings',
            [
                'settings' => $settings,
                'overrides' => array_keys($overrides)
            ]
        );
    }
}
