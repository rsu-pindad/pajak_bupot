<?php

namespace App\Livewire\Forms\Payroll;

use App\Models\Insentif;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Form;
use YorCreative\UrlShortener\Services\UrlService;

class InsentifForm extends Form
{
    public $rowId = '';

    public function blast($rowId)
    {
        try {
            $cariInsentif = Insentif::find($rowId)->first();
            $sendBlast    = json_decode($this->sendBlast($cariInsentif, null, 'Insentif'), true);
            $status       = $sendBlast['status'];
            $detail       = '';
            if ($status == true) {
                $cariInsentif->has_blast    = true;
                $cariInsentif->status_blast = true;
                $cariInsentif->save();
                $detail = $sendBlast['detail'];
            } else {
                $detail = $sendBlast['reason'];
            }

            return $detail;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function bulkBlast($rowId)
    {
        try {
            $cariInsentif = Insentif::find($rowId)->first();
            $sendBlast    = json_decode($this->sendBlast($cariInsentif, null, 'Insentif'), true);
            $status       = $sendBlast['status'];
            $detail       = '';
            if ($status == true) {
                $cariInsentif->has_blast    = true;
                $cariInsentif->status_blast = true;
                $cariInsentif->save();
                $detail = $sendBlast['detail'];
            } else {
                $detail = $sendBlast['reason'];
            }

            return $detail;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function sendBlast($insentif, $personalia, $judulDokumen)
    {
        $signedUrl = URL::temporarySignedRoute('slip-insentif', now()->addDays(3), ['user' => $insentif->id]);
        $otp       = Str::random(4);

        $shortUrl = UrlService::shorten($signedUrl)
                        ->withOpenLimit(2)
                        ->build();
        $pesan  = 'Halo sdr/i ' . $insentif->nama_pegawai . PHP_EOL;
        $pesan .= PHP_EOL . 'berikut tautan slip Tunjangan ' . $judulDokumen . ': ' . PHP_EOL;
        $pesan .= PHP_EOL . $shortUrl . PHP_EOL;
        $pesan .= PHP_EOL . 'gunakan password dibawah ini untuk membuka dokumen, berlaku 3 Hari' . PHP_EOL;
        $pesan .= PHP_EOL . 'Password = NPP' . PHP_EOL;
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
                'target'      => $insentif->no_hp,
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

    public function destroy($rowId)
    {
        Insentif::where('id', $rowId)->delete();
    }

    public function restore($rowId)
    {
        Insentif::withTrashed()->where('id', $rowId)->restore();
    }

    public function permanentDestroy($rowId)
    {
        Insentif::withTrashed()->where('id', $rowId)->forceDelete();
    }
}
