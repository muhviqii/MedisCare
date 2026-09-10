<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrescriptionListController extends Controller
{
    public function index(Request $request): View
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'items.medication'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('pharmacy.prescriptions.index', compact('prescriptions'));
    }
}
