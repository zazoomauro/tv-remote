<?php

namespace Tv\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Process\Process;

class OpenChannelCommand extends Command
{
    static private $channels = [
        'Antena3' => 'http://a3live-lh.akamaihd.net/i/antena3_1@35248/master.m3u8',
        'LaSexta' => 'http://a3live-lh.akamaihd.net/i/lasexta_1@35272/master.m3u8'
    ];

    protected function configure()
    {
        $this
            ->setName('open-channel')
            ->setDescription('Opens a new channel');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('Please select the channel', ['Antena3', 'LaSexta'], 0);
        $question->setErrorMessage('Selected channel %s is invalid.');

        $channel = $helper->ask($input, $output, $question);

        $output->writeln("<info>You have just selected $channel</info>");

        $vlcPath = '/Applications/VLC.app/Contents/MacOS/VLC';
        $channelUrl = self::$channels[$channel];
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
}