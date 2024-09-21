<?php

namespace App\Command;

use App\Component\User\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'roles:add-to-user',
    description: 'Add a short description for your command',
    aliases: ['r:add']
)]
class RolesAddToUserCommand extends Command
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserManager $userManager
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $idQuestion = new Question('Please enter the role id: ');
        $roleQuestion = new Question('Please enter the role role: ');

        $questionHelper = $this->getHelper('question');
//        $id = $questionHelper->ask($input, $output, $idQuestion);

        $user = null;
        $id = null;
        $role = "";
        while (!$user) {
            while (!$id){
                $id = $questionHelper->ask($input, $output, $idQuestion);

                if( $id ){
                    $io->info('Kiritilgan id: ' . $id);
                } else{
                    $io->warning('Id kiritish majburiy');
                }
            }
            $user = $this->userRepository->find($id);
            if(!$user){
                $io->warning('Id kiritish majburiy');
                exit();
            }
        }

        while (!$role){
            $role = $questionHelper->ask($input, $output, $roleQuestion);
            if(!$role){
                $io->warning('Role kiritish majburiy');
            }
        }

        if($user->getRoles()){
            $roles = $user->getRoles();
            $roles[] = $role;

            $user->setRoles($roles);
            $this->userManager->save($user, true);

        $io->success('USER SUCCESS');

        }
        return Command::SUCCESS;

    }
}
