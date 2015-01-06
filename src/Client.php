<?php

namespace LastFmClient;

use LastFmClient\Format\FormatInterface;
use LastFmClient\Format\Json as FormatJson;
use LastFmClient\Auth;
use LastFmClient\Transport\TransportInterface;

/**
 * Client
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Client
{
    const REQUEST_PARAM_API_KEY = 'api_key';
    const REQUEST_PARAM_API_SIGNATURE = 'api_sig';
    const REQUEST_PARAM_FORMAT = 'format';
    const REQUEST_PARAM_METHOD = 'method';
    const REQUEST_PARAM_CALLBACK_URL = 'cb';
    const REQUEST_PARAM_SESSION_KEY = 'sk';
    const REQUEST_PARAM_TOKEN = 'token';

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var FormatInterface
     */
    protected $format;

    /**
     * @var array
     */
    protected $defaultParameters = [];

    /**
     * @var string
     */
    protected $endpoint = 'http://ws.audioscrobbler.com/2.0/';

    /**
     * @var string
     */
    protected $authUrl = 'http://www.last.fm/api/auth/';

    /**
     * @param Auth $auth
     * @param TransportInterface $transport
     */
    public function __construct(Auth $auth, TransportInterface $transport)
    {
        $this->setAuth($auth);
        $this->setTransport($transport);
    }

    /**
     * @param FormatInterface $format
     */
    public function setFormat(FormatInterface $format)
    {
        $this->format = $format;
    }

    /**
     * @return FormatInterface
     */
    public function getFormat()
    {
        if ($this->format === null) {
            $this->format = new FormatJson();
        }
        return $this->format;
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return TransportInterface
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param Auth $auth
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param array $parameters
     */
    public function setDefaultParameters(array $parameters)
    {
        $this->defaultParameters = $parameters;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return $this->defaultParameters;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @param string $httpMethod
     * @return Response\ResponseInterface
     */
    public function call($method, array $parameters = [], $httpMethod = TransportInterface::METHOD_GET)
    {
        $params = array_merge($this->getDefaultParameters(), $parameters);
        $auth = $this->getAuth();
        $format = $this->getFormat();

        $params[self::REQUEST_PARAM_API_KEY] = $auth->getApiKey();
        $params[self::REQUEST_PARAM_METHOD] = $method;

        if ($this->issetAndIsTrue($params, self::REQUEST_PARAM_TOKEN)) {
            $params[self::REQUEST_PARAM_TOKEN] = $auth->getToken();
        }
        if ($this->issetAndIsTrue($params, self::REQUEST_PARAM_SESSION_KEY)) {
            $params[self::REQUEST_PARAM_SESSION_KEY] = $auth->getSession();
        }
        if ($this->issetAndIsTrue($params, self::REQUEST_PARAM_API_SIGNATURE)) {
            unset($params[self::REQUEST_PARAM_API_SIGNATURE]);
            $params[self::REQUEST_PARAM_API_SIGNATURE] = $auth->getApiSig($params);
        }
        $params[self::REQUEST_PARAM_FORMAT] = $format->getName();

        $responseBody = $this->getTransport()->request($this->endpoint, $params, $httpMethod);

        return $format->buildResponse($responseBody);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $httpMethod
     * @return Response\ResponseInterface
     */
    public function callSign($method, array $params = [], $httpMethod = TransportInterface::METHOD_GET)
    {
        $params[self::REQUEST_PARAM_API_SIGNATURE] = true;

        return $this->call($method, $params, $httpMethod);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $httpMethod
     * @return Response\ResponseInterface
     */
    public function callAuth($method, array $params = [], $httpMethod = TransportInterface::METHOD_POST)
    {
        $params[self::REQUEST_PARAM_SESSION_KEY] = true;

        return $this->callSign($method, $params, $httpMethod);
    }

    /**
     * @param array $array
     * @param string $key
     * @return bool
     */
    protected function issetAndIsTrue(array $array, $key)
    {
        return isset($array[$key]) && $array[$key] === true;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = (string) $endpoint;
    }

    /**
     * @param string $callbackUrl
     * @return string
     */
    public function getAuthUrl($callbackUrl = null)
    {
        $params = [
            self::REQUEST_PARAM_API_KEY => $this->getAuth()->getApiKey(),
        ];
        if ($callbackUrl !== null) {
            $params[self::REQUEST_PARAM_CALLBACK_URL] = $callbackUrl;
        }
        return $this->authUrl . '?' . http_build_query($params);
    }

}
