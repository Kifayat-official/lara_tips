<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\TestProfile;
use App\TestGroup;
use App\TestProfileMandatoryColumn;
use DB;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class TestProfileController extends CommonController
{
    function __construct() {
        parent::__construct('test_profiles', '\App\TestProfile', [],
        [
            'add_permission' => 'add_udil_checklist',
            'edit_permission' => 'edit_udil_checklist',
            'delete_permission' => 'delete_udil_checklist',
            'list_permission' => 'udil_checklists_list',
        ]);
    }

    public function dataTable()
    {
        $test_profiles = TestProfile::query();

        return DataTables::eloquent($test_profiles)
            ->addColumn('action', function($row){

                $download_checklist_button = '';

                if($row->checklist_file != '' && $row->checklist_file != null)
                {
                    $download_checklist_button = '<a target="_blank" href="' . url('download_checklist') . '/' . $row->checklist_file . '" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download Checklist</a>';
                }

                $duplicate_button = '<a href="' . url('duplicate_test_profile') . '/' . $row->id . '" class="btn btn-sm btn-warning"><i class="fa fa-copy"></i> Duplicate</a>';

                $edit_button = $this->generateEditButton($row);
                $delete_button = $this->generateDeleteButton($row);

                return $download_checklist_button . $duplicate_button . $edit_button . $delete_button;
            })
            ->toJson();
    }

    public function additionalDataForCreate()
    {
        return $this->additionalData();
    }

    public function additionalDataForEdit($id)
    {
        return $this->additionalData();
    }

    public function additionalData()
    {
        $test_groups = TestGroup::with(['tests.defaultColumns'])->get();
        return compact('test_groups');
    }

    public function storeData()
    {
        $this->saveData(null);
    }

    public function updateData($id)
    {
        $this->saveData($id);
    }

    public function validateRequest($id)
    {
        request()->validate([
            'name' => 'required',
            'checklist_file' => 'mimes:doc,docx,pdf|file|max:2048'
        ]);
    }

    public function saveData($id)
    {
        $test_profile = $id == null ? new TestProfile() : TestProfile::find($id);
        $test_profile->name = request()->name;

        if(request()->has('checklist_file') && request()->file('checklist_file') != null)
        {
            $file_path = 'checklists';
            $file = request()->file('checklist_file');
            $new_name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('/' . $file_path, $new_name, 'uploads');
            $test_profile->checklist_file = $file_path . '/' . $new_name;
        }
        else if(request()->has('is_checklist_file_deleted') && request()->is_checklist_file_deleted == '1')
        {
            $test_profile->checklist_file = '';
        }

        $test_profile->save();

        $tests = request()->tests;
        
        DB::table('test_profile_tests')->where('test_profile_id', $test_profile->id)->delete();
        foreach($tests as $test)
        {
            $test_profile_test_id = (string) Uuid::generate(4);
            DB::table('test_profile_tests')
                ->insert([
                    'id' => $test_profile_test_id,
                    'test_profile_id' => $test_profile->id,
                    'test_id' => $test,
                ]);

            $mandatory_columns = request()->mandatory_columns;

            if(isset($mandatory_columns[$test]))
            {
                $test_mandatory_columns = $mandatory_columns[$test];
                foreach($test_mandatory_columns as $mandatory_column)
                {
                    $test_profile_mandatory_column = new TestProfileMandatoryColumn();
                    $test_profile_mandatory_column->test_profile_test_id = $test_profile_test_id;
                    $test_profile_mandatory_column->column_name = $mandatory_column;
                    $test_profile_mandatory_column->save();
                }
            }
        }
    }

    public function downloadChecklist($file_name)
    {
        return Storage::disk('uploads')->download('checklists/' . $file_name);
    }

    public function duplicateTestProfile($test_profile_id)
    {
        \DB::beginTransaction();
        $test_profile = \App\TestProfile::find($test_profile_id);

        $cloned_test_profile = $test_profile->replicate();
        $cloned_test_profile->name = $cloned_test_profile->name . '_duplicate';
        $cloned_test_profile->save();


        foreach($test_profile->tests as $test)
        {
            $cloned_test_profile_test_id = (string) Uuid::generate(4);
            \DB::table('test_profile_tests')->insert([
                'id' => $cloned_test_profile_test_id,
                'test_profile_id' => $cloned_test_profile->id,
                'test_id' => $test->id
            ]);

            $mandatory_columns = \DB::table('test_profile_mandatory_columns')
                ->where('test_profile_test_id', $test->pivot->id)
                ->get();

            foreach($mandatory_columns as $mandatory_column)
            {
                $cloned_test_profile_mandatory_column = new TestProfileMandatoryColumn;
                $cloned_test_profile_mandatory_column->test_profile_test_id = $cloned_test_profile_test_id;
                $cloned_test_profile_mandatory_column->column_name = $mandatory_column->column_name;
                $cloned_test_profile_mandatory_column->save();
            }
        }
        \DB::commit();

        return redirect('test_profiles/'.$cloned_test_profile->id.'/edit');
    }
}
