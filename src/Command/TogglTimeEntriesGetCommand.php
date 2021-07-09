<?php

namespace App\Command;

use App\Toggl\Contracts\TimeEntryInterface;
use App\Toggl\TogglClientException;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TogglTimeEntriesGetCommand extends Command
{
    protected static $defaultName = 'toggl:time-entries:get';
    protected static $defaultDescription = 'Add a short description for your command';
    private DateTime $date;
    private TimeEntryInterface $client;

    protected function configure(): void
    {
        $this->date = new DateTime();
        $this
            ->addArgument('year', InputArgument::OPTIONAL, 'the week to load', $this->date->format('Y'))
            ->addArgument('week', InputArgument::OPTIONAL, 'the week to load', $this->date->format('W'))
        ;
    }

    /**
     * @throws TogglClientException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $week = $input->getArgument('week');
        $year = $input->getArgument('year');
        $this->date->setISODate($year, $week)->setTime(0, 0);
        $to = clone $this->date;
        $to->modify("+6 days");
        dump($this->client->list($this->date, $to));

        return Command::SUCCESS;
    }

    /**
     *
     * @required
     */
    public function setClient(TimeEntryInterface $client)
    {
        $this->client = $client;
    }
}
