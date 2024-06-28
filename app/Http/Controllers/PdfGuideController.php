<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PdfGuideMail;
use Dompdf\Options;

class PdfGuideController extends Controller
{
    public function sendGuide(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'gdpr' => 'required|accepted',
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $html = view('pdf.guide')->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $pdf = $dompdf->output();

        Mail::to($request->email)->send(new PdfGuideMail($pdf, $request->name));

        return response()->json(['message' => 'PDF Guide sent successfully']);
    }
}
