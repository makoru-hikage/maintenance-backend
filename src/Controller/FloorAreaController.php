<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\FloorArea;
use App\Entity\Floor;
use App\Factory\FloorAreaFactory;

class FloorAreaController extends AbstractController
{
    public function findFloor($code){
        $repo = $this->getDoctrine()->getRepository(Floor::class);
        $floor = $repo->findOneBy(['is_deleted' => 0, 'code' => $code]);

        return $floor;
    }

    public function findByRowCol($row, $col){
        $repo = $this->getDoctrine()->getRepository(FloorArea::class);
        $floorArea = $repo->findOneBy([
            'is_deleted' => 0,
            'floor_row' => $row,
            'floor_col' => $col
        ]);

        return $floorArea;
    }

    public function validateRowCol ($data, $maxRow, $maxCol){
        $errorMessages = [];
        $maxMessage = 'Max row: '. $maxRow .'; Max column' . $maxCol;

        if ($data['row'] < 1 || $data['row'] > $maxRow){
            $errorMessages['row'] = 'Row out of range';
            $errorMessages['max'] = $maxMessage;
        }

        if ($data['col'] < 1 || $data['col'] > $maxCol){
            $errorMessages['col'] = 'Column out of range';
            $errorMessages['max'] = $maxMessage;
        }

        if ($this->findByRowCol($data['row'], $data['col'])){
            $errorMessages['rowcol'] = 'Row and column combination not valid'; 
        }

        return $errorMessages;
    }

    public function validateEntity(ValidatorInterface $validator, $entity){
        $errors = $validator->validate($entity);
        $messages = [];
        if (count($errors) > 0) {
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
        }

        return $messages;
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
        $floor = $this->findFloor($data['floor']);

        // Check if the Floor exists, otherwise the area can't be registered
        if (!$floor){
            $errorMsg = [
                'floor' => 'The floor does not exist'
            ];
            return $this->json($errorMsg, 400);
        }

        $rowColErrors = $this->validateRowCol(
            $data,
            $floor->getTotalRows(),
            $floor->getTotalCols());

            if ($rowColErrors){
                return $this->json($rowColErrors, 400);
            }

        $floorArea = (new FloorAreaFactory($data))->create();
        $floorArea->setFloorId($floor->getId());

        $errorMessages = $this->validateEntity($validator, $floorArea);
        if ($errorMessages){
            return $this->json($errorMessages, 400);
        }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($floorArea);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([], 201);
    }
}
