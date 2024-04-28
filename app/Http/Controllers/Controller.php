<?php

namespace App\Http\Controllers;

/**
     * @OA\OpenApi(
     *     @OA\Info(
     *         version="1.0",
     *         title="CMS (Content Management System) Api",
     *         description="The application is a simple repository to manage posts with their respective titles, authors, content and tags.",
     *          contact={
     *          "email": "jose-carlos64@live.com"
     *   }
     *     )
     * )
     *
     * @OA\SecurityScheme(
     *  type="http",
     *  description="Access token obtido na autenticação",
     *  name="Authorization",
     *  in="header",
     *  scheme="bearer",
     *  bearerFormat="JWT",
     *  securityScheme="bearerToken"
     * )
     */
    //

abstract class Controller
{

}
