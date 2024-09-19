<?php

namespace App\Livewire\Forms\Payroll;

use App\Models\Insentif;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;
use YorCreative\UrlShortener\Services\UrlService;

class BlastForm extends Form
{
    public $rowId = '';

    public function blast($id)
    {
        // dd($id['rowId']);
        $this->rowId = intval($id['rowId']);
        try {
            $cariInsentif = Insentif::query()
                                ->join('payroll_kehadiran', function ($kehadiran) {
                                    $kehadiran->on('payroll_kehadiran.npp_kehadiran', '=', 'payroll_insentif.npp_insentif');
                                    $kehadiran->on('payroll_kehadiran.kehadiran_periode_bulan', '=', 'payroll_insentif.insentif_periode_bulan');
                                    $kehadiran->on('payroll_kehadiran.kehadiran_pembayaran_bulan', '=', 'payroll_insentif.insentif_pembayaran_bulan');
                                    $kehadiran->on('payroll_kehadiran.kehadiran_tahun', '=', 'payroll_insentif.insentif_tahun');
                                })
                                ->select([
                                    'payroll_insentif.id as id',
                                    'payroll_insentif.npp_insentif',
                                    'payroll_insentif.nama_pegawai as nama_insentif',
                                    'payroll_insentif.no_hp as hp_insentif',
                                    'payroll_insentif.has_blast as insentif_blast',
                                    'payroll_insentif.insentif_periode_bulan',
                                    'payroll_insentif.insentif_pembayaran_bulan',
                                    'payroll_insentif.insentif_tahun',
                                    'payroll_kehadiran.id as kehadiran_id',
                                    'payroll_kehadiran.npp_kehadiran',
                                    'payroll_kehadiran.nama_pegawai as nama_kehadiran',
                                    'payroll_kehadiran.no_hp as hp_kehadiran',
                                    'payroll_kehadiran.has_blast as kehadiran_blast',
                                    'payroll_kehadiran.status_blast as kehadiran_status_blast',
                                    'payroll_kehadiran.kehadiran_periode_bulan',
                                    'payroll_kehadiran.kehadiran_pembayaran_bulan',
                                    'payroll_kehadiran.kehadiran_tahun',
                                ])
                                ->find($this->rowId);
            $idInsentif    = $cariInsentif->id;
            $idKehadiran   = $cariInsentif->kehadiran_id;
            $dataInsentif  = Insentif::find($idInsentif);
            $dataKehadiran = Kehadiran::find($idKehadiran);
            $sendBlast     = json_decode($this->sendBlast($dataInsentif, $dataKehadiran), true);
            $status        = $sendBlast['status'];
            // $status = true;
            $detail = '';
            if ($status == true) {
                $dataInsentif->has_blast    = true;
                $dataInsentif->status_blast = true;
                $dataInsentif->save();
                $dataKehadiran->has_blast    = true;
                $dataKehadiran->status_blast = true;
                $dataKehadiran->save();
                $detail = $sendBlast['detail'] . PHP_EOL.' penerima : ' . $dataInsentif->nama_pegawai . PHP_EOL.' dikirim ke : ' . $dataInsentif->no_hp;
            } else {
                $detail = $sendBlast['reason'];
            }

            return $detail;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function sendBlast($insentif, $kehadiran)
    {
        $signedUrl = URL::temporarySignedRoute('slip-blast', now()->addDays(3), ['insentif' => $insentif->id, 'kehadiran' => $kehadiran->id]);

        $shortUrl = UrlService::shorten($signedUrl)
                        ->withOpenLimit(2)
                        ->build();
        $pesan  = 'Halo sdr/i ' . $insentif->nama_pegawai . PHP_EOL;
        $pesan .= PHP_EOL . 'berikut tautan slip Tunjangan Insentif & Kehadiran: ' . PHP_EOL;
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
}
