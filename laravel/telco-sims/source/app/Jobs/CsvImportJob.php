<?php

namespace App\Jobs;

use App\Models\Sim;
use App\Helpers\Utils;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CsvImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */

    public function handle()
    {
        try {
            foreach ($this->data as $row) {
                Sim::create(
                    [
                        'sim_id' => Utils::cleanString($row[5]),
                        'sim_no' => Utils::cleanString($row[4]),
                        'msn_no' => Utils::cleanString($row[2]),
                        'project_name' => Utils::cleanString($row[6]),
                        'telco_name' => Utils::cleanString($row[3]),
                        'disco_name' => Utils::getDiscoNameByCode(substr($row[1], 2, 2)),
                        // 'po_no' => 1,
                        // 'po_date' => null,
                        // 'status' => 1
                    ]
                );
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed during database insertion with message: ' . $e->getMessage());
        }

    }

    // public function failed(Throwable $exception)
    // {
    //     // Send user notification of failure, etc...
    // }
}