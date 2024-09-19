<?php

namespace App\Http\Controllers;

use App\Models\Insentif;
use App\Models\Kehadiran;
use App\Models\Personalia;
use DevRaeph\PDFPasswordProtect\Facade\PDFPasswordProtect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;

use function Spatie\LaravelPdf\Support\pdf;

class BlastController extends Controller
{
    public function __construct(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
    }

    public function __invoke(Request $request)
    {
        $dataInsentif  = Insentif::find($request->insentif);
        $dataKehadiran = Kehadiran::find($request->kehadiran);
        $randomText    = Str::random(4);
        $pdfName       = $dataInsentif->npp_insentif . '_';
        $pdfName      .= $dataInsentif->kehadiran_bulan . '_';
        $pdfName      .= $dataInsentif->kehadiran_tahun . '_';
        $pdfName      .= $randomText . '.pdf';
        $pdf           = pdf()
                             ->view('slip-blast', ['insentif' => $dataInsentif, 'kehadiran' => $dataKehadiran])
                             ->orientation(Orientation::Landscape)
                             ->format(Format::A5)
                             ->margins(2, 2, 2, 2)
                             ->disk('public')
                             ->save($pdfName);

        PDFPasswordProtect::setInputFile($pdfName, 'public')
            ->setOutputFile('slip_blast/' . $pdfName, 'public')
            ->setFormat('A5')
            ->setOwnerPassword(config('app.PDF_OWNER_PASSWORD'))
            ->setPassword($dataInsentif->npp_insentif)
            ->secure();
        Storage::disk('public')->delete($pdfName);

        $pathFile = Storage::disk('public')->path('slip_blast/' . $pdfName);

        return response()->download($pathFile)->deleteFileAfterSend();
    }
}
