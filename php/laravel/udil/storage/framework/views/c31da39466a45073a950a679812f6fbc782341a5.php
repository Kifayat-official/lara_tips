<?php $__env->startSection('content'); ?>
<div id="tests_report" class="box">
  <h1 class="p-3 mb-2 bg-primary text-white">Complete Tests History</h1>
      <!-- /.box-header -->
    <div class="box-body">
      <table id='user_table' class="table table-bordered">
        <thead>
          <tr>
            <th width="10%">Created By User</th>
            <th width="10%">Time</th>
            <th width="20%">Checklist (Test Profile)</th>
            <th width="10%">Test Name</th>
            <th width="5%">Status</th>
            <th width="20%">Remarks</th>
            <th width="25%">Picture</th>
          </tr>
        </thead>

      </table>

    </div>
      <!-- ./box-body -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function(){

  $('#user_table').DataTable({
          processing:true,
          serverSide:true,
          ajax:{
              url:"<?php echo e(action('ReportController@completeTestHistory')); ?>",
          },
          columns:[
              {
                  data:'name',
                  name:'name'
              },

              {
                  data:'created_at',
                  name:'created_at'
              },

              {
                  data:'test_profile.name',
                  name:'test_profile.name'
              },

              {
                  data:'test.name',
                  name:'test.name'
              },

              {
                  data:'is_pass',
                  name:'is_pass'
              },

              {
                  data:'remarks',
                  name:'remarks',
                  default:'-'
              },

              {
                  data:'attachment',
                  name:'attachment',
                  default:'-'
              }

          ]

      });
      //$(document).on('click','.edit',function(){

})

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xamp\htdocs\testing_suite\resources\views/reports/test_history.blade.php ENDPATH**/ ?>