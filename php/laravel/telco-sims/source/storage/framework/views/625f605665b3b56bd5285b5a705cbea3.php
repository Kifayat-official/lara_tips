
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>SIMS Database</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="<?php echo e(route('sims.create')); ?>"> Create New SIM</a>
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
            <th>Sr.#</th>
            <th>SIM ID</th>
            <th>SIM #</th>

            <th>TELCO</th>
            <th>DISCO</th>
            <th>PO #</th>
            <th>PO DATE</th>
            <th>SIM STATUS</th>
            <th width="280px">Action</th>
        </tr>
        <?php $__currentLoopData = $sims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e(++$i); ?></td>
                <td><?php echo e($sim->sim_no); ?></td>
                <td><?php echo e($sim->sim_id); ?></td>
                <td><?php echo e($sim->telco_name); ?></td>
                <td><?php echo e($sim->disco_name); ?></td>
                <td><?php echo e($sim->po_no); ?></td>
                <td><?php echo e($sim->po_date); ?></td>
                <td>
                    <span class="badge <?php echo e($sim->status == 1 ? 'bg-success' : 'bg-danger'); ?>">
                        <?php echo e($sim->status == 1 ? 'Active' : 'In-Active'); ?>

                    </span>
                </td>
                <td>
                    <form action="<?php echo e(route('sims.destroy', $sim->id)); ?>" method="POST">

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

<?php echo $__env->make('sims.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\telco_sims\TelcoSims\resources\views/sims/index.blade.php ENDPATH**/ ?>