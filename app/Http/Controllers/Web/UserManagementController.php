<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Modul Manajemen Pengguna (Bagian 3 & 32). Hanya untuk Super Admin/Admin RS
 * yang memiliki permission 'users.manage'.
 */
class UserManagementController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    public function index(Request $request): View
    {
        $users = User::with('role')
            ->when($request->filled('role_id'), fn ($q) => $q->where('role_id', $request->integer('role_id')))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $roles = Role::orderBy('name')->get();

        return view('users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->audit->log('Created User', 'users', $user->id);

        return redirect()->route('users.index')->with('status', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        $this->audit->log('Updated User', 'users', $user->id);

        return redirect()->route('users.index')->with('status', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->update(['is_active' => false]);
        $user->delete();

        $this->audit->log('Deactivated User', 'users', $user->id);

        return redirect()->route('users.index')->with('status', 'Pengguna dinonaktifkan.');
    }
}
