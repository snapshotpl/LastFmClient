<?php

namespace LastFmClient\Service;

use LastFmClient\Client;

/**
 * Auth Service
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Auth extends AbstractService
{
    /**
     * @link http://www.last.fm/api/show/auth.getSession
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getSession()
    {
        $parameters = [
            Client::REQUEST_PARAM_TOKEN => true,
        ];
        return $this->callSign(__FUNCTION__, $parameters);
    }

    /**
     * @link http://www.last.fm/api/show/auth.getToken
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getToken()
    {
        return $this->callSign(__FUNCTION__);
    }
}
