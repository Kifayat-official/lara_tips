<?php

$uniqid = uniqid();

?>



<?php $__env->startSection('content_header'); ?>
    <h1>
        <?php echo e(isset($obj) ? 'Edit' : 'Start'); ?> UDIL Test
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box box-primary">

    <div class="box-body" style="background-color: #e8e8e8;">

        <form id="form_<?php echo e($uniqid); ?>" action="" method="POST">
            <?php echo csrf_field(); ?>
            <?php if(isset($obj)): ?>
            <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6">

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Company & MDC Information</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="company">Company Name*</label>
	                            <select class="form-control form-control-sm" name="company" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\Company::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($company->id); ?>" <?php echo e(isset($obj) && $obj->company_id == $company->id ? 'selected' : ''); ?>><?php echo e($company->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                            </select>
                            </div>

                            <div class="form-group">
                                <label for="rep">Company Representative*</label>
                                <input type="text" id="rep" name="rep" placeholder="Enter Representative Name"
                                    value="<?php echo e(isset($obj) ? $obj->company_rep : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">Rep. Designation*</label>
                                <input type="text" id="rep" name="rep_des" placeholder="Enter Representative Designation"
                                    value="<?php echo e(isset($obj) ? $obj->company_rep_designation : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">MDC Name*</label>
                                <input type="text" id="mdc_name" name="mdc_name" placeholder="Enter MDC Name"
                                    value="<?php echo e(isset($obj) ? $obj->mdc_name : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">MDC Version*</label>
                                <input type="text" id="rep" name="version" placeholder="Enter MDC Version"
                                    value="<?php echo e(isset($obj) ? $obj->mdc_version : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="mode">Communication Modes*</label><br>
                                <input type="checkbox" name="is_gprs" <?php echo e(isset($obj) && $obj->is_gprs == 1 ? 'checked' : ''); ?> id="c1" value = "1"/>
                                <label for="c1">GPRS/3G/4G</label>
                                <input type="checkbox" name="is_rf" <?php echo e(isset($obj) && $obj->is_rf == 1 ? 'checked' : ''); ?> id="c2" value = "1" />
                                <label for="c2">RF</label>
                                <input type="checkbox" name="is_plc" <?php echo e(isset($obj) && $obj->is_plc == 1 ? 'checked' : ''); ?> id="c3" value = "1"/>
                                <label for="c3">PLC</label>
                                <input type="checkbox" name="is_wifi" <?php echo e(isset($obj) && $obj->is_wifi == 1 ? 'checked' : ''); ?> id="c4" value = "1"/>
                                <label for="c4">WiFi</label>
                                <input type="checkbox" name="is_zigbee" <?php echo e(isset($obj) && $obj->is_zigbee == 1 ? 'checked' : ''); ?> id="c5" value = "1"/>
                                <label for="c5">ZigBee</label>
                                <input type="checkbox" name="is_lan" <?php echo e(isset($obj) && $obj->is_lan == 1 ? 'checked' : ''); ?> id="c6" value = "1"/>
                                <label for="c6">LAN</label>
                            </div>

                            <div class="form-group">
                                <label>Test Profile (UDIL Checklist)</label>
                                <select class="form-control" name="test_profile" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\TestProfile::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test_profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($test_profile->id); ?>" <?php echo e(isset($obj) && $obj->test_profile_id == $test_profile->id ? 'selected' : ''); ?>><?php echo e($test_profile->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="is_transaction_status_api_based">Is Transaction Status API Based?</label><br>
                                <input type="checkbox" name="is_transaction_status_api_based" <?php echo e(isset($obj) && $obj->is_transaction_status_api_based == 1 ? 'checked' : ''); ?> id="is_transaction_status_api_based" value = "1"/>
                            </div>

                            <div class="form-group">
                                <label for="writing_tests_transaction_timeout_minutes">Writing Tests Transaction Timeout (minutes)*</label>
                                <input type="number" id="writing_tests_transaction_timeout_minutes" name="writing_tests_transaction_timeout_minutes"
                                    value="<?php echo e(isset($obj) ? $obj->writing_tests_transaction_timeout_minutes : ''); ?>" class="form-control form-control-sm" class="required" min="1" max="15" required>
                            </div>

                            <?php
                                $is_fee_voucher_attached = isset($obj) && $obj->fee_voucher != '' && $obj->fee_voucher != null;
                            ?>

                            <div class="form-group">
                            <label>Fee Voucher</label> <br>
                                <div id="fee-voucher-buttons" class="<?php echo e($is_fee_voucher_attached ? '' : 'hidden'); ?>" style="margin-bottom: 5px" >
                                    <a target="_blank" href="<?php echo e(url('download_fee_voucher')); ?>/<?php echo e(isset($obj) ? $obj->fee_voucher : ''); ?>" class="btn btn-primary"><i class="fa fa-download"></i> Download Fee Voucher</a>
                                    <button id="btn-delete-fee-voucher" type="button" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Delete Fee Voucher
                                    </button>
                                </div>

                                <input class="<?php echo e($is_fee_voucher_attached ? 'hidden' : ''); ?>" type="file" class="form-control" name="fee_voucher" accept=".pdf, image/*">
                                <input name="is_fee_voucher_deleted" type="hidden" value="1">
                            </div>

                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->
                </div>
                <!-- col-md-6 -->

                <div class="col-md-6">

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Meters</h3>
                        </div>
                        <div class="box-body">
                            <table id="meters_table_<?php echo e($uniqid); ?>" class="table table-bordered">
                                <thead>
                                    <th>MSN</th>
                                    <th>Meter Model</th>
                                    <th>Meter Type</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php if( isset($obj) && count($obj->meters) > 0 ): ?>
                                    <?php $__currentLoopData = $obj->meters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input type="number" name="msn[]" value="<?php echo e($meter->msn); ?>" placeholder="Enter Meter Serial Number" class="form-control form-control-sm" required>
                                        </td>
                                        <td>
                                            <input type="text" name="meter_model[]" value="<?php echo e($meter->meter_model); ?>" placeholder="Meter Model" class="form-control form-control-sm" required>
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" name="msn_type[]" class="pb-2">
                                                <?php $__currentLoopData = \App\MeterType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($meter_type->id); ?>" <?php echo e($meter_type->id == $meter->meter_type_id ? 'selected' : ''); ?>><?php echo e($meter_type->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button onclick="removeMeter(this)" type="button" class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <button onclick="addMeter('#meters_table_<?php echo e($uniqid); ?>')" type="button" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus-circle"></i>
                                    Add Meter
                                </button>
                            </div>
                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->

                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Other Information</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="rep">MDC Size*</label>
                                <input type="text" id="mdc_size" name="mdc_size" placeholder="Enter MDC Size"
                                    value="<?php echo e(isset($obj) ? $obj->mdc_size : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">MDC OS Name and Version*</label>
                                <input type="text" id="mdc_os_name_version" name="mdc_os_name_version" placeholder="Enter MDC OS Name and Version"
                                    value="<?php echo e(isset($obj) ? $obj->mdc_os_name_version : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">Meter Firmware Version*</label>
                                <input type="text" id="meter_firmware_version" name="meter_firmware_version" placeholder="Enter Meter Firmware Version"
                                    value="<?php echo e(isset($obj) ? $obj->meter_firmware_version : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">Meter Firmware Size*</label>
                                <input type="text" id="meter_firmware_size" name="meter_firmware_size" placeholder="Enter Meter Firmware Size"
                                    value="<?php echo e(isset($obj) ? $obj->meter_firmware_size : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rep">UDIL Version*</label>

                                <select class="form-control form-control-sm" name="udil_version">
                                    <option value="release 1" <?php echo e(isset($obj) && $obj->udil_version == 'release 1' ? 'selected' : ''); ?>>Release 1</option>
                                    <option value="release 2" <?php echo e(isset($obj) && $obj->udil_version == 'release 2' ? 'selected' : ''); ?>>Release 2</option>
                                    <option value="release 3" <?php echo e(isset($obj) && $obj->udil_version == 'release 3' ? 'selected' : ''); ?>>Release 3.0</option>
                                    <option value="Release 3.1" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.1' ? 'selected' : (!isset($obj) || $obj->udil_version == null ? 'selected' : '' )); ?>>Release 3.1</option>
                                    <option value="Release 3.2" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.2' ? 'selected' : ''); ?>>Release 3.2</option>
                                    <option value="Release 3.3" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.3' ? 'selected' : ''); ?>>Release 3.3</option>
                                    <option value="Release 3.4" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.4' ? 'selected' : ''); ?>>Release 3.4</option>
                                    <option value="Release 3.5" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.5' ? 'selected' : ''); ?>>Release 3.5</option>
                                    <option value="Release 3.6" <?php echo e(isset($obj) && $obj->udil_version == 'Release 3.6' ? 'selected' : ''); ?>>Release 3.6</option>
									<option value="Release 4.0" <?php echo e(isset($obj) && $obj->udil_version == 'Release 4' ? 'selected' : ''); ?>>Release 4.0</option>
                                   
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rep">Tender Number*</label>
                                <input type="text" id="tender_number" name="tender_number" placeholder="Enter Tender Number"
                                    value="<?php echo e(isset($obj) ? $obj->tender_number : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->

                </div>
                <!-- col-md-6 -->
            </div>
            <!-- row -->

            <div class="row">

                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Reading Profile Credentials</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="rd_profile_type">PROFILE TYPE*</label>
                                <select class="form-control form-control-sm" name="rd_profile_type" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\CommunicationProfileType::where('is_read', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $communication_profile_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($communication_profile_type->id); ?>"
                                        <?php echo e(isset($obj) && $obj->readCommunicationProfile->communication_profile_type_id == $communication_profile_type->id ? 'selected' : ''); ?>><?php echo e($communication_profile_type->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rd_protocol">PROTOCOL/TYPE*</label>
                                <select class="form-control form-control-sm" name="rd_protocol" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\Protocol::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $protocol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($protocol->id); ?>"
                                        <?php echo e(isset($obj) && $obj->readCommunicationProfile->protocol_id == $protocol->id ? 'selected' : ''); ?>><?php echo e($protocol->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rd_host">Host/IP*</label>
                                <input type="text" id="rd_host" name="rd_host" placeholder="Enter Host/IP Information" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->host : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div id="read-database-fields">
                                <div class="form-group">
                                    <label for="rd_port">Port*</label>
                                    <input type="number" id="rd_port" name="rd_port" placeholder="Enter Port Number" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->port : ''); ?>" class="form-control form-control-sm" class="required">
                                </div>

                                <div class="form-group">
                                    <label for="rd_database">Database</label>
                                    <input type="text" id="rd_database" name="rd_database" placeholder="Enter Database Name" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->database : ''); ?>" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rd_user">Username*</label>
                                <input type="text" id="rd_user" name="rd_user" placeholder="Enter Valid Username" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->username : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="rd_pwd">Password</label>
                                <input type="text" id="rd_pwd" name="rd_pwd" placeholder="Enter Valid Password" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->password : ''); ?>" class="form-control form-control-sm">
                            </div>

                            <div id="read-api-fields">
                                <div class="form-group">
                                    <label for="rd_code">Code</label>
                                    <input type="text" id="rd_code" name="rd_code" placeholder="Enter Code" value="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->code : ''); ?>" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->
                </div>
                <!-- col-md-6 -->

                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Writing Profile Credentials</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="wr_profile_type">PROFILE TYPE*</label>
                                <select class="form-control form-control-sm" name="wr_profile_type" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\CommunicationProfileType::where('is_write', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $communication_profile_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($communication_profile_type->id); ?>"
                                    <?php echo e(isset($obj) && $obj->writeCommunicationProfile->communication_profile_type_id == $communication_profile_type->id ? 'selected' : ''); ?>><?php echo e($communication_profile_type->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="wr_protocol">PROTOCOL/TYPE*</label>
                                <select class="form-control form-control-sm" name="wr_protocol" required>
                                    <option value="">---</option>
                                    <?php $__currentLoopData = \App\Protocol::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $protocol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($protocol->id); ?>"
                                        <?php echo e(isset($obj) && $obj->writeCommunicationProfile->protocol_id == $protocol->id ? 'selected' : ''); ?>><?php echo e($protocol->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="wr_host">Host Address (http://host:port/path)</label>
                                <input type="text" id="wr_host" name="wr_host" placeholder="http://host:port/path" value="<?php echo e(isset($obj) ? $obj->writeCommunicationProfile->host : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="wr_user">Username*</label>
                                <input type="text" id="wr_user" name="wr_user" placeholder="Enter Valid Username" value="<?php echo e(isset($obj) ? $obj->writeCommunicationProfile->username : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                            <div class="form-group">
                                <label for="wr_pwd">Password</label>
                                <input type="text" id="wr_pwd" name="wr_pwd" placeholder="Enter Valid Password" value="<?php echo e(isset($obj) ? $obj->writeCommunicationProfile->password : ''); ?>" class="form-control form-control-sm">
                            </div>

                            <div class="form-group">
                                <label for="wr_code">Code</label>
                                <input type="text" id="wr_code" name="wr_code" placeholder="Enter Code" value="<?php echo e(isset($obj) ? $obj->writeCommunicationProfile->code : ''); ?>" class="form-control form-control-sm" class="required" required>
                            </div>

                        </div>
                        <!-- box-body -->
                    </div>
                    <!-- box -->
                </div>
                <!-- col-md-6 -->

            </div>
            <!-- row -->

            <?php $__env->startComponent('components.submit_button'); ?>
            <?php echo $__env->renderComponent(); ?>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>

    var profileTypes = <?php echo json_encode(\App\CommunicationProfileType::get(), 15, 512) ?>;
    var protocolTypes = <?php echo json_encode(\App\Protocol::get(), 15, 512) ?>;

    $(document).ready(function(){
        var profileType ="<?php echo e(isset($obj) ? $obj->readCommunicationProfile->communication_profile_type_id : ''); ?>";
        submitForm({
            formId: "#form_<?php echo e($uniqid); ?>",
            formDataFunction: function() {
                var formData = new FormData(document.querySelector('#form_<?php echo e($uniqid); ?>'));
                return formData;
            },
            submitUrl: "<?php echo e(isset($obj) ? url('mdc_test_sessions') . '/' . $obj->id : url('mdc_test_sessions')); ?>",
            successfulCallback: function(data) {
                window.location.href = "<?php echo e(url('tests')); ?>" + '/' + data.id;
            },
            failureCallback: null,
            alwaysCallback: null,
        });

        setProtocolType('[name="rd_profile_type"]', '[name="rd_protocol"]');
        setProtocolType('[name="wr_profile_type"]', '[name="wr_protocol"]');
        $('[name="rd_profile_type"]').trigger('change');

        $('[name="rd_profile_type"]').change(function(){
            setProtocolType('[name="rd_profile_type"]', '[name="rd_protocol"]');
            var profileTypeIdt = getProfileTypeIdtById($(this).val());

            if(profileTypeIdt == 'database')
            {
                $('[for="rd_host"]').text( 'Host/IP*' );
                $('#read-database-fields').show('fast');
                $('#read-api-fields').hide('fast');
            }
            else
            {
                $('[for="rd_host"]').text( 'Host Address (http://host:port/path)' );
                $('#read-database-fields').hide('fast');
                $('#read-api-fields').show('fast');
            }
        });
        if(profileType == 'e1360a90-63a3-11ea-aec1-b1b0e3c2fc26'){
            $('[for="rd_host"]').text( 'Host/IP*' );
                $('#read-database-fields').show('fast');
                $('#read-api-fields').hide('fast');
        }else{
            $('[for="rd_host"]').text( 'Host Address (http://host:port/path)' );
                $('#read-database-fields').hide('fast');
                $('#read-api-fields').show('fast');
        }

        $('[name="wr_profile_type"]').change(function(){
            setProtocolType('[name="wr_profile_type"]', '[name="wr_protocol"]');
        });

    });

    function setProtocolType(profileTypeInputSelector, protocolTypeInputSelector)
    {
        var initialValue = $(protocolTypeInputSelector).val();
        $(protocolTypeInputSelector).empty();

        var profile_type_id = $(profileTypeInputSelector).val();
        var profile_type_idt = getProfileTypeIdtById(profile_type_id);

        var filteredProtocols = protocolTypes.filter(function(protocolType){
            return protocolType.communication_profile_type_idt == profile_type_idt;
        });

        $(protocolTypeInputSelector).append('<option value="">---</option>');
        filteredProtocols.forEach(function(item){
            $(protocolTypeInputSelector).append('<option value="'+item.id+'">'+item.name+'</option>');
        });

        if( initialValue != null || initialValue != '' ) {
            $(protocolTypeInputSelector).val(initialValue);
        }
    }

    function getProfileTypeIdtById(profileTypeId)
    {
        var foundProfileType = profileTypes.find(function(profileType){
            return profileType.id == profileTypeId;
        });

        return foundProfileType != null ? foundProfileType.idt : null;
    }

    function addMeter(tableId) {
        $(tableId + " tbody").append(
            `<tr>
                <td>
                    <input type="number" name="msn[]" value="" placeholder="Enter Meter Serial Number" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="text" name="meter_model[]" value="" placeholder="Meter Model" class="form-control form-control-sm" required>
                </td>
                <td>
                    <select class="form-control form-control-sm" name="msn_type[]" class="pb-2">
                        <?php $__currentLoopData = \App\MeterType::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meter_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($meter_type->id); ?>"><?php echo e($meter_type->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </td>
                <td>
                    <button onclick="removeMeter(this)" type="button" class="btn btn-sm btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>`
        );
    }

    function removeMeter(button) {
        $(button).closest('tr').remove();
    }

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-7.4.30\htdocs\udil\resources\views/mdc_test_sessions/add_edit.blade.php ENDPATH**/ ?>