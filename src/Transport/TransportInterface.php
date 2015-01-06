<?php

namespace LastFmClient\Transport;

/**
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface TransportInterface
{
    const METHOD_POST = 'method_post';
    const METHOD_GET = 'method_get';

    public function request($url, array $params = [], $httpMethod = self::METHOD_GET);
}
