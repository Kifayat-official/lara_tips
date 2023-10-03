
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
                        class="form-control" placeholder="SIM ID">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Sim #:</strong>
                    <input type="text" name="sim_no" value="<?php echo e(isset($sim) ? $sim->sim_no : old('sim_no')); ?>"
                        class="form-control" placeholder="SIM #">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Telco Name:</strong>
                    <select name="telco_name" class="form-control">
                        <option value="" <?php echo e(old('telco_name') === null ? 'selected' : ''); ?>>Select Telco</option>
                        <option value="ufone"
                            <?php echo e(isset($sim) && $sim->telco_name == 'ufone' ? 'selected' : (old('telco_name') == 'ufone' ? 'selected' : '')); ?>>
                            Ufone
                        </option>
                        <option value="zong"
                            <?php echo e(isset($sim) && $sim->telco_name == 'zong' ? 'selected' : (old('telco_name') == 'zong' ? 'selected' : '')); ?>>
                            Zong
                        </option>
                        <option value="telenor"
                            <?php echo e(isset($sim) && $sim->telco_name == 'telenor' ? 'selected' : (old('telco_name') == 'telenor' ? 'selected' : '')); ?>>
                            Telenor
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Disco Name:</strong>
                    <select name="disco_name" class="form-control">
                        <option value="" <?php echo e(old('disco_name') === null ? 'selected' : ''); ?>>Select DISCO</option>
                        <option value="mepco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'mepco' ? 'selected' : (old('disco_name') == 'mepco' ? 'selected' : '')); ?>>
                            MEPCO
                        </option>
                        <option value="iesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'iesco' ? 'selected' : (old('disco_name') == 'iesco' ? 'selected' : '')); ?>>
                            IESCO
                        </option>
                        <option value="pesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'pesco' ? 'selected' : (old('disco_name') == 'pesco' ? 'selected' : '')); ?>>
                            PESCO
                        </option>
                        <option value="hesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'hesco' ? 'selected' : (old('disco_name') == 'hesco' ? 'selected' : '')); ?>>
                            HESCO
                        </option>
                        <option value="fesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'fesco' ? 'selected' : (old('disco_name') == 'fesco' ? 'selected' : '')); ?>>
                            FESCO
                        </option>
                        <option value="gepco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'gepco' ? 'selected' : (old('disco_name') == 'gepco' ? 'selected' : '')); ?>>
                            GEPCO
                        </option>
                        <option value="sepco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'sepco' ? 'selected' : (old('disco_name') == 'sepco' ? 'selected' : '')); ?>>
                            SEPCO
                        </option>
                        <option value="qesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'qesco' ? 'selected' : (old('disco_name') == 'qesco' ? 'selected' : '')); ?>>
                            QESCO
                        </option>
                        <option value="tesco"
                            <?php echo e(isset($sim) && $sim->disco_name == 'tesco' ? 'selected' : (old('disco_name') == 'tesco' ? 'selected' : '')); ?>>
                            TESCO
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO #:</strong>
                    <input type="text" name="po_no" value="<?php echo e(isset($sim) ? $sim->po_no : old('po_no')); ?>"
                        class="form-control" placeholder="PO #">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>PO Date:</strong>
                    <input type="date" name="po_date" value="<?php echo e(isset($sim) ? $sim->po_date : old('po_date')); ?>"
                        class="form-control" placeholder="PO Date">
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>SIM Status:</strong>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="0"
                            <?php echo e(isset($sim) && $sim->status == '0' ? 'selected' : (old('status') == '0' ? 'selected' : '')); ?>>
                            In-Active</option>
                        <option value="1"
                            <?php echo e(isset($sim) && $sim->status == '1' ? 'selected' : (old('status') == '1' ? 'selected' : '')); ?>>
                            Active
                        </option>
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

<?php echo $__env->make('sims.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\telco_sims\TelcoSims\resources\views/Sims/create.blade.php ENDPATH**/ ?>