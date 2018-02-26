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
use craft\helpers\UrlHelper;

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
        return HttpService::request();
    }

    public function getLists($params = [])
    {
        $url = UrlHelper::urlWithParams('lists', $params);
        return HttpService::request('GET', $url);
    }

    public function getList($listId = null)
    {
        return HttpService::request('GET', 'lists/'.$listId);
    }

    public function getListName($listId = null)
    {
        return HttpService::request('GET', 'lists/'.$listId, ['fields' => 'name']);
    }

    public function getListMembers($listId = null, $params = [])
    {
        $url = UrlHelper::urlWithParams('lists/'.$listId.'/members', $params);
        return HttpService::request('GET', $url);
    }

    public function getListMember($listId = null, $memberId = null)
    {
        return HttpService::request('GET', 'lists/'.$listId.'/members/'.$memberId);
    }
    
    public function getListActivity($listId = null)
    {
        return HttpService::request('GET', 'lists/'.$listId.'/activity');
    }

    public function paginationUrl($url = null, $params = []) {
        return UrlHelper::urlWithParams($url, $params);
    }
}
