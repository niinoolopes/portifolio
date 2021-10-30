<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\v1\Config\Financa\FinancaCarteiraController;
use App\Http\Controllers\v1\Config\Financa\FinancaCategoriaController;
use App\Http\Controllers\v1\Config\Financa\FinancaGrupoController;
use App\Http\Controllers\v1\Financa\FinancaAnaliseController;
use App\Http\Controllers\v1\Financa\FinancaConsolidadoItemController;
use App\Http\Controllers\v1\Financa\FinancaItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('teste', function () {
  return 'teste';
});



Route::prefix('v1')->group(function () {
  
  Route::get('migrate-database', [AssistantController::class, 'migrateDataBase']);

  Route::get('teste', function () {
    return 'teste';
  });

  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout']);

  # middleware
  Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->group(function () {
      // user/data
      Route::get('full-data', [UserController::class, 'fullData']);
      // user
      Route::put('', [UserController::class, 'update']);
    });

    Route::prefix('config')->group(function () {
      // v1/config/financa
      Route::prefix('financa')->group(function () {

        // v1/config/financa/carteira
        Route::prefix('carteira')->group(function () {
          Route::get('', [FinancaCarteiraController::class, 'index']);
          Route::get('/{fnct_id}', [FinancaCarteiraController::class, 'show']);
          Route::post('', [FinancaCarteiraController::class, 'store']);
          Route::put('/{fnct_id}', [FinancaCarteiraController::class, 'update']);
        });

        // v1/config/financa/grupo
        Route::prefix('grupo')->group(function () {
          Route::get('', [FinancaGrupoController::class, 'index']);
          Route::get('/{fngp_id}', [FinancaGrupoController::class, 'show']);
          Route::post('', [FinancaGrupoController::class, 'store']);
          Route::put('/{fngp_id}', [FinancaGrupoController::class, 'update']);
        });

        // v1/config/financa/categoria
        Route::prefix('categoria')->group(function () {
          Route::get('', [FinancaCategoriaController::class, 'index']);
          Route::get('/{fncg_id}', [FinancaCategoriaController::class, 'show']);
          Route::post('', [FinancaCategoriaController::class, 'store']);
          Route::put('/{fncg_id}', [FinancaCategoriaController::class, 'update']);
        });
      });
    });

    // financa
    Route::prefix('financa/{fnct_id}')->group(function () {

      // financa/fnct_id/item
      Route::prefix('item')->group(function () {
        Route::get('', [FinancaItemController::class, 'index']);
        Route::get('/{fnit_id}', [FinancaItemController::class, 'show']);
        Route::post('', [FinancaItemController::class, 'store']);
        Route::put('/{fnit_id}', [FinancaItemController::class, 'update']);
        Route::delete('/{fnit_id}', [FinancaItemController::class, 'destroy']);
      });

      Route::prefix('analise')->group(function () {
        Route::get('/grupo-categoria/{fntp_id?}/{fngp_id?}/{fncg_id?}', [FinancaAnaliseItemController::class, 'grupoCategoria']);
        Route::get('/ano/{fntp_id?}/{fngp_id?}/{fncg_id?}', [FinancaAnaliseItemController::class, 'analiseAno']);
      });

      // financa/fnct_id/consolidate
      Route::prefix('consolidate')->group(function () {

        // financa/fnct_id/consolidate/item
        Route::prefix('item')->group(function () {
          // financa/fnct_id/consolidate/item?p=date
          Route::get('', [FinancaConsolidadoItemController::class, 'consolidate']);
          // financa/fnct_id/consolidate/item/mes
          Route::get('mes', [FinancaConsolidadoItemController::class, 'consolidateMonth']);
          // financa/fnct_id/consolidate/item/ano
          Route::get('ano', [FinancaConsolidadoItemController::class, 'consolidateYear']);
        });
      });
    });
  });
});
