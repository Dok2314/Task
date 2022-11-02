# Company X

### HOW IT WORK

1) Upload file to folder storage/import
2) Use console command:
``php artisan migrate`` - add tables to DB;
``php artisan import:categories`` - import CSV categories from storage/import/Category.csv
``php artisan import:product`` - import CSV products from storage/import/Product.csv
