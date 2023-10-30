<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->uuid('id'); $table->primary('id');

            $table->uuid('test_group_id');
            $table->integer('order');
            $table->string('idt')->unique();
            $table->string('name');
            $table->uuid('test_type_id');
            $table->string('table_name')->nullable();
            $table->string('service')->nullable();

            CommonMigrations::five($table);
        });

        DB::table('tests')
            ->insert([
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 0, 'idt' => 'reading_stored_instantaneous_data', 'name' => 'Reading Stored Instantaneous Data', 'table_name' => 'instantaneous_data', 'service' => 'instantaneous_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 1, 'idt' => 'reading_stored_billing_data', 'name' => 'Reading Stored Billing Data', 'table_name' => 'billing_data', 'service' => 'billing_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 2, 'idt' => 'reading_stored_monthly_billing_data', 'name' => 'Reading Stored Monthly Billing Data', 'table_name' => 'monthly_billing_data', 'service' => 'monthly_billing_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 3, 'idt' => 'reading_stored_load_profile_data_0', 'name' => 'Reading Stored Load Profile Data 0', 'table_name' => 'load_profile_data', 'service' => 'load_profile_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 4, 'idt' => 'reading_stored_load_profile_data_1', 'name' => 'Reading Stored Load Profile Data 1', 'table_name' => 'load_profile_data', 'service' => 'load_profile_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 5, 'idt' => 'reading_stored_load_profile_data_2', 'name' => 'Reading Stored Load Profile Data 2', 'table_name' => 'load_profile_data', 'service' => 'load_profile_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 6, 'idt' => 'reading_stored_load_profile_data_3', 'name' => 'Reading Stored Load Profile Data 3', 'table_name' => 'load_profile_data', 'service' => 'load_profile_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 7, 'idt' => 'reading_stored_load_profile_data_4', 'name' => 'Reading Stored Load Profile Data 4', 'table_name' => 'load_profile_data', 'service' => 'load_profile_data'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 8, 'idt' => 'reading_stored_events_data', 'name' => 'Reading Stored Events Data', 'table_name' => 'events', 'service' => 'events'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 9, 'idt' => 'reading_meter_visuals', 'name' => 'Reading Meter Visuals', 'table_name' => 'meter_visuals', 'service' => 'meter_visuals'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10f4da-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 10, 'idt' => 'reading_device_communication_history', 'name' => 'Reading Device Communication History', 'table_name' => 'device_communication_history', 'service' => 'device_communication_history'],
                
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 100, 'idt' => 'transaction_status_read', 'name' => 'Transaction Status Read', 'table_name' => 'transaction_status', 'service' => 'transaction_status'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 101, 'idt' => 'transaction_cancel', 'name' => 'Transaction Cancel', 'table_name' => null, 'service' => 'transaction_cancel'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 102, 'idt' => 'on_demand_data_read_inst', 'name' => 'On Demand Data Read (Instantaneous Data)', 'table_name' => null, 'service' => 'on_demand_data_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 103, 'idt' => 'on_demand_data_read_bill', 'name' => 'On Demand Data Read (Billing Profiles)', 'table_name' => null, 'service' => 'on_demand_data_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 104, 'idt' => 'on_demand_data_read_mbil', 'name' => 'On Demand Data Read (Monthly Billing Profile)', 'table_name' => null, 'service' => 'on_demand_data_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 105, 'idt' => 'on_demand_data_read_lpro', 'name' => 'On Demand Data Read (Load Profile)', 'table_name' => null, 'service' => 'on_demand_data_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 106, 'idt' => 'on_demand_data_read_evnt', 'name' => 'On Demand Data Read (Events)', 'table_name' => null, 'service' => 'on_demand_data_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 107, 'idt' => 'on_demand_parameter_read_auxr', 'name' => 'On Demand Parameter Read (Auxiliary Relay Status)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 108, 'idt' => 'on_demand_parameter_read_dvtm', 'name' => 'On Demand Parameter Read (Device Time)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 109, 'idt' => 'on_demand_parameter_read_sanc', 'name' => 'On Demand Parameter Read (Programmed Sanctioned Load)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 110, 'idt' => 'on_demand_parameter_read_lsch', 'name' => 'On Demand Parameter Read (Programmed Load Shedding Schedule)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 111, 'idt' => 'on_demand_parameter_read_tiou', 'name' => 'On Demand Parameter Read (Programmed Time of Use)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 112, 'idt' => 'on_demand_parameter_read_ippo', 'name' => 'On Demand Parameter Read (Programmed IP & Port)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 113, 'idt' => 'on_demand_parameter_read_mdsm', 'name' => 'On Demand Parameter Read (Programmed Meter Data Sampling)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 114, 'idt' => 'on_demand_parameter_read_oppo', 'name' => 'On Demand Parameter Read (Programmed Optical Port)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 115, 'idt' => 'on_demand_parameter_read_wsim', 'name' => 'On Demand Parameter Read (Programmed Wake-up SIM Number)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 116, 'idt' => 'on_demand_parameter_read_mtst', 'name' => 'On Demand Parameter Read (Meter Status)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fb74-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 117, 'idt' => 'on_demand_parameter_read_dmdt', 'name' => 'On Demand Parameter Read (Device Meta Data)', 'table_name' => null, 'service' => 'on_demand_parameter_read'],
                
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 200, 'idt' => 'authorization_service', 'name' => 'Authorization Service', 'table_name' => null, 'service' => 'authorization_service'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 201, 'idt' => 'create_device_meter', 'name' => 'Create Device / Meter', 'table_name' => null, 'service' => 'device_creation'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 202, 'idt' => 'aux_relay_operations', 'name' => 'Aux Relay Operations', 'table_name' => null, 'service' => 'aux_relay_operations'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 203, 'idt' => 'time_synchronization', 'name' => 'Time Synchronization', 'table_name' => null, 'service' => 'time_synchronization'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 204, 'idt' => 'sanctioned_load_control', 'name' => 'Sanctioned Load Control', 'table_name' => null, 'service' => 'sanctioned_load_control'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 205, 'idt' => 'load_shedding_scheduling', 'name' => 'Load Shedding Scheduling', 'table_name' => null, 'service' => 'load_shedding_scheduling'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 206, 'idt' => 'time_of_use_change', 'name' => 'Time of Use Change', 'table_name' => null, 'service' => 'update_time_of_use'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 207, 'idt' => 'update_ip_port', 'name' => 'Update IP & Port', 'table_name' => null, 'service' => 'update_ip_port'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 208, 'idt' => 'meter_data_sampling', 'name' => 'Meter Data Sampling', 'table_name' => null, 'service' => 'meter_data_sampling'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 209, 'idt' => 'activate_meter_optical_port', 'name' => 'Activate Meter Optical Port', 'table_name' => null, 'service' => 'activate_meter_optical_port'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 210, 'idt' => 'update_wake_up_sim_number', 'name' => 'Update Wake Up Sim Number', 'table_name' => null, 'service' => 'update_wake_up_sim_number'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 211, 'idt' => 'update_meter_status', 'name' => 'Update Meter Status', 'table_name' => null, 'service' => 'update_meter_status'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 212, 'idt' => 'update_device_metadata', 'name' => 'Update Device Metadata', 'table_name' => null, 'service' => 'update_device_metadata'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 213, 'idt' => 'apms_tripping_events', 'name' => 'APMS TRIPPING EVENTS', 'table_name' => null, 'service' => 'apms_tripping_events'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 214, 'idt' => 'update_mdi_reset_date', 'name' => 'Update MDI Reset Date', 'table_name' => null, 'service' => 'update_mdi_reset_date'],
                [ 'id' => Uuid::generate(), 'test_type_id' => '5e10fa02-fc9d-11e9-8f0b-362b9e155667', 'test_group_id' => '72adb2fe-f80e-11e9-8f0b-362b9e155667', 'order' => 215, 'idt' => 'parameterization_cancellation', 'name' => 'Parameterization Cancellation', 'table_name' => null, 'service' => 'parameterization_cancellation'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
