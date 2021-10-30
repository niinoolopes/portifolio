php artisan make:migration CreateTableFinancaCategoria
php artisan migrate

php artisan make:controller Financa/FinancaItemConsolidadoController --api

php artisan make:model Financa/FinancaItemConsolidadoModel

php artisan make:resource Financa/FinancaCategoriaResource

php artisan make:request Financa/Item/FinancaCategoriaRequestStore
php artisan make:request Financa/Item/FinancaCategoriaRequestupdate
