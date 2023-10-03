
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Sim</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="<?php echo e(route('sims.index')); ?>"> Back</a>
            </div>
        </div>
    </div>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?php echo e(route('sims.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim Id:</strong>
                    <input type="text" name="sim_id" value="<?php echo e(isset($sim) ? $sim->sim_id : old('sim_id')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim #:</strong>
                    <input type="text" name="sim_no" value="<?php echo e(isset($sim) ? $sim->sim_no : old('sim_no')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Telco Name:</strong>
                    <input type="text" name="telco_name" value="<?php echo e(isset($sim) ? $sim->telco_name : old('telco_name')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Disco Name:</strong>
                    <input type="text" name="disco_name" value="<?php echo e(isset($sim) ? $sim->disco_name : old('disco_name')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO #:</strong>
                    <input type="text" name="po_no" value="<?php echo e(isset($sim) ? $sim->po_no : old('po_no')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO Date:</strong>
                    <input type="date" name="po_date" value="<?php echo e(isset($sim) ? $sim->po_date : old('po_date')); ?>"
                        class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim Status:</strong>
                    <select name="status" id="status" class="form-control">
                        <option value="0" <?php echo e(isset($sim) && $sim->status == '0' ? 'selected' : ''); ?>>
                            In-Active</option>
                        <option value="1" <?php echo e(isset($sim) && $sim->status == '1' ? 'selected' : ''); ?>>Active</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="rec_id" value="<?php echo e(isset($sim) ? $sim->id : old('rec_id')); ?>">

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sims.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\Code Squad\AppSquad\laravel\TelcoSims\resources\views/Sims/create.blade.php ENDPATH**/ ?>