<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function sendContactEmail(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'message' => 'required|string',
                'gdpr' => 'required|accepted',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        }

        $contactData = $request->only('name', 'email', 'phone', 'message');

        Mail::to('support@realtymate.com')->send(new ContactMail($contactData));

        return response()->json(['message' => 'Message sent successfully']);
    }
}
