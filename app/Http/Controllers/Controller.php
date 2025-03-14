<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;

abstract class Controller
{
    public function __construct(protected ResponseFactory $responseFactory)
    {
    }
}
