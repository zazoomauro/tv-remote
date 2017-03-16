<?php

namespace Tv\Service\Channel\Adapter;

interface AdapterInterface
{
    /**
     * @return string[]
     */
    public function getListOfChannels(): array;

    /**
     * @param string $channelUrl
     * @return string
     */
    public function getChannelUrl(string $channelUrl): string;
}
