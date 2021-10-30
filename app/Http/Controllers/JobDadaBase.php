<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class JobDadaBase extends Controller
{

  public function __construct()
  {
    if (!env('DB_INIT'))
      die('acesso negado!');
  }

  public function index()
  {
    // ALTER TABLE `sad`.`sc__coleta` RENAME TO  `sad`.`sc__coleta-1` ;
    // ALTER TABLE `sad`.`sc__coleta_historico` RENAME TO  `sad`.`sc__coleta_historico-1` ;
    // ALTER TABLE `sad`.`sc__coleta_produto` RENAME TO  `sad`.`sc__coleta_produto-1` ;
    // ALTER TABLE `sad`.`sc__coleta_status` RENAME TO  `sad`.`sc__coleta_status-1` ;
    // ALTER TABLE `sad`.`sc__endereco` RENAME TO  `sad`.`sc__endereco-1` ;
    // ALTER TABLE `sad`.`sc__produto_type` RENAME TO  `sad`.`sc__produto_type-1` ;
    // ALTER TABLE `sad`.`sc__usuario` RENAME TO  `sad`.`sc__usuario-1` ;
    // ALTER TABLE `sad`.`sc__usuario_type` RENAME TO  `sad`.`sc__usuario_type-1` ;

    // TABLES
    $table_coleta = 'sc__coleta';
    $table_coletaHistorico = 'sc__coleta_historico';
    $table_coletaProduto = 'sc__coleta_produto';
    $table_coletaStatus = 'sc__coleta_status';
    $table_endereco = 'sc__endereco';
    $table_produtoType = 'sc__produto_type';
    $table_usuario = 'sc__usuario';
    $table_usuarioType = 'sc__usuario_type';

    // DROPS
    $arrQueryDrop = [];
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_coleta;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_coletaHistorico;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_coletaProduto;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_coletaStatus;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_endereco;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_produtoType;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_usuario;";
    $arrQueryDrop[] = "DROP TABLE IF EXISTS $table_usuarioType;";

    foreach ($arrQueryDrop as $query) {
      DB::select($query);
    }
    echo 'arrQueryDrop - ok <br>';

    // CREATES
    $arrQueryCreate[] = "CREATE TABLE $table_coleta (
            cole_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
            cole_date date NOT NULL,
            cole_price decimal(8,2) NOT NULL DEFAULT 0.00,
            cole_status int(11) NOT NULL,
            cols_id int(11) NOT NULL DEFAULT 1,
            clie_id int(11) DEFAULT NULL,
            motr_id int(11) DEFAULT NULL,
            finc_id int(11) DEFAULT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_coletaHistorico (
            colh_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            colh_date timestamp NOT NULL DEFAULT current_timestamp(),
            cole_id int(11) NOT NULL,
            cols_id int(11) NOT NULL,
            usua_id int(11) NOT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (colh_id)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_coletaProduto (
            colp_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            colp_description varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            colp_quantity decimal(8,2) NOT NULL DEFAULT 0.00,
            colp_price_unit decimal(8,2) NOT NULL DEFAULT 0.00,
            colp_price decimal(8,2) NOT NULL DEFAULT 0.00,
            colp_status int(11) NOT NULL DEFAULT 1,
            cole_id int(11) NOT NULL,
            copt_id int(11) NOT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (colp_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_coletaStatus (
            cols_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            cols_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (cols_id),
            UNIQUE KEY sc__coleta_status_cols_name_unique (cols_name)
           ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_endereco (
            end_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            end_address varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            end_number int(11) NOT NULL,
            end_complement varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            end_zipcode varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            end_district varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            end_city varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            usua_id int(11) DEFAULT NULL,
            cole_id int(11) DEFAULT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (end_id)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_produtoType (
            copt_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            copt_type varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            copt_price decimal(8,2) NOT NULL DEFAULT 0.00,
            copt_status int(11) NOT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (copt_id)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_usuario (
            usua_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            usua_login varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            usua_password varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            usua_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            usua_email varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            usua_cnpj varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_pix varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_whatsapp varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_banco varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_agencia varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_conta varchar(255) COLLATE utf8mb4_unicode_ci,
            usua_status int(11) NOT NULL DEFAULT 1,
            usut_id int(11) NOT NULL,
            created_at timestamp NULL DEFAULT NULL,
            updated_at timestamp NULL DEFAULT NULL,
            PRIMARY KEY (usua_id),
            UNIQUE KEY sc__usuario_usua_login_unique (usua_login),
            UNIQUE KEY sc__usuario_usua_email_unique (usua_email)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    $arrQueryCreate[] = "CREATE TABLE $table_usuarioType (
            usut_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            usut_name varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (usut_id),
            UNIQUE KEY sc__usuario_type_usut_name_unique (usut_name)
          ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";

    foreach ($arrQueryCreate as $query) {
      DB::select($query);
    }
    echo 'arrQueryCreate - ok <br>';

    // STATUS COLETA
    $arrInsert[] = [$table_coletaStatus, ['cols_id' => 1, 'cols_name' => 'Coleta solicitada']];
    $arrInsert[] = [$table_coletaStatus, ['cols_id' => 2, 'cols_name' => 'Coleta em andamento']];
    $arrInsert[] = [$table_coletaStatus, ['cols_id' => 3, 'cols_name' => 'Coleta realizada']];
    $arrInsert[] = [$table_coletaStatus, ['cols_id' => 4, 'cols_name' => 'Coleta entregue']];
    $arrInsert[] = [$table_coletaStatus, ['cols_id' => 5, 'cols_name' => 'Coleta concluida']];
    // PRODUTO TYPE
    $arrInsert[] = [$table_produtoType, ['copt_id' => 1, 'copt_type' => 'Usado',  'copt_price' => 1.00, 'copt_status' => 1]];
    $arrInsert[] = [$table_produtoType, ['copt_id' => 2, 'copt_type' => 'Vencido', 'copt_price' => 1.00, 'copt_status' => 1]];
    // USUARIO TYPE
    $arrInsert[] = [$table_usuarioType, ['usut_id' => 1, 'usut_name' => 'Admin']];
    $arrInsert[] = [$table_usuarioType, ['usut_id' => 2, 'usut_name' => 'Motorista']];
    $arrInsert[] = [$table_usuarioType, ['usut_id' => 3, 'usut_name' => 'Cliente']];

    $arrInsert[] = [
      $table_usuario, [
        'usua_id' => 1, 'usua_login' => 'admin', 'usua_password' => 'dGVzdGU=', 'usua_name' => 'Admin', 'usua_email' => 'admin@admin.com',
        'usua_cnpj' => null, 'usua_pix' => null, 'usua_whatsapp' => null, 'usua_banco' => null, 'usua_agencia' => null, 'usua_conta' => null, 'usua_status' => 1,
        'usut_id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
      ]
    ];
    $arrInsert[] = [
      $table_usuario, [
        'usua_id' => 2, 'usua_login' => 'financeiro1', 'usua_password' => 'dGVzdGU=', 'usua_name' => 'financeiro1', 'usua_email' => 'financeiro1@financeiro.com',
        'usua_cnpj' => null, 'usua_pix' => null, 'usua_whatsapp' => null, 'usua_banco' => null, 'usua_agencia' => null, 'usua_conta' => null, 'usua_status' => 1,
        'usut_id' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
      ]
    ];
    $arrInsert[] = [
      $table_usuario, [
        'usua_id' => 3, 'usua_login' => 'motorista1', 'usua_password' => 'dGVzdGU=', 'usua_name' => 'motorista1', 'usua_email' => 'motorista1@motorista.com',
        'usua_cnpj' => null, 'usua_pix' => null, 'usua_whatsapp' => null, 'usua_banco' => null, 'usua_agencia' => null, 'usua_conta' => null, 'usua_status' => 1,
        'usut_id' => 2, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
      ]
    ];
    $arrInsert[] = [
      $table_usuario, [
        'usua_id' => 4, 'usua_login' => 'cliente1', 'usua_password' => 'dGVzdGU=', 'usua_name' => 'cliente1', 'usua_email' => 'cliente1@cliente.com',
        'usua_cnpj' => '123456', 'usua_pix' => '11955554444', 'usua_whatsapp' => '11955554444', 'usua_banco' => '001', 'usua_agencia' => '005', 'usua_conta' => '006', 'usua_status' => 1,
        'usut_id' => 3, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
      ]
    ];
    $arrInsert[] = [
      $table_endereco, [
        'end_id' => 1,
        'end_address' => 'Rua Alegria',
        'end_number' => 17,
        'end_complement' => 'Portão amarelo',
        'end_zipcode' => '08330158',
        'end_district' => 'Bairro centro',
        'end_city' => 'São Paulo',
        'usua_id' => 4,
        'cole_id' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]
    ];

    foreach ($arrInsert as $query) {
      DB::table($query[0])->insertOrIgnore($query[1]);
    }
    echo 'arrInsert - ok <br>';

    die('feito...');
  }
}
