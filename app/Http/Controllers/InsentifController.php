<?php

namespace App\Http\Controllers;

use App\Models\Insentif;
use App\Models\Personalia;
use DevRaeph\PDFPasswordProtect\Facade\PDFPasswordProtect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;

use function Spatie\LaravelPdf\Support\pdf;

class InsentifController extends Controller
{
    public function __construct(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
    }

    public function __invoke(Request $request)
    {
        $dataInsentif = Insentif::select()
                            ->where('npp_insentif', Auth::user()->npp)
                            ->where('insentif_pembayaran_bulan', $request->bulan)
                            ->where('insentif_tahun', $request->tahun)
                            ->first();
        $dataPersonalia = Personalia::where('npp', Auth::user()->npp);

        if (!$dataInsentif) {
            return false;
        }
        $randomPassword = Str::random(4);
        // $sendOtp        = json_decode($this->sendOtp($dataInsentif, $randomPassword), true);
        // $status         = $sendOtp['status'];
        $status = true;
        if ($status == true) {
            $dataInsentif->has_blast    = true;
            $dataInsentif->status_blast = true;
            $dataInsentif->save();

            $pdfName = $dataInsentif->npp_insentif . '.pdf';

            $pdf = pdf()
                       ->view('slip-insentif', ['insentif' => $dataInsentif, 'personalia' => $dataPersonalia])
                       ->orientation(Orientation::Landscape)
                       ->format(Format::A5)
                       ->margins(2, 2, 2, 2)
                       ->disk('public')
                       ->save($pdfName);

            PDFPasswordProtect::setInputFile($pdfName, 'public')
                ->setOutputFile('slip_insentif/' . $pdfName, 'public')
                ->setFormat('A5')
                ->setOwnerPassword(config('app.PDF_OWNER_PASSWORD'))
                // ->setPassword($randomPassword)
                ->setPassword($request->otp)
                ->secure();
            Storage::disk('public')->delete($pdfName);
            $pathFile = Storage::disk('public')->path('slip_insentif/' . $pdfName);

            return response()->file($pathFile)->deleteFileAfterSend();
        } else {
            return $sendOtp['reason'];
        }
    }

    public function view(Request $request)
    {
        $dataInsentif   = Insentif::find($request->user);
        $dataPersonalia = Personalia::where('npp', $dataInsentif->npp);
        $randomText     = Str::random(4);
        $pdfName        = $dataInsentif->npp_insentif . '_';
        $pdfName       .= $dataInsentif->kehadiran_bulan . '_';
        $pdfName       .= $dataInsentif->kehadiran_tahun . '_';
        $pdfName       .= $randomText . '.pdf';
        $pdf            = pdf()
                              ->view('slip-insentif', ['insentif' => $dataInsentif, 'personalia' => $dataPersonalia])
                              ->orientation(Orientation::Landscape)
                              ->format(Format::A5)
                              ->margins(2, 2, 2, 2)
                              ->disk('public')
                              ->save($pdfName);

        PDFPasswordProtect::setInputFile($pdfName, 'public')
            ->setOutputFile('slip_insentif/' . $pdfName, 'public')
            ->setFormat('A5')
            ->setOwnerPassword(config('app.PDF_OWNER_PASSWORD'))
            ->setPassword($dataInsentif->npp_insentif)
            ->secure();
        Storage::disk('public')->delete($pdfName);

        $pathFile = Storage::disk('public')->path('slip_insentif/' . $pdfName);

        return response()->download($pathFile)->deleteFileAfterSend();
    }

    private function sendOtp($dataInsentif, $randomPassword)
    {
        $pesan  = 'Halo sdr/i ' . $dataInsentif->nama_pegawai . PHP_EOL;
        $pesan .= PHP_EOL . 'gunakan password dibawah ini untuk membuka dokumen' . PHP_EOL;
        $pesan .= PHP_EOL . 'Password : ' . $randomPassword . PHP_EOL;
        $pesan .= PHP_EOL . 'Terimakasih' . PHP_EOL;
        $pesan .= PHP_EOL . '' . PHP_EOL;
        $pesan .= PHP_EOL . '* disarankan membuka tautan diatas menggunakan chrome' . PHP_EOL;
        $pesan .= PHP_EOL . '* kertas berukuran A5' . PHP_EOL;
        $curl   = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target'      => $dataInsentif->no_hp,
                'message'     => $pesan,
                'delay'       => '15',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . config('app.FONNTE')
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return $error_msg;
        }

        return $response;
    }
}
