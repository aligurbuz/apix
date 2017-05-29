<?php namespace src\store\packages\auto\facebook;
use Response;
use Apix\Utils;
use Apix\StaticPathModel;

/*
 * This file is facebook package for every service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class facebook
{

    private $accessToken;
    private $appId;
    private $appSecret;
    private $appVersion;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){

        //app socialize facebook info
        $appFacebook=staticPathModel::getAppSocializeFacebook();

        //app socialize values
        $this->accessToken=$appFacebook['accessToken'];
        $this->appId=$appFacebook['appId'];
        $this->appSecret=$appFacebook['appSecret'];
        $this->appVersion=$appFacebook['appVersion'];
    }

    /**
     * facebook route is main method.
     *
     * @return array
     */
    public function indexAction()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
            'default_graph_version' => $this->appVersion,
            'default_access_token' => $this->accessToken, // optional
        ]);

        try {

            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me',$this->accessToken);

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {

            // When Graph returns an error
            return ['Graph returned an error: ' . $e->getMessage()];

        } catch(\Facebook\Exceptions\FacebookSDKException $e) {

            // When validation fails or other local issues
            return ['Facebook SDK returned an error: ' . $e->getMessage()];
        }

        return $response->getGraphUser();
    }
}
