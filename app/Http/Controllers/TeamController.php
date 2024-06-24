<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $teams = Team::all();

        if ($request->wantsJson()) {
            return response()->json($teams);
        }

        return view('dashboard.teams.index', compact('teams'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'list' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['cover'] = $data['cover'] ?? '/images/customer/default.jpg';
        $data['icon'] = $data['icon'] ?? json_encode([
            '<i class="fa-brands fa-facebook-f"></i>',
            '<i class="fa-brands fa-linkedin"></i>',
            '<i class="fa-brands fa-twitter"></i>',
            '<i class="fa-brands fa-instagram"></i>'
        ]);
        $team = Team::create($data);

        if ($request->wantsJson()) {
            return response()->json($team, 201);
        }

        return redirect()->route('dashboard.teams.index')->with('success', 'Team created successfully');
    }

    public function create(): View
    {
        return view('dashboard.teams.create');
    }

    public function show($id): JsonResponse|View
    {
        $team = Team::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($team);
        }

        return view('dashboard.teams.show', compact('team'));
    }

    public function edit($id): View
    {
        $team = Team::findOrFail($id);
        return view('dashboard.teams.edit', compact('team'));
    }

    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'list' => 'nullable|integer',
        ]);

        $team = Team::findOrFail($id);
        $data = $request->all();
        $data['cover'] = $data['cover'] ?? '/images/customer/default.jpg';
        $data['icon'] = $data['icon'] ?? json_encode([
            '<i class="fa-brands fa-facebook-f"></i>',
            '<i class="fa-brands fa-linkedin"></i>',
            '<i class="fa-brands fa-twitter"></i>',
            '<i class="fa-brands fa-instagram"></i>'
        ]);
        $team->update($data);

        if ($request->wantsJson()) {
            return response()->json($team);
        }

        return redirect()->route('dashboard.teams.index')->with('success', 'Team updated successfully');
    }

    public function destroy($id): JsonResponse|RedirectResponse
    {
        $team = Team::findOrFail($id);
        $team->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('dashboard.teams.index')->with('success', 'Team deleted successfully');
    }
}
