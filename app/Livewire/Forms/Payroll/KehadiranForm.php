<?php

namespace App\Livewire\Forms\Payroll;

use App\Http\Controllers\KehadiranController;
use App\Models\Kehadiran;
use App\Models\Personalia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Form;
use YorCreative\UrlShortener\Services\UrlService;

class KehadiranForm extends Form
{
    public $rowId = '';

    public function blast($rowId)
    {
        try {
            $cariKehadiran  = Kehadiran::find($rowId)->first();
            $cariPersonalia = Personalia::where('npp', $cariKehadiran->npp_kehadiran)->first();
            $sendBlast      = json_decode($this->sendBlast($cariKehadiran, $cariPersonalia), true);
            // "{
            // "detail":"success! message in queue",
            // "id":["57481122"],
            // "process":"processing",
            // "status":true,
            // "target":["62818831140"]
            // }
            $status = $sendBlast['status'];
            $detail = $sendBlast['detail'];

            // if ($status == true) {
            //     // $cariKehadiran->has_blast    = true;
            //     // $cariKehadiran->status_blast = true;
            //     // $cariKehadiran->save();
            // }
            return $detail;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function bulkBlast($rowId)
    {
        try {
            $cariKehadiran  = Kehadiran::find($rowId)->first();
            $cariPersonalia = Personalia::where('npp', $cariKehadiran->npp_kehadiran)->first();
            $sendBlast      = json_decode($this->sendBlast($cariKehadiran, $cariPersonalia), true);
            $status         = $sendBlast['status'];
            $detail         = $sendBlast['detail'];
            if ($status == true) {
                // $cariKehadiran->has_blast    = true;
                // $cariKehadiran->status_blast = true;
                // $cariKehadiran->save();
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function destroy($rowId)
    {
        Kehadiran::where('id', $rowId)->delete();
    }

    public function restore($rowId)
    {
        Kehadiran::withTrashed()->where('id', $rowId)->restore();
    }

    public function permanentDestroy($rowId)
    {
        Kehadiran::withTrashed()->where('id', $rowId)->forceDelete();
    }

    private function sendBlast($kehadiran, $personalia)
    {
        // $url = action([KehadiranController::class, 'slip-kehadiran'],['user' => $kehadiran->id]);
        $signedUrl = URL::temporarySignedRoute('slip-kehadiran', now()->addDays(3), ['user' => $kehadiran->id]);
        $otp       = Str::random(4);

        $shortUrl = UrlService::shorten($signedUrl)
        ->withOpenLimit(2)
        ->build();
        $pesan = 'Halo sdr/i ' . $kehadiran['nama_pegawai'] . ' berikut slip Tunjangan Kehadiran: ' . PHP_EOL;
        // $pesan .= $url.PHP_EOL;
        $pesan .= PHP_EOL . $shortUrl . PHP_EOL;
        $pesan .= PHP_EOL . 'gunakan otp dibawah untuk membuka dokumen, berlaku 10 menit' . PHP_EOL;
        $pesan .= PHP_EOL . 'OTP : ' . $otp . PHP_EOL;
        $pesan .= PHP_EOL . 'Terimakasih' . PHP_EOL;
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
                'target'      => $personalia['no_hp'],
                'message'     => $pesan,
                'delay'       => '5',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: C6#6WZUo4NAza-dLJHwt'
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
