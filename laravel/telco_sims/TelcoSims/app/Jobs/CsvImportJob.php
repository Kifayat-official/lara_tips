<?php

namespace App\Jobs;

use App\Models\Sim;
use App\Helpers\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $csvData = array_map('str_getcsv', file($this->filePath));
        // Log::debug('csvData Path', [$csvData]);
        // $skipFirstRow = true;
        foreach ($csvData as $row) {
            // if ($skipFirstRow) {
            //     // Skip the first row
            //     $skipFirstRow = false;
            //     continue;
            // }
            unset($csvData[0]);
            try {
                Sim::create([
                    'sim_id' => Utils::cleanString($row[5]),
                    'sim_no' => Utils::cleanString($row[4]),
                    'msn_no' => Utils::cleanString($row[2]),
                    'project_name' => Utils::cleanString($row[6]),
                    'telco_name' => Utils::cleanString($row[3]),
                    'disco_name' => Utils::getDiscoNameByCode(substr($row[1], 2, 2)),
                    // 'po_no' => 1,
                    // 'po_date' => null,
                    // 'status' => 1
                ]);
            } catch (\Exception $e) {
                echo '<pre>';
                print_r($e->getMessage());
                die();
                return redirect()->back()->with('error', 'An error occurred during CSV import: ' . $e->getMessage());
            }
        }
        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }
}
