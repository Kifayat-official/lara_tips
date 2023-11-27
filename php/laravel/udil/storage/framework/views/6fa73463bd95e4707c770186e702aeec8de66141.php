<div class="form-group <?php echo e($class); ?>">
    <label for=""><?php echo e($title); ?></label>
    <input type="text" class="form-control datetimepicker-field" name="<?php echo e($name); ?>" 
        value="<?php echo e($value); ?>">
</div>

<script>
    $(document).ready(function(){
        $('.datetimepicker-field').datetimepicker({
            'format': 'DD-MMM-YYYY HH:mm:ss',
        });
    });
</script><?php /**PATH /var/www/html/udil/resources/views/components/datetimepicker.blade.php ENDPATH**/ ?>