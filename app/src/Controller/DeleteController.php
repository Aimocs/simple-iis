<?php

namespace Aimocs\Iis\Controller;

use Aimocs\Iis\Flat\Database\Database;
use Aimocs\Iis\Flat\Http\Response;

class DeleteController
{
    public function __construct(
        private Database $database
    )
    {
    }

    public function delete(int $id,string $table):Response
    {
        $response = $this->database->Delete($table,"id",[$id]);

        $response= new Response();
        $response->setStatus(200);
        return $response;
    }

}