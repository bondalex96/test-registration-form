<?php

namespace App\Application\Command\User;


use App\Domain\Factory\User\UserFactory;
use App\Domain\Repository\User\UserRepository;
use App\Infrastructure\CommandBus\Command;
use App\Infrastructure\CommandBus\CommandHandler;
use Webmozart\Assert\Assert;

class UserRegistrationHandler implements CommandHandler
{
    private $userRepository;
    private $userFactory;

    public function __construct(UserRepository $userRepository, UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRegistrationCommand $command
     * @return \App\Domain\Entity\User\User
     */
    public function handle(Command $command)
    {
        Assert::isInstanceOf($command, UserRegistrationCommand::class);

        $user = $this->userFactory->register(
            $command->nick,
            $command->firstName,
            $command->lastName,
            $command->email,
            $command->password
        );
        $this->userRepository->save($user);
        return $user;

    }
}
