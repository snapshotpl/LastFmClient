<?php

namespace LastFmClient\Format;

/**
 * FormatInterface
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface FormatInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $responseBody
     * @return \LastFmClient\Response\ResponseInterface $responseBody
     */
    public function buildResponse($responseBody);
}
