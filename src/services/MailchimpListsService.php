<?php
/**
 * MailChimp Lists plugin for Craft CMS 3.x
 *
 * Create, manage and monitor your MailChimp Lists from within Craft.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\mailchimplists\services;

use lukeyouell\mailchimplists\MailchimpLists;

use Craft;
use craft\base\Component;

/**
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 */
class MailchimpListsService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (MailchimpLists::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}
