<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        <?php echo e(isset($obj) ? 'Edit' : 'Add'); ?> Company
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">
    
    <div class="box-body">
        <form id="form_<?php echo e($uniqid); ?>" action="" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($obj)): ?>
            <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="row">
    
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo e(isset($obj) ? $obj->name : ''); ?>" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="<?php echo e(isset($obj) ? $obj->address : ''); ?>" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo e(isset($obj) ? $obj->phone : ''); ?>" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo e(isset($obj) ? $obj->email : ''); ?>" required>
                    </div>
                </div>

            </div>

            <?php $__env->startComponent('components.submit_button'); ?>
            <?php echo $__env->renderComponent(); ?>

        </form>
    </div>

</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function(){
        
        submitForm({
            formId: "#form_<?php echo e($uniqid); ?>",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_<?php echo e($uniqid); ?>'));
                return formData;
            },
            submitUrl: "<?php echo e(isset($obj) ? url('companies') . '/' . $obj->id : url('companies')); ?>",
            successfulCallback: function() {
                window.location.href = "<?php echo e(url('companies')); ?>";
            },
            failureCallback: null,
            alwaysCallback: null,
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/udil/resources/views/companies/add_edit.blade.php ENDPATH**/ ?>