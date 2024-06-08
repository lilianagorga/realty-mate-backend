<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): Response
    {
//        $user = User::create($request->validated());
        $user = User::create(array_merge(
            $request->validated(),
            [
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]
        ));

        return response($user, Response::HTTP_CREATED);
    }
}
