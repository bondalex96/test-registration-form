<?php

namespace App\Api\Controller;

use App\Application\Command\User\UserRegistrationCommand;
use App\Application\Query\User\CheckUniqueEmailQuery;
use App\Application\Query\User\CheckUniqueNickQuery;
use App\Application\ReadModels\SatisfactionOfCondition;
use App\Infrastructure\CommandBus\CommandBus;
use App\Infrastructure\QueryBus\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    private $commandBus;
    private $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/register", name="registration", methods={"POST"})
     */
    public function register(Request $request)
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

    /**
     * @Route("/email/{email}/check-unique", name="check_email", methods={"GET"})
     */
    public function checkEmail(string $email)
    {
        /** @var SatisfactionOfCondition $readModel */
        $readModel = $this->queryBus->execute(new CheckUniqueEmailQuery($email));
        return $this->json([
            'unique' => $readModel->isSatisfiedBy()
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/nick/{nick}/check-unique", name="check_nick", methods={"GET"})
     */
    public function checkNick(string $nick)
    {
        /** @var SatisfactionOfCondition $readModel */
        $readModel = $this->queryBus->execute(new CheckUniqueNickQuery($nick));

        return $this->json([
            'unique' => $readModel->isSatisfiedBy()
        ], Response::HTTP_OK);
    }

}
