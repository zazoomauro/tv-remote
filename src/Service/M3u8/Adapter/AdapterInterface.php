<?php

namespace Tv\Service\M3u8\Adapter;

interface AdapterInterface
{
    public function openM3u8(string $url): void;
}
