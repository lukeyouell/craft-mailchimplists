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
class CreateController extends Controller
{

    // Protected Properties
    // =========================================================================

    public function actionIndex()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // Set params
        $params = [
          'name' => $request->post('name'),
          'contact' => $request->post('contact'),
          'permission_reminder' => $request->post('permission_reminder'),
          'campaign_defaults' => $request->post('campaign_defaults'),
          'email_type_option' => $request->post('email_type_option') ? true : false
        ];

        // Patch request to update settings
        $response = HttpService::request('POST', 'lists', $params);

        if ($response['success'] and $response['statusCode'] === 200) {
          Craft::$app->getSession()->setNotice('List created.');
          return $this->redirectToPostedUrl();
        } elseif ($response['success'] and $response['statusCode'] !== 200) {
          Craft::$app->session->setFlash('errorBody', $response['body']);
          Craft::$app->getSession()->setError($response['statusCode'].' '.$response['reason']);
        } else {
          Craft::$app->getSession()->setError($response['reason']);
        }

        return $this->redirect('mailchimp-lists/create');
    }

}
