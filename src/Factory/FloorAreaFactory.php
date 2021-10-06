<?php

namespace App\Factory;

use App\Entity\FloorArea; 

class FloorAreaFactory {

    private $description;
    private $row;
    private $col;

    public function __construct($data) {
        $this->description = $data['description'];
        $this->row = $data['row'];
        $this->col = $data['col'];
    }

    /**
     * source:
     * http://www.learningaboutelectronics.com/Articles/How-to-generate-a-random-video-id-like-youtube-in-PHP.php
     */
    public static function generateRandomCode () {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
        $result = '';
        for ($i = 0; $i < 11; $i++)
            $result .= $characters[mt_rand(0, 63)];

        return $result;
    }

    public function create(){
        $floorArea = new FloorArea();
        $floorArea->setAreaCode($this->generateRandomCode());
        $floorArea->setDescription($this->description);
        $floorArea->setFloorRow($this->row);
        $floorArea->setFloorCol($this->col);

        return $floorArea;
    }


}