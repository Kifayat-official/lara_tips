<?php $__env->startComponent('tests.components.transactionid_and_privatekey', [
        'add_transactionid' => 0,
        'add_privatekey' => 1
    ]); ?>
<?php echo $__env->renderComponent(); ?>
<input type="hidden" class="form-control" name="header[Content-Type]" value="application/x-www-form-urlencoded" />

<div class="row">
    <div class="form-group col-md-12">
        <label for="">Transaction ID</label>
        <input class="form-control" type="text" name="header[transactionid]" value="<?php echo e(session('transactionid')); ?>" >
    </div>
</div><?php /**PATH D:\Xamp\htdocs\testing_suite\resources\views/tests/test_forms/transaction_status_read.blade.php ENDPATH**/ ?>