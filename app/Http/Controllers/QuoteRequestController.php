<?php

namespace App\Http\Controllers;

use App\Actions\SendQuoteRequest;
use App\Http\Requests\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class QuoteRequestController extends Controller
{
    public function store(QuoteRequest $request, SendQuoteRequest $sendQuoteRequest): RedirectResponse
    {
        if ($request->isSpam()) {
            Inertia::flash('quote', ['status' => 'success']);

            return back();
        }

        $sent = $sendQuoteRequest->handle($request->quoteData());

        Inertia::flash('quote', ['status' => $sent ? 'success' : 'error']);

        return back();
    }
}
