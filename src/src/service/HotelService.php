<?php

namespace App\service;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;

class HotelService
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /***
     * @param $name
     * @return Hotel[]
     */
    public function searchByName($name): array
    {
        $repository = $this->em->getRepository(Hotel::class);
        return $this->em->createQueryBuilder()
            ->from('App:Hotel', 'h')
            ->select('h')
            ->where('h.name like :name')
            ->setParameter('name', $name.'%')
            ->getQuery()
            ->getResult();
    }
}