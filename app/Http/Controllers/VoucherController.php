<?php

namespace App\Http\Controllers;

use App\Exports\VouchersExport;
use App\Http\Requests\VoucherCashRequest;
use App\Http\Requests\VoucherCreateRequest;
use App\Imports\VouchersImport;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VoucherController extends Controller
{
    private const PAGES = 20;

    /**
     * Display a listing of the resource.
     *
     */
    public function index(?Request $request): RedirectResponse | Response
    {
        $vouchersQuery = auth()->user()->vouchers();

        if ($request->has('search')) {
            $vouchersQuery->where('code', '=', $request->search);
        }

        $vouchers = $vouchersQuery->paginate(self::PAGES);

        if ($vouchers->isEmpty() && $request->has('search')) {
            $vouchers = auth()->user()->vouchers()->paginate(self::PAGES);

            return Redirect::route('dashboard')->withErrors(
                ['Suche' =>  sprintf('Kein Gutschein mit Code "%s" gefunden', $request->search)],
                'notification'
            );
        }

        $data = [
            'vouchers' => $vouchers,
        ];

        return Inertia::render('Dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param VoucherCreateRequest $request
     * @return RedirectResponse
     */
    public function create(VoucherCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $voucher = new Voucher();
        $voucher->code = 'HM-' . strtoupper(Str::random(5));

        $voucher->paid_on = $validated['paid'] ? Carbon::now()->toDateString() : null;
        $voucher->user_id = auth()->user()->id;
        $voucher->save();

        $voucher->amountHistory()->create([
            'amount' => $validated['amount']
        ]);

        return Redirect::route('dashboard', $request->query->all());
    }

    public function cash(int $id, VoucherCashRequest $request): RedirectResponse
    {
        /** @var Voucher $voucher */
        $voucher = Voucher::find($id);

        if ($voucher->paid_on == null) {
            return Redirect::route('dashboard', $request->query->all())
                ->withErrors(
                    ['Gutschein' => 'Gutschein kann nicht eingelöst werden, da er nicht bezahlt wurde'],
                    'notification'
                );
        }

        $validated = $request->validated();

        $voucher->amountHistory()->create([
            'amount' => $voucher->getActualAmount() - $validated['amount']
        ]);

        if ($voucher->getActualAmount() == 0) {
            $voucher->cashed_on = Carbon::now()->toDateTimeString();
            $voucher->save();
        }

        return Redirect::route('dashboard', $request->query->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param VoucherCreateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, VoucherCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $voucher = Voucher::find($id);

        $amountEntry = $voucher->amountHistory()->first();
        $amountEntry->amount = $validated['amount'];
        $amountEntry->save();

        if (!$validated['paid']) {
            $voucher->paid_on = null;
        } elseif ($voucher->paid_on === null) {
            $voucher->paid_on = Carbon::now()->toDateTimeString();
        }

        $voucher->save();

        return Redirect::route('dashboard', $request->query->all());
    }

    public function export(): BinaryFileResponse
    {
        return (new VouchersExport(Auth::user()->id))->download('gutscheine.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new VouchersImport(Auth::user()->id), $request->file('file'));

        return Redirect::route('dashboard');
    }
}
