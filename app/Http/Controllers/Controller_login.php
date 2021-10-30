<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Pedido;
use Illuminate\Support\Facades\DB;

class Controller_login extends Controller
{
    private $dados = [];

    public function index()
    {
        $this->dados['_msg'] = session()->get('_msg');

        $this->dados['titulo'] = 'Login';
        return view('pages.login', $this->dados);
    }

    public function do(Request $request)
    {
        $Usuario = new Usuario;

        $post = $request->post();
        $user  = null;


        $user = $Usuario::where('LOGIN', $post['LOGIN'])->where('STATUS', 1)->first();

        if ($user == null) {
            session()->flash('_msg', ['text' => 'Usuário não encontrado', 'tipo' => 'danger']);
            return redirect()->route('login');
        }


        if ($user->STATUS === 0) {
            session()->flash('_msg', ['text' => 'Usuário desativado', 'tipo' => 'danger']);
            return redirect()->route('login');
        }

        if (base64_decode($user->SENHA) !== $request->post('SENHA')) {
            $request->session()->flash('_msg', ['text' => 'Senha inválida', 'tipo' => 'danger']);
            return redirect()->route('login');
        }

        session(['LOGIN' => true]);
        session(['total_pedidos_s' => Pedido::where('STATUS', '=', 1)->count()]);
        session(
            [
                'USUARIO' => [
                    'USUARIO_ID'       => $user->USUARIO_ID,
                    'NOME'             => $user->NOME,
                    'LOGIN'            => $user->LOGIN,
                    'TIPO_ID'          => $user->TIPO_ID,
                    'PERMISSAO_PAINEL' => json_decode($user->JSON)->PAINEL,
                    'PERMISSAO_CONFIG' => json_decode($user->JSON)->CONFIG,
                ]
            ]
        );

        return redirect()->route('pedido.painel');
    }

    public function logout()
    {
        session(['LOGIN' => false]);
        session(['total_pedidos_s' => false]);
        session(['USUARIO' => false]);

        return redirect()->route('home');
    }

