<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/html2pdf.bundle.min.js')); ?>"></script>
<?php if(auth()->guard('web')->check()): ?>
    <?php $url = route('invoices.show',[$currentWorkspace->slug,$invoice->id]); ?>
<?php elseif(auth()->guard()->check()): ?>
    <?php $url = route('client.invoices.show',[$currentWorkspace->slug,$invoice->id]); ?>
<?php endif; ?>
<script>
    'use strict';

    function closeScript() {
        setTimeout(function () {
            window.location.href = '<?php echo e($url); ?>';
        }, 1000);
    }

    $(window).on('load', function () {
        var element = document.getElementById('boxes');
        var opt = {
            filename: '<?php echo e(Utility::invoiceNumberFormat($invoice->invoice_id)); ?>',
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A4'}
        };
        html2pdf().set(opt).from(element).save().then(closeScript);
    });
</script>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/invoices/script.blade.php ENDPATH**/ ?>