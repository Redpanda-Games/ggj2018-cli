<?php

namespace App\Commands;

use App\Octopus;

class BootCommand extends Command
{

    public function configure(): void
    {
        $this
            ->setName('boot')
            ->setDescription('Boots the octopus system');
    }

    protected function handle()
    {
        $this->output->writeln('<fg=blue>
 dP"Yb   dP""b8 888888  dP"Yb  88""Yb 88   88 .dP"Y8 
dP   Yb dP   `"   88   dP   Yb 88__dP 88   88 `Ybo." 
Yb   dP Yb        88   Yb   dP 88""Yb Y8   8P o.`Y8b 
 YbodP   YboodP   88    YbodP  88oodP `YbodP\' 8bodP\' 
</>');

        $this->output->writeln('OctoBUS DNA-Transmitter');
        $this->output->writeln('booting system ...');
        $this->output->writeln('');

        $this->octopus = new Octopus();

        $this->animateOctopus();
    }

    protected function animateOctopus(): void
    {
        $octopus = [
            [
                "",
                "",
                "                  ,---.                       ",
                "                 ( @ @ )                      ",
                "                  ).-.(\                      ",
                "                 '/|||\`\                     ",
                "                   '|`                        ",
                "",
                "",
                "",
                "",
                "",
                "",
            ], [
                "",
                "",
                "                  ,----.                      ",
                "                 |(@)(@)|                     ",
                "                  ) __ (                      ",
                "                 '/|||\`\                     ",
                "                   '|`                        ",
                "",
                "",
                "",
                "",
                "",
                "",
            ], [
                "",
                "",
                "                  ,----.                      ",
                "                 |(@)(@)|                     ",
                "                  ) __ (                      ",
                "                /,'))((`.\\                   ",
                "               (( ((  )) ))                   ",
                "                   '|`                        ",
                "",
                "",
                "",
                "",
                "",
            ], [
                "",
                "                  ,'\"\"`.                    ",
                "                 / _  _ \                     ",
                "                 |(@)(@)|                     ",
                "                 )  __  (                     ",
                "                /,'))((`.\\                   ",
                "               (( ((  )) ))                   ",
                "                `\ `)(' /'                    ",
                "",
                "",
                "",
                "",
                "",
            ], [
                "                   _,--._                     ",
                "                 ,'      `.                   ",
                "         |\     / ,-.  ,-. \     /|           ",
                "         )o),/ ( ( o )( o ) ) \.(o(           ",
                "        /o/// /|  `-'  `-'  |\ \\\o\          ",
                "       / / |\ \(   .    ,   )/ /| \ \         ",
                "       | | \o`-/    `\/'    \-'o/ | |         ",
                "       \ \  `,'              `.'  / /         ",
                "    \.  \ `-'  ,'|   /\   |`.  `-' /  ,/      ",
                "     \`. `.__,' /   /  \   \ `.__,' ,'/       ",
                "      \o\     ,'  ,'    `.  `.     /o/        ",
                "       \o`---'  ,'        `.  `---'o/         ",
                "        `.____,'            `.____,'          ",
            ],
        ];

        $lastFrame = [];
        foreach($octopus as $frame) {
            $this->rewind(count($lastFrame));
            $this->output->writeln(array_map(function ($line) {
                return '<fg=magenta>'.$line.'</>';
            }, $frame));
            sleep(1);
            $lastFrame = $frame;
        }
        $this->io->newLine();
    }

    private function rewind(int $lines): void
    {
        // Move the cursor to the beginning of the line
        $this->output->write("\x0D");
        // Erase the line
        $this->output->write("\x1B[2K");
        // Erase previous lines
        if ($lines > 0) {
            $this->output->write(str_repeat("\x1B[1A\x1B[2K", $lines));
        }
    }
}