<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KehadiranController extends Controller
{

    public function __construct(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
    }

    public function view(Request $request)
    {
        // echo $request->user;
    }
}
