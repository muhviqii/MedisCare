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
    <p>Dicetak: <?php echo e(now()->translatedFormat('d F Y H:i')); ?></p>
    <table>
        <thead><tr><th>No. Invoice</th><th>Pasien</th><th>Total</th><th>Dibayar</th><th>Status</th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($invoice->invoice_number); ?></td>
                    <td><?php echo e($invoice->patient->full_name); ?></td>
                    <td>Rp<?php echo e(number_format($invoice->grand_total, 0, ',', '.')); ?></td>
                    <td>Rp<?php echo e(number_format($invoice->paid_amount, 0, ',', '.')); ?></td>
                    <td><?php echo e(ucfirst($invoice->status)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <p style="margin-top: 12px; font-weight: bold;">Total: Rp<?php echo e(number_format($total, 0, ',', '.')); ?></p>
</body>
</html>
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/reports/pdf/revenue.blade.php ENDPATH**/ ?>