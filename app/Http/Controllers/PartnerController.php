<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PartnerController extends Controller
{
    public function index(Request $request): JsonResponse | View
    {
        $partners = Partner::all();

        if ($request->wantsJson()) {
            return response()->json($partners, Response::HTTP_OK);
        }

        return view('dashboard.partners.index', compact('partners'));
    }

    public function store(Request $request): JsonResponse | RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data = $request->all();
        $data['logo'] = $data['logo'] ?? $this->getDefaultLogo();
        $partner = Partner::create($data);

        if ($request->wantsJson()) {
            return response()->json($partner, Response::HTTP_CREATED);
        }

        return redirect()->route('dashboard.partners.create')->with('success', 'Partner created successfully');
    }

    public function create(): View
    {
        return view('dashboard.partners.create');
    }

    public function show($id): JsonResponse | View
    {
        $partner = Partner::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($partner);
        }

        return view('dashboard.partners.show', compact('partner'));
    }

    public function edit($id): View
    {
        $partner = Partner::findOrFail($id);
        return view('dashboard.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id): JsonResponse | RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $partner = Partner::findOrFail($id);
        $data = $request->all();
        $data['logo'] = $data['logo'] ?? $partner->logo ?? $this->getDefaultLogo();
        $partner->update($data);

        if ($request->wantsJson()) {
            return response()->json($partner);
        }

        return redirect()->route('dashboard.partners.edit', $partner->id)->with('success', 'Partner updated successfully');
    }

    public function destroy($id): JsonResponse | RedirectResponse
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        if (request()->wantsJson()) {
            return response()->json(null, Response::HTTP_NO_CONTENT);
        }

        return redirect()->route('dashboard.partners.index')->with('success', 'Partner deleted successfully');
    }

    private function getDefaultLogo(): string
    {
        $defaultLogos = config('partners_data.default_logos');
        return $defaultLogos[array_rand($defaultLogos)];
    }
}
