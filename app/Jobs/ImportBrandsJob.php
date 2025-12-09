<?php

namespace App\Jobs;

use App\Models\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportBrandsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $filePath,
        protected string $action,
        protected ?int $userId = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if file exists
        if (!Storage::exists($this->filePath)) {
            throw new \Exception("File not found: {$this->filePath}");
        }

        $file = Storage::get($this->filePath);
        
        // Split by newline and filter empty lines
        $lines = array_filter(explode("\n", $file), fn($line) => trim($line) !== '');
        
        if (empty($lines)) {
            Storage::delete($this->filePath);
            throw new \Exception('CSV file is empty');
        }

        $rows = array_map('str_getcsv', $lines);
        $header = array_shift($rows);

        if (empty($header)) {
            Storage::delete($this->filePath);
            throw new \Exception('CSV header is missing');
        }

        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (empty($row) || empty($row[0])) {
                continue;
            }

            // Ensure row has same number of columns as header
            if (count($row) !== count($header)) {
                Log::warning("Row {$index} has mismatched columns. Expected: " . count($header) . ", Got: " . count($row));
                continue;
            }

            $data = array_combine($header, $row);

            // Validate required fields
            if (empty($data['name'])) {
                Log::warning("Row {$index} missing required 'name' field");
                continue;
            }

            // Prepare brand data
            $brandData = [
                'name' => $data['name'],
                'slug' => !empty($data['slug']) ? $data['slug'] : Str::slug($data['name']),
                'details' => $data['details'] ?? null,
                'website' => $data['website'] ?? null,
                'image' => $data['image'] ?? null,
                'is_active' => isset($data['is_active']) ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) : true,
                'is_feature' => isset($data['is_feature']) ? filter_var($data['is_feature'], FILTER_VALIDATE_BOOLEAN) : false,
            ];

            try {
                if ($this->action === 'upsert') {
                    Brand::updateOrCreate(
                        ['slug' => $brandData['slug']],
                        $brandData
                    );
                } else {
                    Brand::create($brandData);
                }
            } catch (\Exception $e) {
                Log::error("Failed to import brand at row {$index}: " . $e->getMessage());
            }
        }

        // Clean up the file
        Storage::delete($this->filePath);
    }
}
