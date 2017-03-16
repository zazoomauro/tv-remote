<?php

namespace Tv\Service\M3u8\Adapter;

interface AdapterInterface
{
    /**
     * @param string $url
     */
    public function openM3u8(string $url);
}
