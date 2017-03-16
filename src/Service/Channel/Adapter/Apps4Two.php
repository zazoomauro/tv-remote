<?php

namespace Tv\Service\Channel\Adapter;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class Apps4Two implements AdapterInterface
{
    /**
     * @return string[]
     */
    public function getListOfChannels(): array
    {
        $downloadTmpFileProcess = new Process("wget -O /tmp/channels -q \"http://www.apps4two.com/apps/tvonline/ch_channel.php\"");
        $downloadTmpFileProcess->run();

        if (!$downloadTmpFileProcess->isSuccessful()) {
            throw new ProcessFailedException($downloadTmpFileProcess);
        }

        $jsonString = file_get_contents("/tmp/channels");
        $json = json_decode($jsonString, true);

        $channels = [];
        foreach ($json as $item) {
            if (isset($item[7])) {
                array_push($channels, $item[5]);
            }
        }

        return $channels;
    }

    /**
     * @param string $channelUrl
     * @return string
     * @throws \TypeError
     */
    public function getChannelUrl(string $channelUrl): string
    {
        $jsonString = file_get_contents("/tmp/channels");
        $json = json_decode($jsonString, true);

        foreach ($json as $item) {
            if ($item[5] === $channelUrl) {
                return $item[7];
            }
        }

        throw new \TypeError("$channelUrl not found");
    }
}
