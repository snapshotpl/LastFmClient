<?php

namespace LastFmClient;

/**
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
interface ClientAwareInterface
{
    public function setClient(Client $client);
    public function getClient();
}
