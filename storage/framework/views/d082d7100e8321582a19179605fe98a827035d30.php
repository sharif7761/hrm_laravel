<?php $__env->startSection('page-title'); ?> <?php echo e(__('Invoices')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('multiple-action-button'); ?>
    <?php if(auth()->guard('client')->check()): ?>


<?php if($invoice->getDueAmount() > 0): ?>
            <div class="text-sm-right">
                <a href="#" data-toggle="modal" data-target="#paymentModal" class="btn btn-xs btn-white btn-icon-only width-auto" type="button">
                    <i class="fas fa-credit-card mr-1"></i> <?php echo e(__('Pay Now')); ?>

                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(auth()->guard('web')->check()): ?>
        <?php if($currentWorkspace->creater->id == Auth::user()->id): ?>
            <div class="text-sm-right">
                <a href="#" data-toggle="modal" data-target="#addPaymentModal" class="btn btn-xs btn-white btn-icon-only width-auto" type="button">
                    <i class="fas fa-credit-card mr-1"></i> <?php echo e(__('Add Payment')); ?>

                </a>
                <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Invoice')); ?>" data-url="<?php echo e(route('invoices.edit',[$currentWorkspace->slug,$invoice->id])); ?>">
                    <i class="fas fa-pencil-alt mr-1"></i><?php echo e(__('Edit Invoice')); ?>

                </a>
                <a href="#" data-ajax-popup="true" data-title="<?php echo e(__('Add Item')); ?>" data-url="<?php echo e(route('invoice.item.create',[$currentWorkspace->slug,$invoice->id])); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" type="button">
                    <i class="fas fa-plus mr-1"></i> <?php echo e(__('Add Item')); ?>

                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <div class="text-right">
                        <div class="h5"><?php echo e(Utility::invoiceNumberFormat($invoice->invoice_id)); ?></div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <address class="text-sm">
                                <h6><?php echo e(__('From')); ?>:</h6>
                                <?php if($currentWorkspace->company): ?><?php echo e($currentWorkspace->company); ?><?php endif; ?>
                                <?php if($currentWorkspace->address): ?> <br><?php echo e($currentWorkspace->address); ?><?php endif; ?>
                                <?php if($currentWorkspace->city): ?> <br> <?php echo e($currentWorkspace->city); ?>, <?php endif; ?> <?php if($currentWorkspace->state): ?><?php echo e($currentWorkspace->state); ?><?php endif; ?> <?php if($currentWorkspace->zipcode): ?> - <?php echo e($currentWorkspace->zipcode); ?><?php endif; ?>
                                <?php if($currentWorkspace->country): ?> <br><?php echo e($currentWorkspace->country); ?><?php endif; ?>
                                <?php if($currentWorkspace->telephone): ?> <br><?php echo e($currentWorkspace->telephone); ?><?php endif; ?>
                            </address>
                            <address class="text-sm">
                                <h6><?php echo e(__('To')); ?>:</h6>
                                <?php if($invoice->client): ?>
                                    <?php echo e($invoice->client->name); ?>

                                    <?php if($invoice->client->address): ?> <br><?php echo e($invoice->client->address); ?><?php endif; ?>
                                    <?php if($invoice->client->city): ?> <br> <?php echo e($invoice->client->city); ?>, <?php endif; ?> <?php if($invoice->client->state): ?><?php echo e($invoice->client->state); ?><?php endif; ?> <?php if($invoice->client->zipcode): ?> - <?php echo e($invoice->client->zipcode); ?><?php endif; ?>
                                    <?php if($invoice->client->country): ?> <br><?php echo e($invoice->client->country); ?><?php endif; ?>
                                    <br><?php echo e($invoice->client->email); ?>

                                    <?php if($invoice->client->telephone): ?> <br><?php echo e($invoice->client->telephone); ?><?php endif; ?>
                                <?php endif; ?>
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <h6><?php echo e(__('Project')); ?>:</h6>
                                <?php echo e($invoice->project->name); ?>

                            </address>
                            <address>
                                <h6><?php echo e(__('Status')); ?>:</h6>
                                <div class="font-weight-bold font-style">
                                    <?php if($invoice->status == 'sent'): ?>
                                        <span class="badge badge-warning"><?php echo e(__('Sent')); ?></span>
                                    <?php elseif($invoice->status == 'paid'): ?>
                                        <span class="badge badge-success"><?php echo e(__('Paid')); ?></span>
                                    <?php elseif($invoice->status == 'canceled'): ?>
                                        <span class="badge badge-danger"><?php echo e(__('Canceled')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </address>
                            <address>
                                <h6><?php echo e(__('Issue Date')); ?>:</h6>
                                <?php echo e(Utility::dateFormat($invoice->issue_date)); ?>

                            </address>
                            <address>
                                <h6><?php echo e(__('Due Date')); ?>:</h6>
                                <?php echo e(Utility::dateFormat($invoice->due_date)); ?>

                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="h6"><?php echo e(__('Order Summary')); ?></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tbody>
                                    <tr>
                                        <th class="form-control-label">#</th>
                                        <th class="form-control-label"><?php echo e(__('Item')); ?></th>
                                        <th class="form-control-label text-right"><?php echo e(__('Totals')); ?></th>
                                        <?php if(auth()->guard('web')->check()): ?>
                                            <th class="form-control-label text-right"><?php echo e(__('Action')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                    <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key+1); ?></td>
                                            <td><?php echo e($item->task->title); ?> - <b><?php echo e($item->task->project->name); ?></b></td>
                                            <td><?php echo e($currentWorkspace->priceFormat($item->price * $item->qty)); ?></td>
                                            <?php if(auth()->guard('web')->check()): ?>
                                                <td class="text-right">
                                                    <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($item->id); ?>').submit();">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                    <form id="delete-form-<?php echo e($item->id); ?>" action="<?php echo e(route('invoice.item.destroy',[$currentWorkspace->slug,$invoice->id,$item->id])); ?>" method="POST" style="display: none;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="offset-md-8 col-md-4 text-right">
                                    <div class="invoice-detail-item">
                                        <span><?php echo e(__('Subtotal')); ?></span>
                                        <div class="h6"><?php echo e($currentWorkspace->priceFormat($invoice->getSubTotal())); ?></div>
                                    </div>
                                    <?php if($invoice->discount): ?>
                                        <div class="invoice-detail-item">
                                            <span><?php echo e(__('Discount')); ?></span>
                                            <div class="h6"><?php echo e($currentWorkspace->priceFormat($invoice->discount)); ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($invoice->tax): ?>
                                        <div class="invoice-detail-item">
                                            <span><?php echo e(__('Tax')); ?> <?php echo e($invoice->tax->name); ?> (<?php echo e($invoice->tax->rate); ?>%)</span>
                                            <div class="h6"><?php echo e($currentWorkspace->priceFormat($invoice->getTaxTotal())); ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <span><?php echo e(__('Total')); ?></span>
                                        <div class="h6"><?php echo e($currentWorkspace->priceFormat($invoice->getTotal())); ?></div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <span><?php echo e(__('Due Amount')); ?></span>
                                        <div class="h6 text-danger"><?php echo e($currentWorkspace->priceFormat($invoice->getDueAmount())); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="<?php if(auth()->guard('web')->check()): ?><?php echo e(route('invoice.print',[$currentWorkspace->slug,\Illuminate\Support\Facades\Crypt::encryptString($invoice->id)])); ?><?php elseif(auth()->guard()->check()): ?><?php echo e(route('client.invoice.print',[$currentWorkspace->slug,\Illuminate\Support\Facades\Crypt::encryptString($invoice->id)])); ?><?php endif; ?>" class="btn-submit">
                                <i class="fas fa-print"></i> <?php echo e(__('Print')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if($payments = $invoice->payments): ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6><?php echo e(__('Payments')); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tbody>
                                <tr>
                                    <th class="form-control-label"><?php echo e(__('Id')); ?></th>
                                    <th class="form-control-label"><?php echo e(__('Amount')); ?></th>
                                    <th class="form-control-label"><?php echo e(__('Currency')); ?></th>
                                    <th class="form-control-label"><?php echo e(__('Status')); ?></th>
                                    <th class="form-control-label"><?php echo e(__('Payment Type')); ?></th>
                                    <th class="form-control-label"><?php echo e(__('Date')); ?></th>

                                </tr>
                                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($payment->order_id); ?></td>
                                        <td><?php echo e($currentWorkspace->priceFormat($payment->amount)); ?></td>
                                        <td><?php echo e(strtoupper($payment->currency)); ?></td>
                                        <td>
                                            <?php if($payment->payment_status == 'succeeded' || $payment->payment_status == 'approved'): ?>
                                                <i class="fas fa-circle text-success"></i> <?php echo e(__(ucfirst($payment->payment_status))); ?>

                                            <?php else: ?>
                                                <i class="fas fa-circle text-danger"></i> <?php echo e(__(ucfirst($payment->payment_status))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(__($payment->payment_type)); ?></td>
                                        <td><?php echo e(Utility::dateFormat($payment->created_at)); ?></td>
                                        <td>
                                            <?php if(!empty($payment->receipt)): ?>
                                                <a href="<?php echo e($payment->receipt); ?>" target="_blank" class="btn-submit"><i class="fas fa-print mr-1"></i> <?php echo e(__('Receipt')); ?></a>
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
    <?php endif; ?>

    <?php if(auth('web') && $invoice->getDueAmount() > 0): ?>
        <!-- Modal -->
        <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel"><?php echo e(__('Add Manual Payment')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-box">
                            <form method="post" action="<?php echo e(route('manual.invoice.payment',[$currentWorkspace->slug,$invoice->id])); ?>" class="require-validation">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                        <div class="form-icon-user">
                                            <span class="currency-icon"><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?></span>
                                            <input class="form-control" type="number" id="amount" name="amount" value="<?php echo e($invoice->getDueAmount()); ?>" min="0" step="0.01" max="<?php echo e($invoice->getDueAmount()); ?>" placeholder="<?php echo e(__('Enter Monthly Price')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" class="btn-create badge-blue" value="<?php echo e(__('Make Payment')); ?>">
                                        <input type="button" class="btn-create bg-gray" data-dismiss="modal" value="<?php echo e(__('Cancel')); ?>">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(auth()->guard('client')->check()): ?>
        <?php if($invoice->getDueAmount() > 0): ?>
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel"><?php echo e(__('Add Payment')); ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-box">











                                <div class="tab-content mt-3">


                                            <form method="post" action="<?php echo e(route('client.invoice.payment',[$currentWorkspace->slug,$invoice->id])); ?>" class="require-validation" id="payment-form">
                                                <?php echo csrf_field(); ?>



























                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="amount" class="form-control-label"><?php echo e(__('Amount')); ?></label>
                                                        <div class="form-icon-user">
                                                            <span class="currency-icon"><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : 'TK'); ?></span>
                                                            <input class="form-control" required="required" min="0" name="amount" type="number" value="<?php echo e($invoice->getDueAmount()); ?>" min="0" step="0.01" max="<?php echo e($invoice->getDueAmount()); ?>" id="amount">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="error" style="display: none;">
                                                            <div class='alert-danger alert'><?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn-create badge-blue" value="<?php echo e(__('Make Payment')); ?>">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>




















                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php if(auth()->guard('client')->check()): ?>
    <?php if($invoice->getDueAmount()>0 && $currentWorkspace->is_stripe_enabled == 1 && !empty($currentWorkspace->stripe_key) && !empty($currentWorkspace->stripe_secret)): ?>

        <?php $__env->startPush('css-page'); ?>
            <style>
                #card-element {
                    border: 1px solid #e4e6fc;
                    border-radius: 5px;
                    padding: 10px;
                }
            </style>
        <?php $__env->stopPush(); ?>
        <?php $__env->startPush('scripts'); ?>
            <script src="https://js.stripe.com/v3/"></script>

            <script type="text/javascript">

                var stripe = Stripe('<?php echo e($currentWorkspace->stripe_key); ?>');
                var elements = stripe.elements();

                // Custom styling can be passed to options when creating an Element.
                var style = {
                    base: {
                        // Add your base input styles here. For example:
                        fontSize: '14px',
                        color: '#32325d',
                    },
                };

                // Create an instance of the card Element.
                var card = elements.create('card', {style: style});

                // Add an instance of the card Element into the `card-element` <div>.
                card.mount('#card-element');

                // Create a token or display an error when the form is submitted.
                var form = document.getElementById('payment-form');
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            show_toastr('Error', result.error.message, 'error');
                        } else {
                            // Send the token to your server.
                            stripeTokenHandler(result.token);
                        }
                    });
                });

                function stripeTokenHandler(token) {
                    // Insert the token ID into the form so it gets submitted to the server
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);

                    // Submit the form
                    form.submit();
                }
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/invoices/show.blade.php ENDPATH**/ ?>