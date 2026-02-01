<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Website Partai API Documentation",
    version: "1.0.0",
    description: "Dokumentasi API untuk Website Partai",
    contact: new OA\Contact(email: "admin@partai.com")
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: "API Server"
)]
abstract class Controller
{
    //
}


