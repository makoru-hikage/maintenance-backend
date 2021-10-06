<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Floor;

class FloorController extends AbstractController
{
    #[Route('/floors', methods: ['GET'], name: 'floor')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Floor::class);
        $floors = $repo->findBy(['is_deleted' => 0]);
        return $this->json(array_map(fn($x) => $x->jsonSerialize(), $floors));
    }

    #[Route('/floors', methods: ['POST'], name: 'floor-create')]
    public function createFloor(Request $request, ValidatorInterface $validator): Response {

        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $code = $data['code'];
        $rows = $data['rows'];
        $cols = $data['cols'];
        $floor = new Floor();
        $floor->setCode($code);
        $floor->setTotalRows($rows);
        $floor->setTotalCols($cols);

        $errors = $validator->validate($floor);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return $this->json($messages, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($floor);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([], 201);
    }
}
