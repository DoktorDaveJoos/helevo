<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\VouchersExport;
use App\Imports\VouchersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VoucherExcelController extends Controller
{
    public function import(Request $request)
    {
        Excel::import(new VouchersImport(Auth::user()->id), $request->file('file'));

        return Redirect::route('dashboard');
    }

    public function export(): BinaryFileResponse
    {
        return (new VouchersExport(Auth::user()->id))->download('gutscheine.xlsx');
    }

    public function report(Request $request): BinaryFileResponse
    {
        $month = $request->get('month');
        $year = $request->get('year');

        return (new ReportExport(Auth::user()->id, $month, $year))
            ->download(
                sprintf(
                    'gutschein_report_%s_%s.xlsx',
                    $month,
                    $year
                )
            );
    }

}
