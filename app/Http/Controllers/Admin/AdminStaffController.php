<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminStaffController extends Controller
{
    public function index(): View
    {
        $staff = User::query()
            ->whereIn('role', ['admin', 'super_admin'])
            ->orderByRaw("CASE role WHEN 'super_admin' THEN 0 ELSE 1 END")
            ->orderBy('name')
            ->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile_no' => ['required', 'string', 'max:30', 'regex:/^[\d\+\-\s()]+$/'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:admin,super_admin'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile_no' => $validated['mobile_no'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff account created.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if (! in_array($user->role, ['admin', 'super_admin'], true)) {
            abort(404);
        }

        if ($user->id === $request->user()->id) {
            return redirect()
                ->route('admin.staff.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin() && User::query()->where('role', 'super_admin')->count() <= 1) {
            return redirect()
                ->route('admin.staff.index')
                ->with('error', 'Cannot delete the last super administrator.');
        }

        $user->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff account removed.');
    }
}
