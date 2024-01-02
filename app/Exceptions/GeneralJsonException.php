<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralJsonException extends Exception
{
    protected $code = 422;

    public function report()
    {
        // Todo: Notification logic here such as email, loggig, etc.
        //dump('Error encountered');
    }

    public function render($request)
    {
        return new JsonResponse([
            'errors' => [
                'message' => $this->getMessage(),
            ],
        ], $this->code);
    }
}
