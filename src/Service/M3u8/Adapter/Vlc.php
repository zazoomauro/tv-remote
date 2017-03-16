<?php

namespace Tv\Service\M3u8\Adapter;

use Cocur\BackgroundProcess\BackgroundProcess;

class Vlc implements AdapterInterface
{
    /**
     * @param string $url
     */
    public function openM3u8(string $url): void
    {
        $vlcPath = '/Applications/VLC.app/Contents/MacOS/VLC';

        $process = new BackgroundProcess("{$vlcPath} \"{$url}\"");
        $process->run();
    }
}
