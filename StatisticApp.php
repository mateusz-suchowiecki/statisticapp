<?php

namespace Emsoft\StatisticAppBundle;

use Emsoft\StatisticAppBundle\StatisticMessage;

class StatisticApp 
{

    private $appId;
    private $serverIp = '178.62.230.79:9999';

    public function __construct($appId, $serverIp = null)
    {
        $this->appId = $appId;
        if ($serverIp) {
            $this->serverIp = $serverIp;
        }
    }
    
    public function send(StatisticMessage $message)
    {
        
        $fp = stream_socket_client("udp://" . StatisticApp::$serverIp, $errno, $errstr);
        if ($fp) {
            fwrite($fp, $message->prepare($this->appId));
            fclose($fp);
        }
        else {
            throw new Exception($errstr);
        }
    }
    
    
}

