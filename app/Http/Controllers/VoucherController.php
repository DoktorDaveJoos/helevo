<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $voucher = new Voucher();
        $voucher->code = 'HM-' . strtoupper(Str::random(5));
        $voucher->amount = $request->amount;
        $voucher->paid_on = $request->paid ? Carbon::now()->toDateString() : null;
        $voucher->user_id = auth()->user()->id;
        $voucher->save();

        return $this->renderPage($request);
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

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function update(int $id, Request $request): Response
    {
        $voucher = Voucher::find($id);

        if ($request->has('cashed')) {

            if ($request->cashed) {
                if ($voucher->paid_on == null) {
                    return $this->renderPage($request, [
                        'topic' => 'Einlöse',
                        'message' => 'Gutschein kann nicht eingelöst werden, da er nicht bezahlt wurde.',
                    ]);
                }
                $voucher->cashed_on = Carbon::now()->toDateTimeString();
            } else {
                $voucher->cashed_on = null;
            }

            $voucher->save();

            return $this->renderPage($request);
        }

        $voucher->amount = $request->amount;

        if (!$request->paid && $voucher->paid_on != null) {
            $voucher->paid_on = null;
        }

        if ($request->paid && $voucher->paid_on == null) {
            $voucher->paid_on = Carbon::now()->toDateTimeString();
        }
        $voucher->save();

        return $this->renderPage($request);
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