    public function initBanco()
    {
        if (env('DB_INSTALL', false)) {
            $table_banco = "sad__banco";
            $table_empresa = "sad__empresa";
            $table_pedido = "sad__pedido";
            $table_pedido_status = "sad__pedido_status";
            $table_usuario = "sad__usuario";
            $table_usuario_cargo = "sad__usuario_cargo";
            $table_usuario_tipo = "sad__usuario_tipo";
            $table_config = "sad__config";


            $table_banco_DROP = "DROP TABLE IF EXISTS $table_banco;";

            $table_banco_CREATE = "
                CREATE TABLE `$table_banco` (
                    `BANCO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `SITE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `CODIGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `LOGO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`BANCO_ID`),
                    UNIQUE KEY `banco_nome_unique` (`NOME`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            $table_empresa_DROP = "DROP TABLE IF EXISTS $table_empresa;";

            $table_empresa_CREATE = "
                CREATE TABLE `{$table_empresa}` (
                    `EMPRESA_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `COR` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`EMPRESA_ID`),
                    UNIQUE KEY `sad__empresa_nome_unique` (`NOME`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_pedido_DROP = "DROP TABLE IF EXISTS $table_pedido;";

            $table_pedido_CREATE = "
                CREATE TABLE `{$table_pedido}` (
                    `PEDIDO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `N_ATENDIMENTO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `USUARIO_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `VALOR` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `DATA_TRANSFERENCIA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `BANCO_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `COMPROVANTE` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`PEDIDO_ID`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_pedido_status_DROP = "DROP TABLE IF EXISTS $table_pedido_status;";

            $table_pedido_status_CREATE = "
                CREATE TABLE `{$table_pedido_status}` (
                    `STATUS_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `DESCRICAO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`STATUS_ID`),
                    UNIQUE KEY `sad__pedido_status_descricao_unique` (`DESCRICAO`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_usuario_DROP = "DROP TABLE IF EXISTS $table_usuario;";

            $table_usuario_CREATE = "
                CREATE TABLE `${table_usuario}` (
                    `USUARIO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `CARGO_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `TIPO_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `EMPRESA_ID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `EMAIL` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `LOGIN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `SENHA` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `JSON` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                    `STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`USUARIO_ID`),
                    UNIQUE KEY `sad__usuario_email_unique` (`EMAIL`),
                    UNIQUE KEY `sad__usuario_login_unique` (`LOGIN`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_usuario_cargo_DROP = "DROP TABLE IF EXISTS $table_usuario_cargo;";

            $table_usuario_cargo_CREATE = "
                CREATE TABLE `{$table_usuario_cargo}` (
                    `CARGO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `CARGO_NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `CARGO_STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`CARGO_ID`),
                    UNIQUE KEY `sad__usuario_cargo_cargo_nome_unique` (`CARGO_NOME`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_usuario_tipo_DROP = "DROP TABLE IF EXISTS $table_usuario_tipo;";

            $table_usuario_tipo_CREATE = "
            CREATE TABLE `{$table_usuario_tipo}` (
                `TIPO_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `TIPO_NOME` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `TIPO_STATUS` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`TIPO_ID`),
                UNIQUE KEY `sad__usuario_tipo_tipo_nome_unique` (`TIPO_NOME`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            $table_config_DROP = "DROP TABLE IF EXISTS $table_config;";

            $table_config_CREATE = "
                CREATE TABLE `$table_config` (
                    `CONFIG_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `DESCRICAO` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `JSON` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`CONFIG_ID`),
                    UNIQUE KEY `config_descricao_unique` (`DESCRICAO`)
                ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";

            DB::select($table_banco_DROP);
            DB::select($table_banco_CREATE);
            DB::select($table_empresa_DROP);
            DB::select($table_empresa_CREATE);
            DB::select($table_pedido_DROP);
            DB::select($table_pedido_CREATE);
            DB::select($table_pedido_status_DROP);
            DB::select($table_pedido_status_CREATE);
            DB::select($table_usuario_DROP);
            DB::select($table_usuario_CREATE);
            DB::select($table_usuario_cargo_DROP);
            DB::select($table_usuario_cargo_CREATE);
            DB::select($table_usuario_tipo_DROP);
            DB::select($table_usuario_tipo_CREATE);
            DB::select($table_config_DROP);
            DB::select($table_config_CREATE);

            DB::table($table_usuario_tipo)->insert([
                'TIPO_NOME'   => 'administrador',
                'TIPO_STATUS' => 1,
            ]);

            DB::table($table_usuario)->insert([
                'NOME'       => 'administrador',
                'CARGO_ID'   => '',
                'TIPO_ID'    => '1',
                'EMPRESA_ID' => '',
                'EMAIL'      => 'admin@admin.com',
                'LOGIN'      => 'administrador',
                'SENHA'      => base64_encode(123),
                'JSON'       => '{"PAINEL":"all","CONFIG":"S"}',
                'STATUS'     => 1,
            ]);

            DB::table($table_pedido_status)->insert([
                'DESCRICAO'      => 'Pendente',
                'STATUS'             => 1,
            ]);
            DB::table($table_pedido_status)->insert([
                'DESCRICAO'      => 'Aceito',
                'STATUS'             => 1,
            ]);
            DB::table($table_pedido_status)->insert([
                'DESCRICAO'      => 'Cancelado',
                'STATUS'             => 1,
            ]);

            DB::table($table_config)->insert([
                'DESCRICAO'      => 'FORM_CADASTRO',
                'JSON'           => '{"TIPO_ID":["2"],"N_ATENDIMENTO":false,"VALOR":false,"DATA":false,"BANCO":false,"COMPROVANTE":false}',
            ]);

            // --

            $table_motivo = "sad__pedido_motivo";
            $table_pedido = "sad__pedido";

            $table_motivo_DROP = "DROP TABLE IF EXISTS $table_motivo;";

            $table_motivo_CREATE = "
                CREATE TABLE `$table_motivo` (
                    `MOTIVO_ID` INT NOT NULL AUTO_INCREMENT,
                    `DESCRICAO` VARCHAR(255) NULL,
                    `STATUS` INT,
                        PRIMARY KEY (`MOTIVO_ID`)
                );
            ";

            DB::select($table_motivo_DROP);

            DB::select($table_motivo_CREATE);

            DB::table($table_motivo)->insert([
                'DESCRICAO' => 'Motivo 1',
            ]);
            DB::table($table_motivo)->insert([
                'DESCRICAO' => 'Motivo 2',
            ]);
            DB::table($table_motivo)->insert([
                'DESCRICAO' => 'Motivo 3',
            ]);

            DB::select("ALTER TABLE  `$table_pedido` ADD COLUMN `MOTIVO_ID` INT NULL AFTER `STATUS_ID`;");


            die('ok');
        } else {
            die('acesso negado');
        }
    }

    public function job($num)
    {
        if (env('DB_JOB', false)) {

            if ($num == 1) {
                $pedidos = Pedido::all();

                foreach ($pedidos as $pedido) {
                    $str = explode('-', $pedido->COMPROVANTE);
                    $extensao = explode('.', $str[2]);
                    $strNew = $str[0] . '-' . $str[1] . '-' . $pedido->PEDIDO_ID . '.' . $extensao[1];

                    $pedido->COMPROVANTE = $strNew;
                    $pedido->save();
                }
            }
            if ($num == 2) {
                $table_motivo = "sad__pedido_motivo";
                $table_pedido = "sad__pedido";

                $table_motivo_DROP = "DROP TABLE IF EXISTS $table_motivo;";

                $table_motivo_CREATE = "
                    CREATE TABLE `$table_motivo` (
                        `MOTIVO_ID` INT NOT NULL AUTO_INCREMENT,
                        `DESCRICAO` VARCHAR(255) NULL,
                            PRIMARY KEY (`MOTIVO_ID`)
                    );
                ";

                DB::select($table_motivo_DROP);

                DB::select($table_motivo_CREATE);

                DB::table($table_motivo)->insert([
                    'DESCRICAO' => 'Motivo 1',
                ]);
                DB::table($table_motivo)->insert([
                    'DESCRICAO' => 'Motivo 2',
                ]);
                DB::table($table_motivo)->insert([
                    'DESCRICAO' => 'Motivo 3',
                ]);

                DB::select("ALTER TABLE  `$table_pedido` ADD COLUMN `MOTIVO_ID` INT NULL AFTER `STATUS_ID`;");
            }
            if ($num == 3) {
                $teste = DB::select("ALTER TABLE `sad__usuario` LIMIT 10");
                dd($teste);
                DB::select("ALTER TABLE `sad__pedido` ADD COLUMN `NFE` INT NULL DEFAULT 0 AFTER `MOTIVO_ID`;");
            }

            die('feito');
        } else {
            die('acesso negado');
        }
    }

    public function teste()
    {
        $user = Usuario::find(1);
        
        dd(
            base64_decode($user->SENHA),
            $user
        );
    }
}
