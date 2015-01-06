<?php

namespace LastFmClient\Transport;

use LastFmClient\Exception;

/**
 * Httpfull
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Httpfull implements TransportInterface
{
    public function request($url, array $params = array(), $httpMethod = self::METHOD_GET)
    {
        throw new Exception('Transport is not implemented');
    }

}
