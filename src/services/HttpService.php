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
class HttpService extends Component
{
    // Public Methods
    // =========================================================================

    public static function request($type = 'GET', $uri = '', $params = null)
    {
        $settings = MailchimpLists::$plugin->getSettings();

        // Get datacenter from end of api key
        $explode = explode('-', $settings->apiKey);
        $dc = end($explode);

        $client = new \GuzzleHttp\Client([
          'base_uri' => 'https://'.$dc.'.api.mailchimp.com/3.0/',
          'http_errors' => false,
          'timeout' => 10,
          'auth' => ['plugin', $settings->apiKey]
        ]);

        try {

          $response = $client->request($type, $uri, [
            'json' => $params
          ]);

          return [
            'success' => true,
            'statusCode' => $response->getStatuscode(),
            'reason' => $response->getReasonPhrase(),
            'body' => json_decode($response->getBody(), true)
          ];

        } catch (\Exception $e) {

          return [
            'success' => false,
            'reason' => $e->getMessage()
          ];

        }
    }
}
