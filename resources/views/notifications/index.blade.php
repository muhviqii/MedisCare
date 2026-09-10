<x-layouts.app title="Notifikasi">
    <div class="flex justify-end mb-4">
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button class="text-sm text-teal-700">Tandai semua sudah dibaca</button>
        </form>
    </div>

    <div class="space-y-2">
        @forelse ($notifications as $notification)
            <div class="bg-white rounded-2xl shadow-sm p-4 {{ $notification->read_at ? 'opacity-60' : '' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800 text-sm">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @unless ($notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button class="text-xs text-teal-700">Tandai dibaca</button>
                        </form>
                    @endunless
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada notifikasi.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $notifications->links() }}</div>
</x-layouts.app>
