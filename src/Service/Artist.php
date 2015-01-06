<?php

namespace LastFmClient\Service;

/**
 * Artist Service
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Artist extends AbstractService
{
    /**
     * @link http://www.last.fm/api/show/artist.getInfo
     * @param string $artist
     * @param array $params
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getInfo($artist, array $params = [])
    {
        $params['artist'] = $artist;

        return $this->call(__FUNCTION__, $params);
    }

    /**
     * @link http://www.last.fm/api/show/artist.getInfo
     * @param string $mbid
     * @param array $params
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getInfoByMbid($mbid, array $params = [])
    {
        $params['mbid'] = $mbid;

        return $this->call('getInfo', $params);
    }

    /**
     * @link http://www.last.fm/api/show/artist.search
     * @param string $artist
     * @param array $params
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function search($artist, array $params = [])
    {
        $params['artist'] = $artist;

        return $this->call(__FUNCTION__, $params);
    }
}
