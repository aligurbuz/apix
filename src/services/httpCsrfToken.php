<?php
/**
 * User: aligurbuz
 */

namespace src\services;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use src\services\httpSession as Session;


class httpCsrfToken {

    const ENTROPY = 1000;
    /**
     * A non alpha-numeric byte string.
     *
     * @var string
     */
    private static $bytes;
    /**
     * @var UriSafeTokenGenerator
     */
    private $generator;

    public function __construct(){
        $this->setUp();
    }
    public static function setUpBeforeClass()
    {
        self::$bytes = base64_decode('aMf+Tct/RLn2WQ==');
    }
    protected function setUp()
    {
        $this->generator = new UriSafeTokenGenerator(self::ENTROPY);
    }
    protected function tearDown()
    {
        $this->generator = null;
    }
    public function GenerateToken()
    {
        return $this->generator->generateToken();

    }
    public function checkTokenForPostMethod($data){
        if(app("session")->has("postToken")){
            $token=app("session")->get("postToken");
            if($data==$token){
                return true;
            }
        }

        return false;
    }

}
