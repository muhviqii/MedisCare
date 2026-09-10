<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Models\Bed;
use App\Models\Room;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    /**
     * Dashboard visual kamar & bed (Bagian 15): jumlah available/occupied/cleaning/maintenance.
     */
    public function index(Request $request): View
    {
        $summary = Bed::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        $rooms = Room::with('beds')
            ->when($request->filled('room_class'), fn ($q) => $q->where('room_class', $request->string('room_class')))
            ->orderBy('building')->orderBy('floor')->orderBy('room_number')
            ->paginate(20)
            ->withQueryString();

        return view('rooms.index', compact('rooms', 'summary'));
    }

    public function create(): View
    {
        return view('rooms.create');
    }

    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $bedCount = $validated['bed_count'];
        unset($validated['bed_count']);

        $room = Room::create([...$validated, 'is_active' => true]);

        for ($i = 1; $i <= $bedCount; $i++) {
            $room->beds()->create([
                'bed_number' => str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'status' => 'available',
            ]);
        }

        $this->audit->log('Created Room', 'rooms', $room->id);

        return redirect()->route('rooms.index')->with('status', 'Ruangan & bed berhasil ditambahkan.');
    }

    /**
     * Update status bed manual (mis. selesai dibersihkan -> available; Bagian 15).
     */
    public function updateBedStatus(Request $request, Bed $bed): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:available,occupied,cleaning,maintenance'],
        ]);

        $bed->update($validated);
        $this->audit->log('Updated Bed Status', 'beds', $bed->id);

        return back()->with('status', "Status bed {$bed->bed_number} diperbarui menjadi ".ucfirst($validated['status']).'.');
    }
}
