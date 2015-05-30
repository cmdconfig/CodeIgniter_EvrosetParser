<?php
/**
 * Title:
 * Author: Petr Supe
 * Email: cmdconfig@gmail.com 
 * Date: 30.05.2015
 * Time: 10:48 AM
 */

class Parsermodel extends CI_Model {

    private static $class = null;

    private $uAgent;

    private $cookieFile = '';

    public $lastRequestData;




    public function __construct($options = null){
        parent::__construct();

        $this->cookieFile = $this->config->item('cookieFilePath').uniqid().'.txt';
        var_dump($this->cookieFile);die();
    }

    /**
     * @param null $options
     * @return ParserModel
     */
    public static function forge($options = null){
        if(!self::$class){
            self::$class = new self($options);
        }

        return self::$class;
    }

    public function getPages($pageURL){;
        $html = $this->getUrl($pageURL);
    }

    /**
     * @param string $url
     * @param string $cookieFile
     * @return mixed
     */
    private function getUrl($url){
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_USERAGENT, $this->uAgent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);

        $content = curl_exec( $ch );
        $err = curl_errno( $ch );
        $errMsg = curl_error( $ch );
        $header = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errNo'] = $err;
        $header['errMsg'] = $errMsg;
        $header['content'] = $content;
        $this->lastRequestData = $header;

        return $header;
    }



}