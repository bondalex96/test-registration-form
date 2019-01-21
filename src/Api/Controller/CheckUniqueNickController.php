<?php

namespace App\Api\Controller;

use App\Infrastructure\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckUniqueNickController extends BaseController
{
    /**
     * @Route("/nick/{nick}/check-unique", name="check_email", methods={"GET"})
     */
    public function index(string $nick)
    {
        try {
            return $this->json([
                'unique' => $this->getInteractor()->execute($nick)
            ], Response::HTTP_OK);

        } catch (\DomainException $exception) {
            return $this->json(['errors' => [$exception->getMessage()]], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return $this->handleInternalException($exception);
        }
    }
}
