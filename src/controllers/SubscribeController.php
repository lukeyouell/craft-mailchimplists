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
class SubscribeController extends Controller
{

    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = ['index'];

    public function actionIndex()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // Fetch list id from hidden input
        $listId = $request->getRequiredBodyParam('listId') ? Craft::$app->security->validateData($request->post('listId')) : null;

        // Set params
        $params = [
          'email_address' => $request->post('email_address'),
          'email_type' => $request->post('email_type', ''),
          'status' => $request->getRequiredBodyParam('status') ? Craft::$app->security->validateData($request->post('status')) : 'pending',
          'merge_fields' => $request->post('merge_fields', (object)[]),
          'interests' => $request->post('interests', (object)[]),
          'language' => $request->post('language', ''),
          'vip' => $request->post('vip') ? true : false,
          'location' => $request->post('location', (object)[]),
          'ip_signup' => Craft::$app->request->getUserIP()
        ];

        // Patch request to update settings
        $response = HttpService::request('POST', 'lists/'.$listId.'/members', $params);

        if ($response['success'] and $response['statusCode'] === 200) {
          Craft::$app->session->setFlash('response', $response);
        } elseif ($response['success'] and $response['statusCode'] !== 200) {
          Craft::$app->getSession()->setError($response['statusCode'].' '.$response['reason']);
        } else {
          Craft::$app->getSession()->setError($response['reason']);
        }

        return $request->getBodyParam('redirect') ? $this->redirectToPostedUrl() : $this->asJson($response);
    }

}
