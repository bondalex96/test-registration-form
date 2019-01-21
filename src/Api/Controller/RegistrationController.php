<?php

namespace App\Api\Controller;

use App\Infrastructure\Controller\BaseController;
use App\Infrastructure\Form\FormValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends BaseController
{
    /**
     * @Route("/register", name="registration", methods={"POST"})
     */
    public function index()
    {
        try {

            $user = $this->getInteractor()->execute();

            return $this->json(['id' => $user->getId()], Response::HTTP_CREATED);

        } catch (\DomainException $exception) {
            return $this->json(['errors' => [$exception->getMessage()]], Response::HTTP_BAD_REQUEST);

        } catch (FormValidationException $exception) {
            return $this->json(['errors' => $exception->getErrorsMessages()], Response::HTTP_BAD_REQUEST);

        } catch (\Throwable $exception) {
            return $this->handleInternalException($exception);
        }
    }
}
