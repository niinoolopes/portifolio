<?php

namespace App\Http\Controllers;

use App\Models\Financa\FinancaCarteiraModel;
use App\Models\Financa\FinancaCategoriaModel;
use App\Models\Financa\FinancaGrupoModel;
use App\Models\Financa\FinancaItemModel;
use App\Models\Financa\FinancaSituacaoModel;
use App\Models\Financa\FinancaTipoModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AssistantController extends Controller
{
  //

  public function Artisan()
  {
    $arr = [];

    ## CONTROLLER
    // $arr[] = 'make:controller Cofre/CofreCarteiraController --api';
    // $arr[] = 'make:controller Cofre/CofreItemController --api';
    // $arr[] = 'make:controller Financa/FinancaCarteiraController --api';
    // $arr[] = 'make:controller Financa/FinancaCategoriaController --api';
    // $arr[] = 'make:controller Financa/FinancaGrupoController --api';
    // $arr[] = 'make:controller Financa/FinancaItemController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoAtivoController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoAtivoCotacaoController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoAtivoRendimantoController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoAtivoSplitController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoAtivoTipoController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoCarteiraController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoCorretoraController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoOrdemController --api';
    // $arr[] = 'make:controller Investimento/InvestimentoOrdemOperacaoController --api';
    // $arr[] = 'make:controller Recurso/ImpostoRendaController --api';
    // $arr[] = 'make:controller Recurso/ImpostoRendaItemController --api';
    // $arr[] = 'make:controller UsuarioController --api';

    ## MODEL
    // $arr[] = 'make:model Model/Cofre/CofreCarteiraModel';
    // $arr[] = 'make:model Model/Cofre/CofreItemConsolidadoModel';
    // $arr[] = 'make:model Model/Cofre/CofreItemModel';
    // $arr[] = 'make:model Model/Cofre/CofreTipoModel';
    // $arr[] = 'make:model Model/Financa/FinancaCarteiraModel';
    // $arr[] = 'make:model Model/Financa/FinancaCategoriaModel';
    // $arr[] = 'make:model Model/Financa/FinancaGrupoModel';
    // $arr[] = 'make:model Model/Financa/FinancaItemConsolidadoModel';
    // $arr[] = 'make:model Model/Financa/FinancaItemModel';
    // $arr[] = 'make:model Model/Financa/FinancaSituacaoModel';
    // $arr[] = 'make:model Model/Financa/FinancaTipoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoAtivoCotacaoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoAtivoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoAtivoRendimantoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoAtivoSplitModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoAtivoTipoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoCarteiraConsolidadoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoCarteiraModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoCorretoraModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoOrdemOperacaoConsolidadoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoOrdemOperacaoModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoOrdemModel';
    // $arr[] = 'make:model Model/Investimento/InvestimentoTipoModel';
    // $arr[] = 'make:model Model/Recurso/ImpostoRendaModel';
    // $arr[] = 'make:model Model/Recurso/ImpostoRendaItemModel';
    // $arr[] = 'make:model Model/ConfigModel';
    // $arr[] = 'make:model Model/UsuarioModel';

    ## REQUEST
    // $arr[] = 'make:request Cofre/CofreCarteiraRequest';
    // $arr[] = 'make:request Cofre/CofreItemRequest';
    // $arr[] = 'make:request Financa/FinancaCarteiraRequest';
    // $arr[] = 'make:request Financa/FinancaCategoriaRequest';
    // $arr[] = 'make:request Financa/FinancaGrupoRequest';
    // $arr[] = 'make:request Financa/FinancaItemRequest';
    // $arr[] = 'make:request Financa/FinancaSituacaoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoAtivoCotacaoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoAtivoRendimantoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoAtivoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoAtivoSplitRequest';
    // $arr[] = 'make:request Investimento/InvestimentoAtivoTipoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoCarteiraRequest';
    // $arr[] = 'make:request Investimento/InvestimentoCorretoraRequest';
    // $arr[] = 'make:request Investimento/InvestimentoOrdemOperacaoRequest';
    // $arr[] = 'make:request Investimento/InvestimentoOrdemRequest';
    // $arr[] = 'make:request Recurso/ImpostoRendaRequest';
    // $arr[] = 'make:request Recurso/ImpostoRendaItemRequest';
    // $arr[] = 'make:request UsuarioRequest';

    ## RESOURCE-COLLECTION

    // $arr[] = 'make:resource Cofre/CofreCarteiraCollection --collection';
    // $arr[] = 'make:resource Cofre/CofreCarteiraCollectionClean --collection';
    // $arr[] = 'make:resource Cofre/CofreCarteiraResource';

    // $arr[] = 'make:resource Cofre/CofreItemCollection --collection';
    // $arr[] = 'make:resource Cofre/CofreItemCollectionClean --collection';
    // $arr[] = 'make:resource Cofre/CofreItemConsolidadoResource';
    // $arr[] = 'make:resource Cofre/CofreItemPurposeCollection';
    // $arr[] = 'make:resource Cofre/CofreItemPurposeResource';
    // $arr[] = 'make:resource Cofre/CofreItemResource_carteira';
    // $arr[] = 'make:resource Cofre/CofreItemResource_tipo';
    // $arr[] = 'make:resource Cofre/CofreItemResource';
    // $arr[] = 'make:resource Cofre/CofreTipoCollectionClean';
    // $arr[] = 'make:resource Cofre/CofreTipoResource';


    // $arr[] = 'make:resource Financa/FinancaCarteiraResource';
    // $arr[] = 'make:resource Financa/FinancaCarteiraCollection --collection';
    // $arr[] = 'make:resource Financa/FinancaCategoriaResource';
    // $arr[] = 'make:resource Financa/FinancaCategoriaCollection --collection';
    // $arr[] = 'make:resource Financa/FinancaGrupoResource';
    // $arr[] = 'make:resource Financa/FinancaGrupoCollection --collection';
    // $arr[] = 'make:resource Financa/FinancaItemResource';
    // $arr[] = 'make:resource Financa/FinancaItemCollection --collection';
    // $arr[] = 'make:resource Financa/FinancaItemConsolidadoResource';
    // $arr[] = 'make:resource Financa/FinancaSituacaoResource';
    // $arr[] = 'make:resource Financa/FinancaSituacaoCollection --collection';
    // $arr[] = 'make:resource Financa/FinancatipoResource';
    // $arr[] = 'make:resource Financa/FinancatipoCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoCarteiraResource';
    // $arr[] = 'make:resource Investimento/InvestimentoCarteiraCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoResource';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoCotacaoResource';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoCotacaoCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoRendimantoResource';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoRendimantoCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoSplitResource';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoSplitCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoTipoResource';
    // $arr[] = 'make:resource Investimento/InvestimentoAtivoTipoCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoCorretoraResource';
    // $arr[] = 'make:resource Investimento/InvestimentoCorretoraCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoOrdemResource';
    // $arr[] = 'make:resource Investimento/InvestimentoOrdemCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoOrdemItemResource';
    // $arr[] = 'make:resource Investimento/InvestimentoOrdemItemCollection --collection';
    // $arr[] = 'make:resource Investimento/InvestimentoTipoResource';
    // $arr[] = 'make:resource Investimento/InvestimentoTipoCollection --collection';
    // $arr[] = 'make:resource Recurso/ImpostoRendaResource';
    // $arr[] = 'make:resource Recurso/ImpostoRendaCollection --collection';
    // $arr[] = 'make:resource Recurso/ImpostoRendaItemResource';
    // $arr[] = 'make:resource Recurso/ImpostoRendaItemCollection --collection';
    // $arr[] = 'make:resource Usuario/UsuarioResource';
    // $arr[] = 'make:resource Usuario/UsuarioCollection --collection';

    ## Artisan
    if (count($arr) == 0) {
      die('Não contem comandos Artisan ...');
    }

    foreach ($arr as $command) {
      Artisan::call($command);
    }
    die('foi ...');
  }

  public function migrateDataBase()
  {
    if (!env('APP_ASSISTANT', false)) {
      die('sem acesso!');
    }

    die('mudar na controller primeiro!');

    $this->deleteTables();
    $this->createTables();
    $this->migrateData();

    die('migrateDataBase fim');
  }

  private function deleteTables()
  {
    try {
      $arrSQL = [];

      $arrSQL[] = "SET foreign_key_checks = 0";
      $arrSQL[] = "drop table if exists password_resets";
      $arrSQL[] = "drop table if exists personal_access_tokens";
      $arrSQL[] = "drop table if exists api_sys_users";
      $arrSQL[] = "drop table if exists api_crm_financa_situacao";
      $arrSQL[] = "drop table if exists api_crm_financa_tipo";
      $arrSQL[] = "drop table if exists api_crm_financa_carteira";
      $arrSQL[] = "drop table if exists api_crm_financa_grupo";
      $arrSQL[] = "drop table if exists api_crm_financa_categoria";
      $arrSQL[] = "drop table if exists api_crm_financa_consolidado_item_month";
      $arrSQL[] = "drop table if exists api_crm_financa_consolidado_item_year";
      $arrSQL[] = "drop table if exists api_crm_financa_consolidado_item";
      $arrSQL[] = "drop table if exists api_crm_financa_item";
      $arrSQL[] = "SET foreign_key_checks = 1";

      foreach ($arrSQL as $SQL) {
        DB::select($SQL);
      }
    } catch (\Throwable $th) {
      dd('deleteTables', $th);
    }
    sleep(1);
  }

  private function createTables()
  {
    try {
      $arrSQL = [];

      $arrSQL[] = "CREATE TABLE api_sys_users (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        email_verified_at timestamp NULL DEFAULT NULL,
        password varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY users_email_unique (email)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE password_resets (
        email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        token varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        KEY password_resets_email_index (email)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

      $arrSQL[] = "CREATE TABLE personal_access_tokens (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        tokenable_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        tokenable_id bigint(20) unsigned NOT NULL,
        name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        token varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
        abilities text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        last_used_at timestamp NULL DEFAULT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY personal_access_tokens_token_unique (token),
        KEY personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type,tokenable_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=1026 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_situacao (
        fnis_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fnis_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (fnis_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_tipo (
        fntp_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fntp_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (fntp_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_carteira (
        fnct_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fnct_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        fnct_json varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}',
        fnct_enable enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
        fnct_panel enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
        usua_id bigint(20) unsigned NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (fnct_id),
        KEY api_crm_financa_carteira_usua_id_foreign (usua_id),
        CONSTRAINT api_crm_financa_carteira_usua_id_foreign FOREIGN KEY (usua_id) REFERENCES api_sys_users (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_grupo (
         fngp_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
         fngp_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
         fngp_enable enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
         fngp_fechamento enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
         fntp_id bigint(20) unsigned NOT NULL,
         fnct_id bigint(20) unsigned NOT NULL,
         usua_id bigint(20) unsigned NOT NULL,
         created_at timestamp NULL DEFAULT NULL,
         updated_at timestamp NULL DEFAULT NULL,
         PRIMARY KEY (fngp_id),
         KEY api_crm_financa_grupo_fntp_id_foreign (fntp_id),
         KEY api_crm_financa_grupo_fnct_id_foreign (fnct_id),
         KEY api_crm_financa_grupo_usua_id_foreign (usua_id),
         CONSTRAINT api_crm_financa_grupo_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id),
         CONSTRAINT api_crm_financa_grupo_fntp_id_foreign FOREIGN KEY (fntp_id) REFERENCES api_crm_financa_tipo (fntp_id),
         CONSTRAINT api_crm_financa_grupo_usua_id_foreign FOREIGN KEY (usua_id) REFERENCES api_sys_users (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_categoria (
         fncg_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
         fncg_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
         fncg_obs varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
         fncg_enable enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
         fncg_fechamento enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
         fngp_id bigint(20) unsigned NOT NULL,
         fnct_id bigint(20) unsigned NOT NULL,
         usua_id bigint(20) unsigned NOT NULL,
         created_at timestamp NULL DEFAULT NULL,
         updated_at timestamp NULL DEFAULT NULL,
         PRIMARY KEY (fncg_id),
         KEY api_crm_financa_categoria_fngp_id_foreign (fngp_id),
         KEY api_crm_financa_categoria_fnct_id_foreign (fnct_id),
         KEY api_crm_financa_categoria_usua_id_foreign (usua_id),
         CONSTRAINT api_crm_financa_categoria_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id),
         CONSTRAINT api_crm_financa_categoria_fngp_id_foreign FOREIGN KEY (fngp_id) REFERENCES api_crm_financa_grupo (fngp_id),
         CONSTRAINT api_crm_financa_categoria_usua_id_foreign FOREIGN KEY (usua_id) REFERENCES api_sys_users (id)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_consolidado_item_month (
        fncim_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fncim_year varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        fncim_month varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        fncim_json text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}',
        fnct_id bigint(20) unsigned NOT NULL,
        PRIMARY KEY (fncim_id),
        KEY api_crm_financa_consolidado_item_month_fnct_id_foreign (fnct_id),
        CONSTRAINT api_crm_financa_consolidado_item_month_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_consolidado_item_year (
        fnciy_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fnciy_year varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        fnciy_json text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}',
        fnct_id bigint(20) unsigned NOT NULL,
        PRIMARY KEY (fnciy_id),
        KEY api_crm_financa_consolidado_item_year_fnct_id_foreign (fnct_id),
        CONSTRAINT api_crm_financa_consolidado_item_year_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      $arrSQL[] = "CREATE TABLE api_crm_financa_item (
        fnit_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fnit_value double(8,2) NOT NULL,
        fnit_date date NOT NULL,
        fnit_obs text(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        fnit_enable enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
        fnis_id bigint(20) unsigned NOT NULL,
        fntp_id bigint(20) unsigned NOT NULL,
        fnct_id bigint(20) unsigned NOT NULL,
        fngp_id bigint(20) unsigned NOT NULL,
        fncg_id bigint(20) unsigned NOT NULL,
        usua_id bigint(20) unsigned NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (fnit_id),
        KEY api_crm_financa_item_fnis_id_foreign (fnis_id),
        KEY api_crm_financa_item_fntp_id_foreign (fntp_id),
        KEY api_crm_financa_item_fnct_id_foreign (fnct_id),
        KEY api_crm_financa_item_fngp_id_foreign (fngp_id),
        KEY api_crm_financa_item_fncg_id_foreign (fncg_id),
        KEY api_crm_financa_item_usua_id_foreign (usua_id),
        CONSTRAINT api_crm_financa_item_fncg_id_foreign FOREIGN KEY (fncg_id) REFERENCES api_crm_financa_categoria (fncg_id),
        CONSTRAINT api_crm_financa_item_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id),
        CONSTRAINT api_crm_financa_item_fngp_id_foreign FOREIGN KEY (fngp_id) REFERENCES api_crm_financa_grupo (fngp_id),
        CONSTRAINT api_crm_financa_item_fnis_id_foreign FOREIGN KEY (fnis_id) REFERENCES api_crm_financa_situacao (fnis_id),
        CONSTRAINT api_crm_financa_item_fntp_id_foreign FOREIGN KEY (fntp_id) REFERENCES api_crm_financa_tipo (fntp_id),
        CONSTRAINT api_crm_financa_item_usua_id_foreign FOREIGN KEY (usua_id) REFERENCES api_sys_users (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";


      $arrSQL[] = "CREATE TABLE api_crm_financa_consolidado_item (
        fnic_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        fnic_date date NOT NULL,
        fnic_json text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}',
        fnct_id bigint(20) unsigned NOT NULL,
        created_at timestamp NULL DEFAULT NULL,
        updated_at timestamp NULL DEFAULT NULL,
        PRIMARY KEY (fnic_id),
        KEY api_crm_financa_consolidado_item_fnct_id_foreign (fnct_id),
        CONSTRAINT api_crm_financa_consolidado_item_fnct_id_foreign FOREIGN KEY (fnct_id) REFERENCES api_crm_financa_carteira (fnct_id)
      ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

      foreach ($arrSQL as $SQL) {
        DB::select($SQL);
      }
    } catch (\Throwable $th) {
      dd('createTables', $th);
    }
    sleep(1);
  }

  private function migrateData()
  {
    $result = DB::table('api_nn__usuario')->get()->toArray();
    foreach ($result as $item) {
      $model = new User;
      $model->name = $item->USUA_NOME;
      $model->email = $item->USUA_EMAIL;
      $model->password = Hash::make(base64_decode($item->USUA_SENHA));
      $model->save();
    }
    sleep(1);


    $result = DB::table('api_nn__financa_situacao')->get()->toArray();
    foreach ($result as $item) {
      $model = new FinancaSituacaoModel;
      $model->fnis_description = $item->FNIS_DESCRICAO;
      $model->save();
    }
    sleep(1);


    $result = DB::table('api_nn__financa_tipo')->get()->toArray();
    foreach ($result as $item) {
      $model = new FinancaTipoModel();
      $model->fntp_description = $item->FITP_DESCRICAO;
      $model->save();
    }
    sleep(1);


    $result = DB::table('api_nn__financa_carteira AS C')
      ->leftJoin('api_nn__financa_integrante AS I', 'C.FINC_ID', '=', 'I.FINC_ID')->get()->toArray();
    foreach ($result as $item) {
      $model = new FinancaCarteiraModel;
      $model->fnct_description = $item->FINC_DESCRICAO;
      $model->fnct_json        = "{}";
      $model->fnct_enable      = $item->FINC_STATUS;
      $model->fnct_panel       = $item->FINC_PAINEL;
      $model->usua_id          = $item->USUA_ID;
      $model->save();
    }
    sleep(1);


    $result = DB::table('api_nn__financa_grupo AS G')
      ->leftJoin('api_nn__financa_carteira AS C', 'C.FINC_ID', '=', 'G.FINC_ID')
      ->leftJoin('api_nn__financa_integrante AS I', 'I.FINC_ID', '=', 'C.FINC_ID')->get()->toArray();
    foreach ($result as $item) {
      $model = new FinancaGrupoModel;
      $model->fngp_id = $item->FIGP_ID;
      $model->fngp_description = $item->FIGP_DESCRICAO;
      $model->fngp_enable      = $item->FIGP_STATUS;
      $model->fntp_id          = $item->FITP_ID;
      $model->fnct_id          = $item->FINC_ID;
      $model->usua_id          = $item->USUA_ID;
      $model->save();
    }
    sleep(1);


    $result = DB::table('api_nn__financa_categoria AS CG')
      ->leftJoin('api_nn__financa_grupo AS G', 'G.FIGP_ID', '=', 'CG.FIGP_ID')
      ->leftJoin('api_nn__financa_carteira AS C', 'C.FINC_ID', '=', 'G.FINC_ID')
      ->leftJoin('api_nn__financa_integrante AS I', 'I.FINC_ID', '=', 'C.FINC_ID')
      ->orderBy('CG.FICT_ID')
      ->get()->toArray();
    foreach ($result as $item) {
      $model = new FinancaCategoriaModel;
      $model->fncg_id = $item->FICT_ID;
      $model->fncg_description = $item->FICT_DESCRICAO;
      $model->fncg_enable      = $item->FICT_STATUS;
      $model->fncg_obs         = $item->FICT_OBS;
      $model->fngp_id          = $item->FIGP_ID;
      $model->fnct_id          = $item->FINC_ID;
      $model->usua_id          = $item->USUA_ID;
      $model->save();
    }
    sleep(1);

    $itemDD = null;

    try {
      $result = DB::table('api_nn__financa_item')->get()->toArray();
      foreach ($result as $item) {

        $itemDD = $item;

        $model = new FinancaItemModel;
        $model->fnit_value   = $item->FNIT_VALOR;
        $model->fnit_date    = $item->FNIT_DATA;
        $model->fnit_obs     = "{$item->FNIT_OBS}";
        $model->fnit_enable  = $item->FNIT_STATUS ? 1 : 0;
        $model->fnis_id      = $item->FNIS_ID;
        $model->fntp_id      = $item->FITP_ID;
        $model->fngp_id      = $item->FIGP_ID;
        $model->fncg_id      = $item->FICT_ID;
        $model->fnct_id      = $item->FINC_ID;
        $model->usua_id      = $item->USUA_ID;
        $model->save();
      }
    } catch (\Throwable $th) {
      dd($itemDD, $th);
    }
    sleep(1);
  }
}
