<?php

namespace LastFmClient\Transport;

use LastFmClient\Exception;

/**
 * ZendHttp
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class ZendHttp implements TransportInterface
{

    public function request($url, array $params = array(), $httpMethod = self::METHOD_GET)
    {
        throw new Exception('Transport is not implemented');
    }

}
