<?php

namespace App\Commands;

use App\Octopus;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class Command extends SymfonyCommand
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var Octopus
     */
    protected $octopus;


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($input, $output);

        $this->handle();
        $this->save();
    }

    abstract protected function handle();

    protected function load()
    {
        $this->octopus = Octopus::load();
    }

    protected function save($reactivate = true)
    {
        if($this->octopus instanceof Octopus) {
            $this->octopus->save($reactivate);
        }
    }

    protected function table(array $header, array $rows)
    {
        $table = new Table($this->output);
        $table
            ->setHeaders($header)
            ->setRows($rows)
        ;
        $table->render();
    }

    protected function success($messages)
    {
        $this->output->writeln($this->mapStyle('<fg=green>%s</>', $messages));
    }

    protected function error($messages)
    {
        $this->output->writeln($this->mapStyle('<fg=red>[ERROR] %s</>', $messages));
    }

    protected function mapStyle($format, $messages)
    {
        if(is_string($messages)) {
            $messages = [$messages];
        }

        foreach($messages as $i => $message) {
            $messages[$i] = sprintf($format, $message);
        }

        return $messages;
    }
}