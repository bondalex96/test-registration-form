<?php

namespace App\Api\Controller;

use App\Application\Command\User\UserRegistrationCommand;
use App\Infrastructure\CommandBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/register", name="registration", methods={"POST"})
     */
    public function index(Request $request)
    {
        $user = $this->commandBus->execute(
            new UserRegistrationCommand(
                $request->get('nick', ''),
                $request->get('firstName', ''),
                $request->get('lastName', ''),
                $request->get('email', ''),
                $request->get('password', '')
            )
        );

        return $this->json(['id' => $user->getId()], Response::HTTP_CREATED);
    }
}
