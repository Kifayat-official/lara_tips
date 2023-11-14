<?php

namespace App;

class SelectHelper
{
    public static $device_types = [
		1 => 'meter',
		2 => 'DCU',
		3 => 'other',
	];

	public static $data_types = [
		'INST' => 'Instantaneous Data',
		'BILL' => 'Billing Profile',
		'LPRO' => 'Load Profile',
	];

	public static $communication_modes = [
		1 => 'GPRS/3G/4G',
		2 => 'RF',
		3 => 'PLC',
		4 => 'Ethernet',
		5 => 'other'
	];

	public static $communication_types = [
		1 => 'Mode-I/Non-Keepalive',
		2 => 'Mode-II/Keep-alive'
		// 0 => 'always on',
		// 1 => 'periodic-on',
		// 2 => 'on-demand',
		// 3 => 'other'
	];

	public static $types_for_apms = [
		'OVFC' => 'Over Voltage Function',
		'UVFC' => 'Under Voltage Function',
		'OCFC' => 'Over Current Function',
		'OLFC' => 'Over Load Function',
		'PFFC' => 'Phase Failure Function',
		'VUFC' => 'Voltage Unbalance Function',
		'CUFC' => 'Current Unbalance Function',
		'HAPF' => 'High Apparent Power Function',
	];

	public static $enable_tripping_for_apms=[
		0 => 'Disable',
        1 => 'Enable',
	];

	public static $phases = [
		1 => 'Single',
		3 => 'Three-phase'
	];

	public static $meter_types = [
		1 => 'Normal',
		2 => 'Whole Current',
		3 => 'CTO',
		4 => 'CTPT'
    ];

    public static $relay_operations = [
        0 => 'Off',
        1 => 'On',
	];
	
	public static $yes_no = [
        0 => 'No',
        1 => 'Yes',
    ];

    public static $meter_activation_statuses = [
        0 => '0',
        1 => '1',
    ];

	public static $types_for_parameterization_cancellation = [
		'SANC' => 'Programmed Sanctioned Load',
		'LSCH' => 'Programmed Load Shedding Schedule',
		'TIOU' => 'Programmed Time of Use',
		'OVVP' => 'Over Voltage Parameters',
		'UNVP' => 'Under Voltage Parameters',
		'POCP' => 'Phase Over Current Parameters',
		'PFPD' => 'Phase Failure Parameters Data',
		'OLPD' => 'Overloading Parameters Data',
		'VUNP' => 'Voltage Unbalance Parameters',
		'CUNP' => 'Current Unbalance Parameters',
		'HAPP' => 'High Apparent Power Parameters',
	];
    
    public static function createSelect($title, $name, $options, $class, $selected = null)
    {
        $select = '<div class="form-group '.$class.'">
                    <label for="">'.$title.'</label>
                    <select class="form-control" name="'.$name.'">';
        foreach($options as $value => $option_text) 
        {
            $select .= '<option value="'.$value.'" '. ($selected != null && $selected == $value ? 'selected' : '') .' >'.$option_text.'</option>';
        }
                        
        $select .= '</select>
                </div>';

        return $select;
    }
}
