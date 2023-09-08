<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use App\Helpers\Utils;
use App\Jobs\CsvImportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimController extends Controller
{
    public function index()
    {
        $sims = Sim::latest()->paginate(25);

        // echo '<pre>';
        // print_r($sims->toArray());

        return view('sims.index', compact('sims'))
            ->with('i', (request()->input('page', 1) - 1) * 25);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Sims.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'detail' => 'required',
        // ]);

        $requestData = $request->except('_token');
        if ($request->rec_id) {

            $sim = Sim::find($request->rec_id);
            $sim->update($requestData);
            return redirect()->route('sims.index')
                ->with('success', 'Sim updated successfully.');
        } else {
            Sim::create($requestData);
            return redirect()->route('sims.index')
                ->with('success', 'Sim created successfully.');
        }
    }
    /**
     * Display the specified resource.
     */
    // public function show(Sim $Sim)
    // {
    //     return view('Sims.show', compact('Sim'));
    // }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sim $sim)
    {
        return view('sims.create', compact('sim'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sim $Sim)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
        $Sim->update($request->all());
        return redirect()->route('Sims.index')
            ->with('success', 'Sim updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sim $Sim)
    {
        $Sim->delete();
        return redirect()->route('sims.index')
            ->with('success', 'Sim deleted successfully');
    }

    public function show()
    {
        return view('csv.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv',
        ]);
        if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $filePath = $file->getPathName();

            // Dispatch the job to the queue
            CsvImportJob::dispatch($filePath); //->onQueue('csv_import');

            return redirect()->back()->with('success', 'CSV import job has been queued. It will be processed in the background.');
        }
        return redirect()->back()->with('error', 'Failed to import CSV file.');
    }

    // public function import(Request $request)
    // {
    //     if ($request->has('csv_file')) {

    //         $csv    = file($request->csv_file);
    //         $chunks = array_chunk($csv, 1000);
    //         // $header = [];

    //         foreach ($chunks as $key => $chunk) {
    //             $data = array_map('str_getcsv', $chunk);
    //             if ($key == 0) {
    //                 // $header = $data[0];
    //                 unset($data[0]);
    //             }

    //             CsvImportJob::dispatch($data);
    //         }
    //     }
    //     return "please upload CSV file";
    // }
}
