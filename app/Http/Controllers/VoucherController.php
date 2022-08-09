<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherCashRequest;
use App\Http\Requests\VoucherCreateRequest;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class VoucherController extends Controller
{
    private const PAGES = 20;

    /**
     * Display a listing of the resource.
     *
     */
    public function index(?Request $request): Response
    {
        return $this->renderPage($request);
    }

    private function renderPage(Request $request, ?array $notification = null): Response
    {
        $vouchersQuery = auth()->user()->vouchers();

        if ($request->has('search')) {
            $vouchersQuery->where('code', '=', $request->search);
        }

        $vouchers = $vouchersQuery->paginate(self::PAGES);

        if ($vouchers->isEmpty() && $request->has('search')) {
            $vouchers = auth()->user()->vouchers()->paginate(self::PAGES);

            $notification = [
                'topic' => 'Suche',
                'message' => sprintf('Kein Ergebnis für "%s" gefunden', $request->search),
            ];
        }

        $data = [
            'vouchers' => $vouchers,
        ];

        if ($notification) {
            $data['notification'] = $notification;
        }

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
        $voucher->amount = $validated['amount'];
        $voucher->paid_on = $validated['paid'] ? Carbon::now()->toDateString() : null;
        $voucher->user_id = auth()->user()->id;
        $voucher->save();

        return Redirect::route('dashboard', $request->query->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    public function cash(int $id, VoucherCashRequest $request)
    {
        $voucher = Voucher::find($id);

        if ($voucher->paid_on == null) {
            return Redirect::route('dashboard', $request->query->all())
                ->withErrors(
                    ['Gutschein' => 'Gutschein kann nicht eingelöst werden, da er nicht bezahlt wurde'],
                    'notification'
                );
        }

        $validated = $request->validated();

        $voucher->cashed_on = $validated['cashed'] ? Carbon::now()->toDateTimeString() : null;
        $voucher->save();

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

        $voucher->amount = $validated['amount'];

        if (!$validated['paid']) {
            $voucher->paid_on = null;
        } elseif ($voucher->paid_on === null) {
            $voucher->paid_on = Carbon::now()->toDateTimeString();
        }

        $voucher->save();

        return Redirect::route('dashboard', $request->query->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
