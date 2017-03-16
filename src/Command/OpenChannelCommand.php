<?php

namespace Tv\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Tv\Service\Channel\Adapter\Apps4Two;
use Tv\Service\M3u8\Adapter\Vlc;

class OpenChannelCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('open-channel')
            ->setDescription('Opens a new channel');
    }

    /**
     * @return Apps4Two
     */
    private function getChannelAdapter()
    {
        return new Apps4Two();
    }

    /**
     * @return Vlc
     */
    private function getM3U8Adapter()
    {
        return new Vlc();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion('Please select the channel', $this->getChannelAdapter()->getListOfChannels(), 0);
        $question->setErrorMessage('Selected channel %s is invalid.');

        $channel = $helper->ask($input, $output, $question);

        $output->writeln("<info>You have just selected $channel</info>");

        $this->getM3U8Adapter()->openM3u8($this->getChannelAdapter()->getChannelUrl($channel));

        $output->writeln('<info>Opening M3U8...</info>');
    }
}
