<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use DataTables;

class CompanyController extends CommonController
{
    function __construct() {
        parent::__construct(
            'companies', 
            '\App\Company', 
            [], 
            [
                'add_permission' => 'add_company',
                'edit_permission' => 'edit_company',
                'delete_permission' => 'delete_company',
                'list_permission' => 'companies_list',
            ]);
    }

    public function dataTable()
    {
        $companies = Company::query();

        return DataTables::eloquent($companies)
            ->addColumn('action', function($row){
                $edit_button = $this->generateEditButton($row);
                $delete_button = $this->generateDeleteButton($row);

                return $edit_button . $delete_button;
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
        // $test_groups = TestGroup::with(['tests.defaultColumns'])->get();
        
        // return compact('test_groups');
    }

    public function storeData()
    {
        return $this->saveData(null);
    }

    public function updateData($id)
    {
        return $this->saveData($id);
    }

    public function validateRequest($id)
    {
        request()->validate([
            'name' => 'required|unique:companies,name,' . $id,
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
    }

    public function saveData($id)
    {
        $company = $id == null ? new Company() : Company::find($id);
        $company->name = request()->name;
        $company->address = request()->address;
        $company->phone = request()->phone;
        $company->email = request()->email;
        $company->save();

        return $company->id;
    }
}