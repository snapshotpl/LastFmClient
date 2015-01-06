<?php

namespace LastFmClient\Service;

/**
 * User Service
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class User extends AbstractService
{

    /**
     * @link http://www.last.fm/api/show/user.shout
     * @param string $user
     * @param string $message
     * @param array $params
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function shout($user, $message, array $params)
    {
        $params['user'] = $user;
        $params['message'] = $message;

        return $this->callAuth(__FUNCTION__, $params);
    }

    /**
     * @link http://www.last.fm/api/show/user.shout
     * @param string $user
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getInfo($user = null)
    {
        $params = [];

        if ($user !== null) {
            $params['user'] = $user;
        }
        return $this->call(__FUNCTION__, $params);
    }
}
