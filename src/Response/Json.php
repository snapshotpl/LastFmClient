<?php

namespace LastFmClient\Response;

/**
 * Response
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class Json
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data)
    {
        if (isset($data['error'])) {
            throw new Exception($data['message'], $data['error']);
        }
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
