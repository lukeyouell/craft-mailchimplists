<?php
/**
 * MailChimp Lists plugin for Craft CMS 3.x
 *
 * Create, manage and monitor your MailChimp Lists from within Craft.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\mailchimplists\variables;

use lukeyouell\mailchimplists\MailchimpLists;
use lukeyouell\mailchimplists\services\HttpService;

use Craft;

/**
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 */
class MailchimpListsVariable
{
    // Public Methods
    // =========================================================================

    public function getAccount()
    {
        return HttpService::get();
    }

    public function getLists()
    {
        return HttpService::get('lists');
    }

    public function getList($listId = null)
    {
        return HttpService::get('lists/'.$listId);
    }

    public function getListName($listId = null)
    {
        return HttpService::get('lists/'.$listId, ['fields' => 'name']);
    }

    public function getListMembers($listId = null)
    {
        return HttpService::get('lists/'.$listId.'/members');
    }

    public function getListMember($listId = null, $memberId = null)
    {
        return HttpService::get('lists/'.$listId.'/members/'.$memberId);
    }
}
