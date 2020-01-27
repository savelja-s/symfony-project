<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class TestPageController
{
    /**
     * @return Response
     * @throws \Exception
     */
    public function index()
    {
        $dateTime = (new \DateTime())->format('Y-m-d H:i:s');

        return new Response(
            '<html><body><h1>Current time: '.$dateTime.'</h1><div>'."\n".'<'.phpinfo().'</div></body></html>'
        );
    }
}