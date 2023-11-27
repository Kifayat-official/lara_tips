<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        <?php echo e(isset($obj) ? 'Edit' : 'Add'); ?> User
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

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo e(isset($obj) ? $obj->name : ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo e(isset($obj) ? $obj->email : ''); ?>" requried>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" aria-describedby="passwordHelpId" <?php echo e(isset($obj) ? '' : 'required'); ?> autocomplete="new-password">
                <?php if( isset($obj) ): ?>
               <small id="passwordHelpId" class="form-text text-muted">Leave empty if you do not want to change password</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" <?php echo e(isset($obj) ? '' : 'required'); ?>>
            </div>

            <div class="form-check <?php echo e(Auth::user()->is_super_admin == 0 ? 'hidden' : ''); ?>">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="is_super_admin" value="1" <?php echo e(isset($obj) && $obj->is_super_admin ? 'checked' : ''); ?>>
                    Is Super Admin (Has all permissions)
                </label>
            </div>

            <br>
            <div class="form-group role-selector">
            <label>Role</label>
                <select id="role_id_selector" class="form-control" name="role">
                    <?php $__currentLoopData = $additional_data['roles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e(isset($obj) && $obj->role_id == $role->id ? 'selected' : ''); ?>><?php echo e($role->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group mdc-selector">


            </div>

            <br>
            <div class="form-check">
                <label class="form-check-label">
                    <?php
                    $checked = true;
                    if(isset($obj)) {
                        $checked = $obj->status == 1 ? true : false;
                    }
                    ?>
                    <input type="checkbox" class="form-check-input" name="status" value="1" <?php echo e($checked ? 'checked' : ''); ?>>
                    Status
                </label>
            </div>

            <?php $__env->startComponent('components.submit_button'); ?>
            <?php echo $__env->renderComponent(); ?>

        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    var mdc_array = <?php echo json_encode($mdc, 15, 512) ?>;
    $(document).ready(function(){
        var formId = "#form_<?php echo e($uniqid); ?>";

        showHideRoleField(formId);

        submitForm({
            formId: "#form_<?php echo e($uniqid); ?>",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_<?php echo e($uniqid); ?>'));
                return formData;
            },
            submitUrl: "<?php echo e(isset($obj) ? url('users') . '/' . $obj->id : url('users')); ?>",
            successfulCallback: function() {
                window.location.href = "<?php echo e(url('users')); ?>";
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        $(formId + " [name='is_super_admin']").change(function(){
            showHideRoleField(formId);
        });
    });

    function showHideRoleField(formId) {
        var isSuperAdmin = $(formId + " [name='is_super_admin']").prop('checked');
        if(isSuperAdmin) {
            $(formId + " .role-selector").hide('fast');
            $(formId + " .mdc-selector").hide('fast');
        } else {
            $(formId + " .role-selector").show('fast');
            $(formId + " .mdc-selector").show('fast');
        }
    }

    $("#role_id_selector").change(function(){
        var selectedCountry = $(this).val();
        //alert(mdc_array.length);
        $(".mdc-selector").empty();
        if(mdc_array.length > 0)
        {
            if(_isContains(mdc_array, $(this).val())){
                var tariffHtml = `
                                    <label for="">Select MDC sessions (if none selected than all tests will be shown to user)</label>
                                    <div class="form-group">
                                            <?php $__currentLoopData = \App\MdcTestSession::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tariff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $checked = false;
                                                    if(isset($obj)) {
                                                        $checked = in_array($tariff->id, $additional_data['mdc_selection_id_array']) ? true : false;
                                                    }
                                                ?>
                                                <option ></option>
                                                <input type="checkbox" class="meters" name="mdc_session_id[]" value="<?php echo e($tariff->id); ?>" <?php echo e($checked ? 'checked' : ''); ?>>
                                                <?php echo e(\App\Company::where('id',$tariff->company_id)->value('name')); ?> - <?php echo e($tariff->mdc_name); ?> - <?php echo e($tariff->company_rep); ?>


                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>`

                $(".mdc-selector").append(tariffHtml);
            }
        }
    }).change();

    function _isContains(json, value) {
        let contains = false;
        Object.keys(json).some(key => {
                contains = typeof json[key] === 'object' ? _isContains(json[key], value) : json[key] === value;
            return contains;
            });
        return contains;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dev\htdocs\udil\resources\views/users/add_edit.blade.php ENDPATH**/ ?>