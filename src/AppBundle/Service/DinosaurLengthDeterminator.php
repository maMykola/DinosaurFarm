<?php


namespace AppBundle\Service;


use AppBundle\Entity\Dinosaur;

class DinosaurLengthDeterminator
{
    public function getLengthFromSpecification(string $specification): int
    {
        $availableLength = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];

        foreach ($availableLength as $term => $bounds) {
            if (stripos($specification, $term) !== false) {
                return random_int($bounds['min'], $bounds['max']);
            }
        }

        return random_int(1, Dinosaur::LARGE - 1);
    }

}