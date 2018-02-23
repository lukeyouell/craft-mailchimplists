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
class DeleteController extends Controller
{

    // Protected Properties
    // =========================================================================

    public function actionList()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // Fetch list id from hidden input
        $listId = $request->getRequiredBodyParam('listId');

        // Patch request to update settings
        $response = HttpService::request('DELETE', 'lists/'.$listId);

        if ($response['success'] and $response['statusCode'] === 204) {
          Craft::$app->getSession()->setNotice('List deleted.');
          return $this->redirectToPostedUrl();
        } elseif ($response['success'] and $response['statusCode'] !== 204) {
          Craft::$app->session->setFlash('errorBody', $response['body']);
          Craft::$app->getSession()->setError($response['statusCode'].' '.$response['reason']);
        } else {
          Craft::$app->getSession()->setError($response['reason']);
        }

        return $this->redirectToPostedUrl();
    }

}
