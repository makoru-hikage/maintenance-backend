<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\FloorArea;
use App\Entity\Floor;

class FloorAreaController extends AbstractController
{
    public function findFloor($code){
        $repo = $this->getDoctrine()->getRepository(Floor::class);
        $floor = $repo->findOneBy(['is_deleted' => 0, 'code' => $code]);

        return $floor;
    }
    #[Route('/floorareas', methods: ['GET'], name: 'floor_area')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FloorAreaController.php',
        ]);
    }

    #[Route('/floorareas', methods: ['POST'], name: 'floorarea-create')]
    public function createFloor(Request $request, ValidatorInterface $validator): Response {

        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $description = $data['description'];
        $floorCode = $data['floor'];
        $row = $data['row'];
        $col = $data['col'];

        $floor = $this->findFloor($floorCode);

        if (!$floor){
            $errorMsg = [
                'floor' => 'The floor does not exist'
            ];
            return $this->json($errorMsg, 400);
        }

        $floorCode = $floor->getCode();

        $floorArea = new FloorArea();
        $floorArea->setAreaCode($floorCode . '-' . $row . '-' . $col);
        $floorArea->setDescription($description);
        $floorArea->setFloorId($floor->getId());
        $floorArea->setFloorRow($row);
        $floorArea->setFloorCol($col);

        $errors = $validator->validate($floorArea);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            return $this->json($messages, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($floorArea);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([], 201);
    }
}
