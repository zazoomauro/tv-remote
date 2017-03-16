<?php

namespace Tv\Service\Channel\Adapter;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class Apps4Two implements AdapterInterface
{
    const ENDPOINT = 'http://www.apps4two.com/apps/tvonline/ch_channel.php';
    const TMP_FILE_PATH = __DIR__ . '/../../../../tmp/channels';

    private function downloadChannels()
    {
        $tmpFilePath = self::TMP_FILE_PATH;
        $endpoint = self::ENDPOINT;
        $downloadTmpFileProcess = new Process("wget -O $tmpFilePath -q \"$endpoint\"");
        $downloadTmpFileProcess->run();

        if (!$downloadTmpFileProcess->isSuccessful()) {
            throw new ProcessFailedException($downloadTmpFileProcess);
        }
    }

    /**
     * @return string[]
     */
    public function getListOfChannels(): array
    {
        $this->downloadChannels();
        $jsonString = file_get_contents(self::TMP_FILE_PATH);
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
        try {
            $jsonString = file_get_contents(self::TMP_FILE_PATH);
        } catch (\Exception $exception) {
            $this->downloadChannels();
            $jsonString = file_get_contents(self::TMP_FILE_PATH);
        }
        $json = json_decode($jsonString, true);

        foreach ($json as $item) {
            if ($item[5] === $channelUrl) {
                return $item[7];
            }
        }

        throw new \TypeError("$channelUrl not found");
    }
}
