<div class="table-responsive">
    <table id="table_<?php echo e($uniqid); ?>" class="table table-bordered">
        <thead>

            <?php
                $is_filters_set = false;
            ?>

            <tr>
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th class="<?php echo e(isset($column['class']) ? $column['class'] : ''); ?>"><?php echo e($column['title']); ?></th>
                    <?php
                        if(isset($column['filter_options'])) 
                        {
                            $is_filters_set = true;
                        }
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>

            <?php if($is_filters_set): ?>
                <tr class="bg-info">
                    <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <?php if(isset($column['filter_options'])): ?>
                                <?php if($column['filter_options']['type'] == 'select'): ?>
                                    <select class="filter-control" style="width: 100%;" class="form-control" data-relation_and_column="<?php echo e($column['filter_options']['relation_and_column']); ?>">
                                        <option value="">All</option>
                                        <?php $__currentLoopData = $column['filter_options']['select_options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>"><?php echo e($title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endif; ?>

        </thead>

        <tbody>
        </tbody>
    </table>
</div>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {

        $('.filter-control').change(function(){
            refreshDataTable();
        })

        var table_<?php echo e($uniqid); ?> = $('#table_<?php echo e($uniqid); ?>').DataTable({
            processing: true,
            serverSide: true,
            bSortCellsTop: true,
            ajax: {
                url: '<?php echo e($data_url); ?>',
                type: 'post',
                data: function(d) {
                    d['_token'] = "<?php echo e(@csrf_token()); ?>";

                    var filters = [];

                    $.each( $('.filter-control'), function(index, item){
                        if( $(item).val() ) {
                            filters.push({
                                relation_and_column: $(item).data('relation_and_column'),
                                value: $(item).val(),
                            });
                        }
                    });

                    if(filters.length > 0) {
                        d['filters'] = filters;
                    }

                    return d;
                }
            },
            columns: [

                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> {
                    data: '<?php echo e($column["data"]); ?>',
                    name: '<?php echo e($column["name"]); ?>',
                    defaultContent: '-',
                    class: '<?php echo e(isset($column["class"]) ? $column["class"] : ""); ?>'
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            ]
        });

        function refreshDataTable() {
            table_<?php echo e($uniqid); ?>.ajax.reload();
        }
    });

    function editItem(id) {
        window.location.href = "<?php echo e($resource_url); ?>" + "/" + id + "/edit";
    }

    function deleteItem(id, deleteButton) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    url: '<?php echo e($resource_url); ?>' + '/' + id,
                    type: 'post',
                    data: {
                        _token: "<?php echo e(@csrf_token()); ?>",
                        _method: 'DELETE',
                    },
                }).done(function(data) {
                    $(deleteButton).closest('tr').remove();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }).fail(function(error) {
                    alert(error);
                });
            }
        });
    }
</script>
<?php $__env->stopSection(); ?><?php /**PATH E:\dev7\htdocs\udil\resources\views/components/datatable.blade.php ENDPATH**/ ?>