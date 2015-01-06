<?php

namespace LastFmClient\Service;

use LastFmClient\Exception;
use LastFmClient\Response;

/**
 * Track Service
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Track extends AbstractService
{

    const SCROBBLE_BATCH_MAX = 50;

    /**
     * @link http://www.last.fm/api/show/track.getInfo
     * @param string $track
     * @param string $artist
     * @param array $params
     * @return Response\ResponseInterface
     */
    public function getInfo($track, $artist, array $params = [])
    {
        $params['track'] = $track;
        $params['artist'] = $artist;

        return $this->call(__FUNCTION__, $params);
    }

    /**
     * @link http://www.last.fm/api/show/track.getInfo
     * @param string $mbid
     * @param array $params
     * @return Response\ResponseInterface
     */
    public function getInfoByMbid($mbid, array $params = [])
    {
        $params['mbid'] = $mbid;

        return $this->call('getInfo', $params);
    }

    /**
     * @link http://www.last.fm/api/show/track.search
     * @param string $track
     * @param array $params
     * @return Response\ResponseInterface
     */
    public function search($track, array $params = [])
    {
        $params['track'] = $track;

        return $this->call(__FUNCTION__, $params);
    }

    /**
     * @link http://www.last.fm/api/show/track.scrobble
     * @param string $artist
     * @param string $track
     * @param \DateTime|string $timestamp
     * @param array $params
     * @return Response\ResponseInterface
     */
    public function scrobble($artist, $track, $timestamp = null, array $params = [])
    {
        if ($timestamp === null) {
            $timestamp = new \DateTime();
        }
        $params['artist'] = $artist;
        $params['track'] = $track;
        $params['timestamp'] = $this->getFormatedTimestamp($timestamp);

        return $this->callAuth(__FUNCTION__, $params);
    }

    /**
     * @link http://www.last.fm/api/show/track.scrobble
     * @param array $data
     * @return Response\ResponseInterface
     * @throws Exception
     */
    public function scrobbleBatch(array $data)
    {
        if (count($data) > self::SCROBBLE_BATCH_MAX) {
            $message = sprintf('You can scrobble max %s tracks per request', self::SCROBBLE_BATCH_MAX);
            throw new Exception($message);
        }
        $scrobbled = 0;
        $params = [];

        foreach ($data as $track) {
            if (!isset($track['artist'])) {
                throw new Exception('"artist key does not exist"');
            }
            if (!isset($track['track'])) {
                throw new Exception('"track key does not exist"');
            }
            if (!isset($track['timestamp'])) {
                throw new Exception('"timestamp key does not exist"');
            } else {
                $track['timestamp'] = $this->getFormatedTimestamp($track['timestamp']);
            }
            foreach ($track as $key => $value) {
                $paramKey = sprintf('%s[%s]', $key, $scrobbled);
                $params[$paramKey] = $value;
            }
            $scrobbled++;
        }
        return $this->callAuth('scrobble', $params);
    }

    /**
     * @link http://www.last.fm/api/show/track.love
     * @param string $track
     * @param string $artist
     * @return Response\ResponseInterface
     */
    public function love($track, $artist)
    {
        $params = [
            'track' => $track,
            'artist' => $artist,
        ];
        return $this->callAuth(__FUNCTION__, $params);
    }

}
