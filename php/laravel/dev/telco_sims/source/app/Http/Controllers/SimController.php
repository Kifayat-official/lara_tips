<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use App\Jobs\CsvImportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\Datatables;

class SimController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Sim::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $csrfToken = csrf_token();
                    $actionBtn =
                        "<form action='/sims/$row->id/destroy' method='POST'>
                            <a class='btn btn-primary' href='/sims/$row->id/edit'>Edit</a>
                            <input type='hidden' name='_token' value='$csrfToken'> 
                            <input type='hidden' name='_method' value='DELETE'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sims.index');
        // $sims = Sim::latest()->paginate(25);

        // // echo '<pre>';
        // // print_r($sims->toArray());

        // return view('sims.index', compact('sims'))
        //     ->with('i', (request()->input('page', 1) - 1) * 25);
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

    public function import()
    {
        try {
            request()->validate([
                'csv_file' => 'required|mimes:csv',
            ]);
            // 'csv_file' => 'required|mimetypes:text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

            if (request()->has('csv_file')) {
                $data = file(request()->csv_file);
                $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);

                // Chunking file
                $chunks = array_chunk($data, 1000);
                $rowCount = 0;

                $batch = Bus::batch([])->dispatch();

                foreach ($chunks as $key => $chunk) {
                    $data = array_map('str_getcsv', $chunk);

                    if ($key === 0) {
                        unset($data[0]);
                    }

                    // Update row count
                    $rowCount += count($data);

                    //CsvImportJob::dispatch($data);

                    $batch->add(new CsvImportJob($data));
                }

                // return redirect()->back()->with('success', "{$rowCount} records imported successfully");

                // return $batch;

                return response()->json([
                    'total_records_imported' => $rowCount,
                    'message' => "{$rowCount} records imported successfully"
                ], 200);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed during batching in SimController: ' . $e->getMessage());
        }
    }

    public function import_progress()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }

    public function import2(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv',
        ]);
        if ($request->hasFile('csv_file')) {
            $data = file($request->csv_file);
            $header = $data[0];
            unset($data[0]);

            // chunking file
            $chunks = array_chunk($data, 1000);

            // convert each chunk into new csv file
            foreach ($chunks as $key => $chunk) {
                $name = "/temp{$key}.csv";
                $path = resource_path("temp");
                file_put_contents($path . $name, $chunk);
            }
        }
    }
    public function import1(Request $request)
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

    public function welcome()
    {
        return view("welcome");
    }
}
