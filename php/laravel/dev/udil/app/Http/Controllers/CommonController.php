<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class CommonController extends Controller
{
    public $views_folder = '';
    public $model = '';
    public $model_relations = [];
    public $permissions = [];

    function __construct($_views_folder, $_model, $_model_relations, $_permissions) {
        $this->views_folder = $_views_folder;
        $this->model = $_model;
        $this->model_relations = $_model_relations;
        $this->permissions = $_permissions;
        $this->initialize();
    }

    // override this method in child class for any initialization code
    public function initialize()
    {

    }

    public function generateEditButton($row)
    {

        $btn = '<button onclick="editItem(\''.$row->id.'\')" class="btn btn-sm btn-info">
                    <i class="fa fa-edit"></i>
                    Edit
                </button>';

        if( ! Auth::user()->hasPermission($this->permissions['edit_permission']) )
        {
            $btn = '';
        }

        return $btn;
    }

    public function generateDeleteButton($row)
    {

        $btn = '<button onclick="deleteItem(\''.$row->id.'\', this)" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash"></i>
                    Delete
                </button>';

        if( ! Auth::user()->hasPermission($this->permissions['delete_permission']) )
        {
            $btn = '';
        }

        return $btn;
    }

    public function index()
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['list_permission']);

        return view( $this->views_folder . '.list');
    }

    public function destroy($id)
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['delete_permission']);
        if($this->model == '\App\Role')
        {
            $roles = $this->model::find($id);
            $roles->permissions()->detach();
        }
        if($this->model == '\App\User')
        {
            $user = $this->model::find($id);
            $found_user = DB::table('users')->where('id',$user->id)->value('id');
            DB::table('mdc_selections')->where('role_id',$found_user)->delete();
        }
        $this->model::destroy($id);
    }

    public function edit($id)
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['edit_permission']);

        $obj = $this->model::with($this->model_relations)->find($id);
        $additional_data = $this->additionalDataForEdit($id);
        if($this->views_folder == 'users')
        {
            $mdc = [];
            foreach($additional_data['roles'] as $role)
            {
                if(DB::table('perm_role')->where('role_id',$role->id)
                ->where('perm_id','ac915bda-3c55-4945-9b6e-2e1e32e4d5ce')
                 ->value('role_id') != null){
                    $mdc[]= DB::table('perm_role')->where('role_id',$role->id)
                                                ->where('perm_id','ac915bda-3c55-4945-9b6e-2e1e32e4d5ce')
                                                    ->value('role_id');
                 }
            }
            return view( $this->views_folder . '.add_edit', compact('obj','additional_data','mdc'));

        }
        return view( $this->views_folder . '.add_edit', compact('obj', 'additional_data'));
    }

    // override this method in child class to profide additional data in edit form
    public function additionalDataForEdit($id)
    {
        return [];
    }

    public function create()
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['add_permission']);
        $additional_data = $this->additionalDataForCreate();
        if($this->views_folder == 'users')
        {
            $mdc = [];
            foreach($additional_data['roles'] as $role)
            {
                if(DB::table('perm_role')->where('role_id',$role->id)
                ->where('perm_id','ac915bda-3c55-4945-9b6e-2e1e32e4d5ce')
                 ->value('role_id') != null){
                    $mdc[]= DB::table('perm_role')->where('role_id',$role->id)
                                                ->where('perm_id','ac915bda-3c55-4945-9b6e-2e1e32e4d5ce')
                                                    ->value('role_id');
                 }
            }
            return view( $this->views_folder . '.add_edit', compact('additional_data','mdc'));

        }
        return view( $this->views_folder . '.add_edit', compact('additional_data'));

    }

    // override this method in child class to profide additional data in create form
    public function additionalDataForCreate()
    {
        return [];
    }


    public function store()
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['add_permission']);

        $this->validateRequest(null);
        try {
            DB::beginTransaction();
            $id = $this->storeData();
            DB::commit();
            return ['success' => true, 'message' => 'Saved successfully', 'id' => $id];
        } catch (\Exception $ex) {
            return ['success' => false, 'message' => 'Error occurred: ' . $ex->getMessage(), 'exception' => $ex->getTraceAsString()];
        }
    }

    public function update($id)
    {
        Auth::user()->abortIfDontHavePermission($this->permissions['edit_permission']);

        $this->validateRequest($id);
        try {
            DB::beginTransaction();
            $this->updateData($id);
            DB::commit();
            return ['success' => true, 'message' => 'Saved successfully', 'id' => $id];
        } catch (\Exception $ex) {
            return ['success' => false, 'message' => 'Error occurred: ' . $ex->getMessage(), 'exception' => $ex->getTraceAsString()];
        }
    }

    public function storeData()
    {
        throw new \Exception("override storeData method in derived class", 1);
    }

    public function updateData($id)
    {
        throw new \Exception("override updateData method in derived class", 1);
    }

    public function validateRequest($id)
    {
        # code...
    }

    protected function applyFilters($data)
    {

        if(!request()->has('filters') || (request()->has('filters') && count(request()->filters) == 0 ) )
        {
            return $data;
        }

        $filters = request()->filters;

        foreach($filters as $filter)
        {
            $filter_parts = explode('.', $filter['relation_and_column']);
            $relations = '';
            $column = '';

            if( count($filter_parts) == 1 )
            {
                $column = $filter_parts[0];
            }
            else
            {
                $column = $filter_parts[ count($filter_parts) - 1 ];
                array_pop($filter_parts);
                $relations = implode('.', $filter_parts);
            }

            if($relations != '' && $column != '')
            {
                $data = $data->whereHas($relations, function($query) use($filter, $column) {
                    $query->where($column, $filter['value']);
                });
            }
            else if($column != '')
            {
                $data = $data->where($column, $filter['value']);
            }
        }

        return $data;
    }
}
