<?php

namespace LastFmClient\Service;

use DateTime;
use LastFmClient\Client;
use LastFmClient\ClientAwareInterface;
use LastFmClient\Exception;
use LastFmClient\Response\ResponseInterface;
use LastFmClient\Transport\TransportInterface;

/**
 * AbstractService
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
abstract class AbstractService implements ClientAwareInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param string $method
     * @param array $params
     * @param string $httpMethod
     * @return ResponseInterface
     */
    protected function call($method, array $params = [], $httpMethod = TransportInterface::METHOD_GET)
    {
        $methodName = $this->getMethodName($method);

        return $this->getClient()->call($methodName, $params, $httpMethod);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $httpMethod
     * @return ResponseInterface
     */
    protected function callAuth($method, array $params = [], $httpMethod = TransportInterface::METHOD_POST)
    {
        $methodName = $this->getMethodName($method);

        return $this->getClient()->callAuth($methodName, $params, $httpMethod);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $httpMethod
     * @return ResponseInterface
     */
    protected function callSign($method, array $params = [], $httpMethod = TransportInterface::METHOD_GET)
    {
        $methodName = $this->getMethodName($method);

        return $this->getClient()->callSign($methodName, $params, $httpMethod);
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return bool
     */
    public function isClient()
    {
        return $this->client !== null;
    }

    /**
     * @return Client
     * @throws Exception
     */
    public function getClient()
    {
        if ($this->isClient()) {
            return $this->client;
        }
        throw new Exception('Client is not set');
    }

    /**
     * @param string $method
     * @return string
     */
    protected function getMethodName($method)
    {
        $package = get_called_class();
        $parts = explode('\\', $package);
        $packageName = strtolower(end($parts));

        return sprintf('%s.%s', $packageName, $method);
    }

    /**
     * @param DateTime|string $timestamp
     * @return string
     */
    protected function getFormatedTimestamp($timestamp)
    {
        return $timestamp instanceof DateTime ? $timestamp->getTimestamp() : $timestamp;
    }
}
