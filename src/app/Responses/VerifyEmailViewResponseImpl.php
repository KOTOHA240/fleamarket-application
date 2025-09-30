<?php

namespace App\Responses;

use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class VerifyEmailViewResponseImpl implements VerifyEmailViewResponse
{
    public function toResponse($request)
    {
        return response()->view('auth.verify-email');
    }
}
