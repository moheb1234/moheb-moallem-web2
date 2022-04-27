<?php

namespace App\Controller;



use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Tests\Models\Cache\Attraction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about')]
    public function about(): Response
    {

       return new Response(<<<EOF
<html>
   <body>
      <p>این شرکت در سال 80 در مینودشت تاسیس شد</p>
  </body>
</html>
EOF
       );
   }

}