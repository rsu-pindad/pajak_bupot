<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function __invoke(Request $request)
    {
        switch ($request->jenis) {
            case 'insentif':
                return $this->insentif();
                break;
            case 'kehadiran':
                return $this->kehadiran();
                break;
            case 'personalia':
                return $this->personalia();
                break;
            default:
                return false;
                break;
        }
    }

    public function insentif()
    {
        $pathFile = Storage::disk('public')->path('template_slip/Template_Insentif.xlsx');
        return response()->download($pathFile);
    }

    public function kehadiran()
    {
        $pathFile = Storage::disk('public')->path('template_slip/Template_Kehadiran.xlsx');
        return response()->download($pathFile);
    }

    public function personalia()
    {
        $pathFile = Storage::disk('public')->path('template_slip/Template_Personalia.xlsx');
        return response()->download($pathFile);
    }
}
