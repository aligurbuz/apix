<?php
/**
 * User: aligurbuz
 */

namespace src\store\services;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;


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

    /**
     * @var session var
     */
    private $session;

    public function __construct(){
        $this->setUp();
        $this->session=app("session");

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
        $border=new self;
        if($border->session->has("postToken")){
            $token=$border->session->get("postToken");
            if($data==$token){
                return true;
            }
        }

        return false;
    }

}
