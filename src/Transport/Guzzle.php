<?php

namespace LastFmClient\Transport;

use LastFmClient\Exception;

/**
 * Guzzle
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Guzzle implements TransportInterface
{

    public function request($url, array $params = array(), $httpMethod = self::METHOD_GET)
    {
        throw new Exception('Transport is not implemented');
    }

}
