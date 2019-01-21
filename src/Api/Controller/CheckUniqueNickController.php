<?php

namespace App\Api\Controller;

use App\Infrastructure\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckUniqueNickController extends BaseController
{
    /**
     * @Route("/nick/{nick}/check-unique", name="check_nick", methods={"GET"})
     */
    public function index(string $nick)
    {
        return $this->json([
            'unique' => $this->getInteractor()->execute($nick)
        ], Response::HTTP_OK);
    }
}
