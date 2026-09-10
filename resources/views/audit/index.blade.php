<x-layouts.app title="Audit Log">
    <form method="GET" class="flex gap-2 flex-wrap mb-4">
        <input type="text" name="module" value="{{ request('module') }}" placeholder="Modul (mis. patients)" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="from" value="{{ request('from') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="to" value="{{ request('to') }}" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Waktu</th><th class="text-left px-4 py-3">User</th><th class="text-left px-4 py-3">Role</th><th class="text-left px-4 py-3">Aksi</th><th class="text-left px-4 py-3">Modul</th><th class="text-left px-4 py-3">IP</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($logs as $log)
                    <tr>
                        <td class="px-4 py-3 text-slate-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $log->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $log->role_snapshot }}</td>
                        <td class="px-4 py-3">{{ $log->action }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $log->module }}{{ $log->record_id ? " #{$log->record_id}" : '' }}</td>
                        <td class="px-4 py-3 text-slate-400 text-xs">{{ $log->ip_address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
</x-layouts.app>
