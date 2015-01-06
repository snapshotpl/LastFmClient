<?php

namespace LastFmClient\Transport;

use LastFmClient\Exception;

/**
 * Curl
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Curl implements TransportInterface
{
    public function request($url, array $params = [], $httpMethod = self::METHOD_GET)
    {
        $ch = curl_init();

        $paramsString = http_build_query($params);

        switch ($httpMethod) {
            case self::METHOD_GET:
                $url .= '?' . $paramsString;
                break;
            case self::METHOD_POST:
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $paramsString,
                ]);
                break;
            default:
                throw new Exception(sprinf('Unknown HTTP method "%s"', $httpMethod));
        }
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
        ]);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

}
