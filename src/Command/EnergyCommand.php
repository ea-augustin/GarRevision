<?php

namespace App\Command;

use App\Entity\Energy;
use App\Repository\EnergyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-energy',
    description: 'Add a short description for your command',
)]
class EnergyCommand extends Command
{
    // the name of the command (the part after "bin/console") + type
    protected static $defaultName = 'app:create-energy';


    private EntityManagerInterface $entityManagerInterface;
//    private $energyRepository;

    public function __construct(EntityManagerInterface $entityManagerInterface, EnergyRepository $energyRepository)
    {
        $this->entityManagerInterface = $entityManagerInterface;
//        $this->energyRepository = $energyRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates energy and stores them in the database')
            ->addArgument('type', InputArgument::OPTIONAL, 'The Type of energy');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(
            [
                'Energy Creator',
                '============',
                'Remember to add the  type of energy',
            ]
        );

        $energy = new Energy();
        $type = $input->getArgument("type");
        $energy->setType($type);
        $this->entityManagerInterface->persist($energy);
        $this->entityManagerInterface->flush();


        return Command::SUCCESS;
    }


}
