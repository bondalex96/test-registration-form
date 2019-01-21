<?php

namespace App\Api\Controller;

use App\Infrastructure\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckUniqueEmailController extends BaseController
{
    /**
     * @Route("/email/{email}/check-unique", name="check_email", methods={"GET"})
     */
    public function index(string $email)
    {
        return $this->json([
            'unique' => $this->getInteractor()->execute($email)
        ], Response::HTTP_OK);
    }
}
