# Company X

### HOW IT WORK

1) Upload files(Categories.csv, Products.csv) to folder storage/import;
2) Use console command:
- ``php artisan migrate`` - add tables to DB;
- ``php artisan import:categories`` - import CSV categories from storage/import/Categories.csv;
- ``php artisan import:product`` - import CSV products from storage/import/Products.csv;
