<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InstituicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_instituicao')->insert([
            [
                'id' => 1,
                'cnpj_instituicao' => '12.345.678/0001-90',
                'verificado_instituicao' => 1,
                'logradouro_instituicao' => 'Rua das Flores',
                'num_logradouro_instituicao' => '123',
                'bairro_instituicao' => 'Centro',
                'cidade_instituicao' => 'São Paulo',
                'estado_instituicao' => 'SP',
                'cep_instituicao' => '01001-000',
                'complemento_instituicao' => 'Próximo à praça',
                'id_user' => 21,
                'created_at' => Carbon::parse('2025-04-27 00:39:15'),
                'updated_at' => Carbon::parse('2025-04-27 00:39:15')
            ],
            [
                'id' => 2,
                'cnpj_instituicao' => '98.765.432/0001-11',
                'verificado_instituicao' => 0,
                'logradouro_instituicao' => 'Avenida Principal',
                'num_logradouro_instituicao' => '456',
                'bairro_instituicao' => 'Jardim das Palmeiras',
                'cidade_instituicao' => 'Rio de Janeiro',
                'estado_instituicao' => 'RJ',
                'cep_instituicao' => '20000-000',
                'complemento_instituicao' => 'Sala 101',
                'id_user' => 22,
                'created_at' => Carbon::parse('2025-04-27 00:39:15'),
                'updated_at' => Carbon::parse('2025-04-27 00:39:15')
            ],
            [
                'id' => 3,
                'cnpj_instituicao' => '11.222.333/0001-44',
                'verificado_instituicao' => 1,
                'logradouro_instituicao' => 'Travessa das Oliveiras',
                'num_logradouro_instituicao' => '789',
                'bairro_instituicao' => 'Bela Vista',
                'cidade_instituicao' => 'Belo Horizonte',
                'estado_instituicao' => 'MG',
                'cep_instituicao' => '30000-000',
                'complemento_instituicao' => 'Fundos',
                'id_user' => 23,
                'created_at' => Carbon::parse('2025-04-27 00:39:15'),
                'updated_at' => Carbon::parse('2025-04-27 00:39:15')
            ],
            [
                'id' => 4,
                'cnpj_instituicao' => '55.666.777/0001-22',
                'verificado_instituicao' => 1,
                'logradouro_instituicao' => 'Alameda dos Anjos',
                'num_logradouro_instituicao' => '101',
                'bairro_instituicao' => 'Vila Nova',
                'cidade_instituicao' => 'Curitiba',
                'estado_instituicao' => 'PR',
                'cep_instituicao' => '80000-000',
                'complemento_instituicao' => 'Casa 2',
                'id_user' => 24,
                'created_at' => Carbon::parse('2025-04-27 00:39:15'),
                'updated_at' => Carbon::parse('2025-04-27 00:39:15')
            ],
            [
                'id' => 5,
                'cnpj_instituicao' => '88.999.000/0001-55',
                'verificado_instituicao' => 0,
                'logradouro_instituicao' => 'R. Feliciano de Mendonça, 290',
                'num_logradouro_instituicao' => '321',
                'bairro_instituicao' => 'Guaianases',
                'cidade_instituicao' => 'São Paulo',
                'estado_instituicao' => 'SP',
                'cep_instituicao' => '40000-000',
                'complemento_instituicao' => 'Próximo a praça da glória',
                'id_user' => 25,
                'created_at' => Carbon::parse('2025-04-27 00:39:15'),
                'updated_at' => Carbon::parse('2025-04-27 00:39:15')
            ]
        ]);
    }
}