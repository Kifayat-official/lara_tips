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

    

    <form method="POST" action="<?php echo e(url('import')); ?>" enctype="multipart/form-data" id="upload-form">
        <?php echo csrf_field(); ?>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="csv_file" id="csv_file" required>
            <label class="custom-file-label" for="csv_file">Choose file</label>
        </div>
        <button type="button" class="btn btn-primary mt-3" id="submit-btn" disabled>
            <span id="submit-btn-content">Import CSV</span>
            <div id="submit-btn-spinner" style="display: none;">
                <div class="spinner-border spinner-border-sm" role="status"></div>
                <span class="sr-only">Loading...</span>
            </div>
        </button>
        <div class="invalid-feedback">Please attach a CSV file.</div>
    </form>
    <div id="res-msg" class="alert alert-success d-none">
        <p id="res-msg-txt"></p>
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

<?php $__env->startSection('footer-libs'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            var submitButton = $('#submit-btn');
            submitButton.addClass("d-none");

            $('#csv_file').change(function() {
                var fileInput = $(this);


                if (fileInput[0].files.length > 0) {
                    submitButton.prop('disabled', false);
                    submitButton.removeClass("d-none");
                } else {
                    submitButton.addClass("d-none");
                    // submitButton.prop('disabled', true);
                }
            });

            $('#submit-btn').click(function() {
                var submitBtnContent = $('#submit-btn-content')
                var submitBtnSpinner = $('#submit-btn-spinner')
                var resMsgDiv = $('#res-msg')
                var resMsgTxt = $('#res-msg-txt')

                submitBtnContent.hide()
                submitBtnSpinner.show()

                var formData = new FormData($('#upload-form')[0])

                $.ajax({
                    url: "<?php echo e(url('import')); ?>",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        submitButton.addClass("d-none");

                        submitBtnContent.show();
                        submitBtnSpinner.hide();
                        resMsgDiv.removeClass("d-none");
                        resMsgTxt.text(data.message);


                        // setTimeout(function() {
                        //     resMsgDiv.addClass("d-none");
                        // }, 5000);
                    },
                    error: function(error) {
                        submitBtnContent.show();
                        submitBtnSpinner.hide();
                    }
                });
            });


        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Kifayat Ullah\Desktop\Code Squad\AppSquad\laravel\telco-sims\source\resources\views/sims/index.blade.php ENDPATH**/ ?>