<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0fdfa; }
        h1 { font-size: 16px; }
    </style>
</head>
<body>
    <h1>MedisCare — Laporan Pendapatan</h1>
    <p>Dicetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
    <table>
        <thead><tr><th>No. Invoice</th><th>Pasien</th><th>Total</th><th>Dibayar</th><th>Status</th></tr></thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->patient->full_name }}</td>
                    <td>Rp{{ number_format($invoice->grand_total, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($invoice->paid_amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($invoice->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top: 12px; font-weight: bold;">Total: Rp{{ number_format($total, 0, ',', '.') }}</p>
</body>
</html>
