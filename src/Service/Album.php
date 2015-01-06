<?php

namespace LastFmClient\Service;

/**
 * Album Service
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Album extends AbstractService
{
    /**
     * @link http://www.lastfm.fm/api/show/album.getInfo
     * @param string $artist
     * @param string $album
     * @param array $parameters
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getInfo($artist, $album, array $parameters = [])
    {
        $parameters['artist'] = $artist;
        $parameters['album'] = $album;

        return $this->call(__FUNCTION__, $parameters);
    }

    /**
     * @link http://www.lastfm.pl/api/show/album.getInfo
     * @param string $mbid
     * @param array $parameters
     * @return \LastFmClient\Response\ResponseInterface
     */
    public function getInfoByMbid($mbid, array $parameters = [])
    {
        $parameters['mbid'] = $mbid;

        return $this->call('getInfo', $parameters);
    }
}
