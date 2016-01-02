<?php

namespace Emsoft\StatisticAppBundle;


class StatisticMessage 
{

    private $userKey;
    private $sessionId;
    private $slug;
    
    public function __construct($userKey)
    {
        $this->sessionId = session_id();
        $this->userKey = $userKey;
        $this->slug = $_SERVER["REQUEST_URI"];
        
        return $this;
    }
    

    public function getUserKey()
    {
        return $this->userKey;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;
        return $this;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function prepare($appId) 
    {
        return json_encode([
            'appId' => $appId,
            'userKey' => $this->userKey,
            'sessionId' => $this->sessionId,
            'slug' => $this->slug,
        ]);
    }
    
    
}
