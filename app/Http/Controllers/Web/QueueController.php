<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Polyclinic;
use App\Models\Queue;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QueueController extends Controller
{
    public function __construct(private readonly AuditLogService $audit)
    {
    }

    /**
     * Dashboard antrean (Bagian 11): nomor saat ini, berikutnya, dan daftar menunggu per poli.
     */
    public function index(Request $request): View
    {
        $polyclinicId = $request->integer('polyclinic_id') ?: null;
        $polyclinics = Polyclinic::where('is_active', true)->orderBy('name')->get();

        $baseQuery = Queue::query()
            ->with(['appointment.patient', 'polyclinic'])
            ->whereDate('queue_date', now())
            ->when($polyclinicId, fn ($q) => $q->where('polyclinic_id', $polyclinicId));

        $current = (clone $baseQuery)->where('status', 'called')->latest('called_at')->first();
        $waiting = (clone $baseQuery)->where('status', 'waiting')->orderBy('queue_number')->get();
        $completedCount = (clone $baseQuery)->where('status', 'completed')->count();

        return view('queue.index', compact('polyclinics', 'polyclinicId', 'current', 'waiting', 'completedCount'));
    }

    public function call(Queue $queue): RedirectResponse
    {
        $queue->update(['status' => 'called', 'called_at' => now()]);
        $this->audit->log('Called Queue', 'queues', $queue->id);

        return back()->with('status', "Memanggil antrean {$queue->queue_number}.");
    }

    public function skip(Queue $queue): RedirectResponse
    {
        $queue->update(['status' => 'skipped']);
        $this->audit->log('Skipped Queue', 'queues', $queue->id);

        return back()->with('status', "Antrean {$queue->queue_number} dilewati.");
    }

    public function recall(Queue $queue): RedirectResponse
    {
        $queue->update(['status' => 'called', 'called_at' => now()]);
        $this->audit->log('Recalled Queue', 'queues', $queue->id);

        return back()->with('status', "Memanggil ulang antrean {$queue->queue_number}.");
    }

    public function complete(Queue $queue): RedirectResponse
    {
        $queue->update(['status' => 'completed', 'completed_at' => now()]);
        $queue->appointment()->update(['status' => 'completed']);
        $this->audit->log('Completed Queue', 'queues', $queue->id);

        return back()->with('status', "Antrean {$queue->queue_number} selesai dilayani.");
    }
}
