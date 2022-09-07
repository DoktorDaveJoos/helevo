<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Exports\VouchersExport;
use App\Http\Requests\VoucherCashRequest;
use App\Http\Requests\VoucherCreateRequest;
use App\Imports\VouchersImport;
use App\Models\Voucher;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VoucherController extends Controller
{
    private const PER_PAGE = 20;


    public function index(?Request $request): RedirectResponse|Response
    {
        $vouchersQuery = auth()->user()->vouchers();

        if ($request->has('search')) {
            $vouchersQuery->where('code', '=', $request->search);
        }

        $vouchers = $vouchersQuery->paginate(self::PER_PAGE);

        if ($vouchers->isEmpty() && $request->has('search')) {
            $vouchers = auth()->user()->vouchers()->paginate(self::PER_PAGE);

            return Redirect::route('dashboard')->withErrors(
                ['Suche' => sprintf('Kein Gutschein mit Code "%s" gefunden', $request->search)],
                'notification'
            );
        }

        $data = [
            'vouchers' => $vouchers,
        ];

        return Inertia::render('Dashboard', $data);
    }

    public function create(VoucherCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $prefix = Auth::user()->prefix ? sprintf('%s-', Auth::user()->prefix) : null;

        $voucher = new Voucher();
        $voucher->code = $prefix . strtoupper(Str::random(5));

        $voucher->paid_on = $validated['paid'] ? Carbon::now()->toDateString() : null;
        $voucher->user_id = auth()->user()->id;
        $voucher->save();

        $voucher->amountHistory()->create([
            'amount' => $validated['amount'],
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
            'amount' => $voucher->getActualAmount() - $validated['amount'],
        ]);

        if ($voucher->getActualAmount() == 0) {
            $voucher->cashed_on = Carbon::now()->toDateTimeString();
            $voucher->save();
        }

        return Redirect::route('dashboard', $request->query->all());
    }

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

    public function print(Voucher $voucher)
    {

        $user = Auth::user();
        $logo = $user->logo_path ? 'app/' . $user->logo_path : 'app/logos/helevo-base-logo.png';

        return Pdf::loadHTML(Blade::Render('pdf/voucher', [
            'logo' => $logo,
            'company' => $user->name,
            'text' => $user->welcome_text,
            'code' => $voucher->code,
            'amount' => $voucher->getActualAmount()
        ]))->setPaper('a4')
            ->download(sprintf('Gutschein-%s.pdf', $voucher->code));
    }
}
