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

/**
 * @author    Luke Youell
 * @package   MailchimpLists
 * @since     0.1.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the DefaultController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the DefaultController actionDoSomething() method';

        return $result;
    }
}
