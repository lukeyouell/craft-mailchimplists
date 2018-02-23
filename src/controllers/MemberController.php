<?php
/**
 * MailChimp Lists plugin for Craft CMS 3.x
 *
 * Create, manage and monitor your MailChimp Lists from within Craft.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\mailchimplists\controllers;

use lukeyouell\mailchimplists\MailchimpLists;

use Craft;
use craft\web\Controller;
use lukeyouell\mailchimplists\services\HttpService;

/**
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 */
class MemberController extends Controller
{

    // Protected Properties
    // =========================================================================

    public function actionUpdateStatus()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // Fetch list id from hidden input
        $listId = $request->getRequiredBodyParam('listId');
        $memberId = $request->getRequiredBodyParam('memberId');
        $memberStatus = $request->getRequiredBodyParam('status');

        // Set params
        $params = [
          'status' => $memberStatus,
        ];

        // Patch request to update member status
        $response = HttpService::request('PATCH', 'lists/'.$listId.'/members/'.$memberId, $params);

        if ($response['success'] and $response['statusCode'] === 200) {
          Craft::$app->getSession()->setNotice('Member status updated.');
          return $this->redirectToPostedUrl();
        } elseif ($response['success'] and $response['statusCode'] !== 200) {
          Craft::$app->session->setFlash('errorBody', $response['body']);
          Craft::$app->getSession()->setError($response['statusCode'].' '.$response['reason']);
        } else {
          Craft::$app->getSession()->setError($response['reason']);
        }

        return $this->redirectToPostedUrl();
    }

}
