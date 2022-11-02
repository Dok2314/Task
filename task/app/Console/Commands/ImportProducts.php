<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Schema;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product';

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
        $this->importProductsCSV();
        return 0;
    }

    public function importProductsCSV()
    {
        Log::info('Import products CSV started');
        $this->info('Import products CSV started');

        $keys = [];
        Product::unguard();
        Schema::disableForeignKeyConstraints();

        if (($handle = fopen(storage_path('import/product.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (empty($keys)) {
                    $keys = $data;
                    continue;
                }

                $product         = collect(array_combine($keys, $data))->filter()->toArray();
                $categories      = !empty($product['categories']) ? explode(',', $product['categories']) : [];
                $relatedProducts = !empty($product['related_products']) ? explode(',', $product['related_products']) : [];

                unset($product['categories']);
                unset($product['related_products']);

                $createdProduct = Product::create($product);

                $createdProduct->categories()->sync($categories);
                $createdProduct->relatedProduct()->sync($relatedProducts);
            }

            fclose($handle);
        }


        Log::info('Transferring products CSV finished');
        $this->info("\nTransferring products CSV finished\n");
    }
}
