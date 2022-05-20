<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return new Response(<<<EOF
<html>
    <body>
       <p>نام شرکت :شرکت گردشگری آدرینا</p>
       <p>هدف شرکت نمایش بهترین نقاط گردشگری شهر مینودشت</p>
   </body>
</html>
EOF
        );
    }
}