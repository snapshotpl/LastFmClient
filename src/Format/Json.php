<?php

namespace LastFmClient\Format;

use LastFmClient\Response;

/**
 * Json
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Json implements FormatInterface
{
    const FORMAT_NAME = 'json';

    /**
     * @param string $responseBody
     * @return \LastFmClient\Response\Json
     */
    public function buildResponse($responseBody)
    {
        $response = json_decode($responseBody, true);

        return new Response\Json($response);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::FORMAT_NAME;
    }

}
