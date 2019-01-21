<?php

namespace App\Api\Controller;

use App\Application\DTO\RegistrationDto;
use App\Application\UseCase\Registration;
use App\Infrastructure\Controller\BaseWriteController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends BaseWriteController
{
    /**
     * @Route("/register", name="registration", methods={"POST"})
     */
    public function index(Request $request)
    {
        return $this->executeAction($request, function (RegistrationDto $dto) {

            $user = $this->getInteractor()->execute($dto);

            return $this->json([
                'id' => $user->getId()
            ], Response::HTTP_CREATED);
        });
    }

    protected function getInteractor(): Registration
    {
        return $this->interactor;
    }
}
