<?php $__env->startSection('page-title'); ?> <?php echo e(__('Invoices')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard('web')->check()): ?>
        <?php if($currentWorkspace->creater->id == Auth::user()->id): ?>
            <section class="row my-5">
                <div class="col-12">
                    <form method="post" class="">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-4 float-left">
                            <select class="select2 " size="sm" name="project_name" id="custom_search">
                                <option value=""><?php echo e(__('All Projects')); ?></option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->name); ?>" <?php echo e($project->name == $project_name  ? 'selected' : ''); ?>><?php echo e($project->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="issue_from">From</label>
                            <input type="date" name="issue_from" id="issue_from" class="custom-input" value="<?php echo e($issue_date_from ?? \Carbon\Carbon::parse($issue_date_from)->format('Y-m-d')); ?>">
                            <label for="issue_to">To</label>
                            <input type="date" name="issue_to" id="issue_to" class="custom-input" value="<?php echo e($issue_date_to ?? \Carbon\Carbon::parse($issue_date_to)->format('Y-m-d')); ?>">
                            

                            <button type="submit" class="btn btn-xs btn-info" formaction="<?php echo e(route('invoice.report.search', $currentWorkspace->slug)); ?>">Search</button>
                        </div>
                        <div class="col-md-12">
                            <div class=" mb-3">
                                <button type="submit" class="btn btn-xs btn-success pdf-download-btn float-right" formaction="<?php echo e(route('invoice.report.print', $currentWorkspace->slug)); ?>" formtarget="_blank"><i class="fa fa-file"></i> <?php echo e(__('Download PDF')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated" id="selection-datatable">
                                <thead>
                                <th><?php echo e(__('Invoice')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Issue Date')); ?></th>
                                <th><?php echo e(__('Due Date')); ?></th>
                                <th><?php echo e(__('Amount')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="Id sorting_1">
                                            <a href="<?php if(auth()->guard('web')->check()): ?><?php echo e(route('invoices.show',[$currentWorkspace->slug,$invoice->id])); ?><?php elseif(auth()->guard()->check()): ?><?php echo e(route('client.invoices.show',[$currentWorkspace->slug,$invoice->id])); ?><?php endif; ?>">
                                                <?php echo e(Utility::invoiceNumberFormat($invoice->invoice_id)); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($invoice->project->name); ?></td>
                                        <td><?php echo e(Utility::dateFormat($invoice->issue_date)); ?></td>
                                        <td><?php echo e(Utility::dateFormat($invoice->due_date)); ?></td>
                                        <td><?php echo e($currentWorkspace->priceFormat($invoice->getTotal())); ?></td>
                                        <td>
                                            <?php if($invoice->status == 'sent'): ?>
                                                <span class="badge badge-warning"><?php echo e(__('Sent')); ?></span>
                                            <?php elseif($invoice->status == 'paid'): ?>
                                                <span class="badge badge-success"><?php echo e(__('Paid')); ?></span>
                                            <?php elseif($invoice->status == 'canceled'): ?>
                                                <span class="badge badge-danger"><?php echo e(__('Canceled')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/reports/invoice.blade.php ENDPATH**/ ?>