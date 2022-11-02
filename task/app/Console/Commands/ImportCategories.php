<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->importCategoriesCSV();
        return 0;
    }

    public function importCategoriesCSV()
    {
        Log::info('Import categories CSV started');
        $this->info('Import categories CSV started');

        $keys = [];
        Category::unguard();
        \Schema::disableForeignKeyConstraints();

        if (($handle = fopen(storage_path('import/category.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (empty($keys)) {
                    $keys = $data;
                    continue;
                }

                $category = array_combine($keys, $data);

                Category::create($category);
            }

            fclose($handle);
        }

        Log::info('Transferring categories CSV finished');
        $this->info("\nTransferring categories CSV finished\n");
    }
}
