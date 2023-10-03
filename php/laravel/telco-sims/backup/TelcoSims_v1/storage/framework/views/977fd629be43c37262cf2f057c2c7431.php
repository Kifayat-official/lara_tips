
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Create CRUD Application using Laravel 10 - LaravelTuts.com</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="<?php echo e(route('sims.create')); ?>"> Create New sim</a>
            </div>
        </div>
    </div>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        <?php $__currentLoopData = $sims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$i); ?></td>
                <td><?php echo e($sim->name); ?></td>
                <td><?php echo e($sim->detail); ?></td>
                <td>
                    <form action="<?php echo e(route('sims.destroy', $sim->id)); ?>" method="POST">
                        <a class="btn btn-info" href="<?php echo e(route('sims.show', $sim->id)); ?>">Show</a>
                        <a class="btn btn-primary" href="<?php echo e(route('sims.edit', $sim->id)); ?>">Edit</a>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <?php echo $sims->links(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sims.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\Code Squad\AppSquad\laravel\TelcoSims\resources\views/Sims/index.blade.php ENDPATH**/ ?>