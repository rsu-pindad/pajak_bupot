<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Personalia;
use DevRaeph\PDFPasswordProtect\Facade\PDFPasswordProtect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;

use function Spatie\LaravelPdf\Support\pdf;

class KehadiranController extends Controller
{
    public function __construct(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
    }

    public function view(Request $request)
    {
        $dataKehadiran  = Kehadiran::find($request->user);
        $dataPersonalia = Personalia::where('npp', $dataKehadiran->npp);
        $randomText     = Str::random(4);
        $pdfName        = $dataKehadiran->npp_kehadiran . '_';
        $pdfName       .= $dataKehadiran->kehadiran_bulan . '_';
        $pdfName       .= $dataKehadiran->kehadiran_tahun . '_';
        $pdfName       .= $randomText . 'pdf';
        $pdf            = pdf()
                              ->view('slip-kehadiran', ['kehadiran' => $dataKehadiran, 'personalia' => $dataPersonalia])
                              ->orientation(Orientation::Landscape)
                              ->format(Format::A5)
                              ->margins(2, 2, 2, 2)
                              ->disk('public')
                              ->save($pdfName);

        PDFPasswordProtect::setInputFile($pdfName, 'public')
            ->setOutputFile('slip_kehadiran/' . $pdfName, 'public')
            ->setFormat('A5')
            ->setOwnerPassword('RSUPINDAD2024')
            ->setPassword('1234')
            ->secure();
        Storage::disk('public')->delete($pdfName);

        return Storage::disk('public')->download('slip_kehadiran/' . $pdfName);
    }
}
