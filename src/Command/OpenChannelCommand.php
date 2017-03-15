<?php

namespace Tv\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Process\Process;

class OpenChannelCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('open-channel')
            ->setDescription('Opens a new channel');
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        return new Client([
            'base_uri' => 'https://gist.githubusercontent.com',
            'timeout' => 2.0,
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $response = $this->getClient()->get('izqui/56c5ff8e7a1aeaf1efd9/raw/69f328fa792df6506ddaee0f9e813960636a2efd/channels.json');
        $body = json_decode($response->getBody(), true);

        $channels = [];
        foreach ($body as $item) {
            if (isset($item[7])) {
                array_push($channels, $item[5]);
            }
        }

        $question = new ChoiceQuestion('Please select the channel', $channels, 0);
        $question->setErrorMessage('Selected channel %s is invalid.');

        $channel = $helper->ask($input, $output, $question);

        $output->writeln("<info>You have just selected $channel</info>");

        $vlcPath = '/Applications/VLC.app/Contents/MacOS/VLC';
        $channelUrl = $this->getChannelUrl($channel);
        $process = new Process("{$vlcPath} \"{$channelUrl}\"");
        $process->start();
        $process->wait(function ($type, $buffer) use ($output) {
            if (Process::ERR === $type) {
                $output->writeln("<error>$buffer</error>");
            } else {
                $output->writeln("<info>$buffer</info>");
            }
        });
    }

    private function getChannelUrl($channel)
    {
        $response = $this->getClient()->get('izqui/56c5ff8e7a1aeaf1efd9/raw/69f328fa792df6506ddaee0f9e813960636a2efd/channels.json');
        $body = json_decode($response->getBody(), true);

        foreach ($body as $item) {
            if ($item[5] === $channel) {
                return $item[7];
            }
        }
    }
}