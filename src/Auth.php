<?php

namespace LastFmClient;

/**
 * Auth
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Auth
{
    protected $apiKey;
    protected $token;
    protected $session;
    protected $secret;

    public function getApiKey()
    {
        if ($this->apiKey === null) {
            throw new Exception('Missing api_key');
        }
        return $this->apiKey;
    }

    public function getToken()
    {
        if ($this->token === null) {
            throw new Exception('Missing token');
        }
        return $this->token;
    }

    public function getApiSig(array $params)
    {
        $signatureBeforeHash = '';
        ksort($params);

        foreach ($params as $key => $value) {
            $signatureBeforeHash .= $key . $value;
        }
        $signatureBeforeHash .= $this->getSecret();
        $signature = md5($signatureBeforeHash);

        return $signature;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getSession()
    {
        if ($this->session === null) {
            throw new Exception('Missing session');
        }
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    public function getSecret()
    {
        if ($this->secret === null) {
            throw new Exception('Missing secret');
        }
        return $this->secret;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

}
