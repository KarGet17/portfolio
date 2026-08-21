<?php

namespace App\Http\Controllers;

use App\Models\CleaningRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CleaningRequestController extends Controller
{
    public function dashboard(): Response
    {
        return Inertia::render('Dashboard', [
            'requests' => CleaningRequest::query()
                ->latest()
                ->get()
                ->map(fn (CleaningRequest $request): array => [
                    'id' => $request->id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'service' => $request->service,
                    'address' => $request->address,
                    'message' => $request->message,
                    'created_at' => $request->created_at?->format('d.m.Y H:i'),
                ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'service' => ['required', 'string', 'max:120'],
            'address' => ['nullable', 'string', 'max:200'],
            'message' => ['nullable', 'string', 'max:1200'],
        ]);

        CleaningRequest::create($validated);

        return back()->with('success', 'Заявка отправлена. Мы свяжемся с вами в ближайшее время.');
    }

    public function destroy(CleaningRequest $cleaningRequest): RedirectResponse
    {
        $cleaningRequest->delete();

        return back()->with('success', 'Заявка удалена.');
    }
}
