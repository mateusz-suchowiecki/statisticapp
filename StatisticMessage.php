<?php

namespace Emsoft\StatisticAppBundle;

class StatisticMessage 
{

    private $appId;
    private $message;

    public function __construct($appId)
    {
        $this->appId = $appId;
    }
    
    public function prepare($userKey)
    {
        $message = [
            'appId' => $this->appId, 
            'userKey' => $userKey,
            'sessionId' => session_id(),
            'slug' => $_SERVER["REQUEST_URI"]
        ];
        
        $this->message = json_encode($message);
        return $this;
    }
    
    public function send() 
    {
        $fp = stream_socket_client("udp://178.62.230.79:9999", $errno, $errstr);
        if ($fp) {
            fwrite($fp, $this->message);
            fclose($fp);
        }
    }
}
