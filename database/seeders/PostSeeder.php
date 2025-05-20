<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_post')->insert([
            [
                'id' => 68,
                'status_post' => 1,
                'titulo_post' => 'Inscrições abertas!',
                'conteudo_post' => 'EtecInscricoes.jpg',
                'descricao_post' => 'Atenção candidatos do Vestibulinho!
As inscrições para nossos cursos para o 1° semestre de 2025 estão abertas!
Aproveitem as chances para ingressar em cursos de Ensino Médio ou Cursos Técnicos.',
                'id_user' => 25,
                'created_at' => Carbon::parse('2025-04-26 21:58:29'),
                'updated_at' => Carbon::parse('2025-04-26 21:58:29')
            ],
            [
                'id' => 69,
                'status_post' => 1,
                'titulo_post' => 'Já sabe como fazer a inscrição?',
                'conteudo_post' => 'EtecInstrucoes.png',
                'descricao_post' => 'Veja onde consultar seu local de exame e o que levar. Não cometa o erro de ir sem levar os documentos necessários.',
                'id_user' => 25,
                'created_at' => Carbon::parse('2025-04-26 22:35:15'),
                'updated_at' => Carbon::parse('2025-04-26 22:35:15')
            ],
            [
                'id' => 70,
                'status_post' => 1,
                'titulo_post' => 'Manual do candidato',
                'conteudo_post' => 'EtecManual.png',
                'descricao_post' => 'Leia o manual do candidato para não se preparar e não cometer nenhum erro.',
                'id_user' => 25,
                'created_at' => Carbon::parse('2025-04-26 22:39:34'),
                'updated_at' => Carbon::parse('2025-04-26 22:39:34')
            ],
            [
                'id' => 71,
                'status_post' => 1,
                'titulo_post' => 'Inscrições abertas.',
                'conteudo_post' => 'FatecInscricoes.jpg',
                'descricao_post' => 'Inscrições abertas para a Fatec. Veja o calendário e se prepare para ingressar no ensino superior',
                'id_user' => 21,
                'created_at' => Carbon::parse('2025-04-26 22:42:29'),
                'updated_at' => Carbon::parse('2025-04-26 22:42:29')
            ],
            [
                'id' => 72,
                'status_post' => 1,
                'titulo_post' => 'Período de isenção',
                'conteudo_post' => 'FatecIsencao.png',
                'descricao_post' => 'Aproveite o período de isenção antes que acabe!',
                'id_user' => 21,
                'created_at' => Carbon::parse('2025-04-26 22:48:59'),
                'updated_at' => Carbon::parse('2025-04-26 22:48:59')
            ],
            [
                'id' => 73,
                'status_post' => 1,
                'titulo_post' => 'Etapas do processo seletivo',
                'conteudo_post' => 'FatecProcesso.png',
                'descricao_post' => 'Confira as datas do nosso processo seletivo para não ter chances de perder o período.',
                'id_user' => 21,
                'created_at' => Carbon::parse('2025-04-26 22:51:09'),
                'updated_at' => Carbon::parse('2025-04-26 22:51:09')
            ],
            [
                'id' => 74,
                'status_post' => 1,
                'titulo_post' => 'Inscrições abertas pro Senai',
                'conteudo_post' => 'SenaiInscricoes.jpeg',
                'descricao_post' => 'Inscrições abertas para os cursos gratuitos do Senai! Comece o ano investindo no seu crescimento próprio.',
                'id_user' => 22,
                'created_at' => Carbon::parse('2025-04-26 22:57:02'),
                'updated_at' => Carbon::parse('2025-04-26 22:57:02')
            ],
            [
                'id' => 75,
                'status_post' => 1,
                'titulo_post' => 'Aproveite o processo seletivo',
                'conteudo_post' => 'SenaiDica.png',
                'descricao_post' => 'Faça uma formação profissionalizante de qualidade.',
                'id_user' => 22,
                'created_at' => Carbon::parse('2025-04-26 23:03:17'),
                'updated_at' => Carbon::parse('2025-04-26 23:03:17')
            ],
            [
                'id' => 76,
                'status_post' => 1,
                'titulo_post' => '10 mil vagas gratuitas.',
                'conteudo_post' => 'SenaiVagas.png',
                'descricao_post' => 'Venha ser um dos nossos alunos neste ano e se inscreva para uma das vagas em algum curso de seu interesse!',
                'id_user' => 22,
                'created_at' => Carbon::parse('2025-04-26 23:10:28'),
                'updated_at' => Carbon::parse('2025-04-26 23:10:28')
            ],
            [
                'id' => 77,
                'status_post' => 1,
                'titulo_post' => 'Inscrições do Sesi',
                'conteudo_post' => 'SesiInscricoes.png',
                'descricao_post' => 'Acesse o Sesi e confira a disponibilidade de vagas.',
                'id_user' => 23,
                'created_at' => Carbon::parse('2025-04-26 23:12:55'),
                'updated_at' => Carbon::parse('2025-04-26 23:12:55')
            ],
            [
                'id' => 78,
                'status_post' => 1,
                'titulo_post' => 'Não esqueça de fazer sua inscrição!',
                'conteudo_post' => 'SesiNaoEsqueca.jpg',
                'descricao_post' => 'As inscrições de 2025 ainda estão abertas. Não perca a chance de fazer sua inscrição no Sesi.',
                'id_user' => 23,
                'created_at' => Carbon::parse('2025-04-26 23:16:45'),
                'updated_at' => Carbon::parse('2025-04-26 23:16:45')
            ],
            [
                'id' => 79,
                'status_post' => 1,
                'titulo_post' => 'Semana de inovação',
                'conteudo_post' => 'EnapSemanaInovacao.png',
                'descricao_post' => 'As inscrições estão abertas para a semana de inovação! Entre no site e aproveite a oportunidade para conhecer este grande evento!',
                'id_user' => 24,
                'created_at' => Carbon::parse('2025-04-26 23:20:30'),
                'updated_at' => Carbon::parse('2025-04-26 23:20:30')
            ],
            [
                'id' => 81,
                'status_post' => 1,
                'titulo_post' => 'Seleção para bolsa de Estudos!',
                'conteudo_post' => 'EnapBolsaEstudo.png',
                'descricao_post' => 'A seleção para bolsa de estudos começou. Faça sua inscrição o quanmt',
                'id_user' => 24,
                'created_at' => Carbon::parse('2025-04-26 23:32:46'),
                'updated_at' => Carbon::parse('2025-04-26 23:32:46')
            ],
            [
                'id' => 82,
                'status_post' => 1,
                'titulo_post' => 'Gestão pública',
                'conteudo_post' => 'EnapGestao.png',
                'descricao_post' => 'Especialização de gestão pública',
                'id_user' => 24,
                'created_at' => Carbon::parse('2025-04-26 23:32:57'),
                'updated_at' => Carbon::parse('2025-04-26 23:32:57')
            ],
            [
                'id' => 83,
                'status_post' => 1,
                'titulo_post' => 'quero dormir',
                'conteudo_post' => 'imgRian.jpg',
                'descricao_post' => 'são 04:43 e to desde as 21:00 codando e não resolvi tudo kkkksocorro',
                'id_user' => 2,
                'created_at' => Carbon::parse('2025-04-26 23:43:08'),
                'updated_at' => Carbon::parse('2025-04-26 23:43:08')
            ],
            [
                'id' => 84,
                'status_post' => 1,
                'titulo_post' => 'paz',
                'conteudo_post' => 'imgRian2.jpeg',
                'descricao_post' => 'sexta feira, play tv. tamo como? no recolhe.',
                'id_user' => 2,
                'created_at' => Carbon::parse('2025-04-26 23:51:19'),
                'updated_at' => Carbon::parse('2025-04-26 23:51:19')
            ],
            [
                'id' => 85,
                'status_post' => 1,
                'titulo_post' => 'slk isso é crueldade',
                'conteudo_post' => 'imgHugo.jpg',
                'descricao_post' => 'rapazeada oia oq eu aprendi KKKK',
                'id_user' => 4,
                'created_at' => Carbon::parse('2025-04-26 23:53:43'),
                'updated_at' => Carbon::parse('2025-04-26 23:53:43')
            ],
            [
                'id' => 86,
                'status_post' => 1,
                'titulo_post' => 'Deus tenha piedade',
                'conteudo_post' => 'imgHugo2.jpg',
                'descricao_post' => 'slk se minha mãe descobrir q eu to usando Java ela vai me deserdar tamaluco',
                'id_user' => 4,
                'created_at' => Carbon::parse('2025-04-26 23:58:28'),
                'updated_at' => Carbon::parse('2025-04-26 23:58:28')
            ],
            [
                'id' => 87,
                'status_post' => 1,
                'titulo_post' => 'é oficial:',
                'conteudo_post' => 'imgBreno.png',
                'descricao_post' => 'perdi meu projeto todo pq o arquivo corrompeu',
                'id_user' => 3,
                'created_at' => Carbon::parse('2025-04-26 23:59:42'),
                'updated_at' => Carbon::parse('2025-04-26 23:59:42')
            ],
            [
                'id' => 88,
                'status_post' => 1,
                'titulo_post' => 'finalmente algo saiu',
                'conteudo_post' => 'imgBreno2.png',
                'descricao_post' => 'horas no pc, mas finalmente saiu algo aqui',
                'id_user' => 3,
                'created_at' => Carbon::parse('2025-04-27 00:04:02'),
                'updated_at' => Carbon::parse('2025-04-27 00:04:02')
            ],
            [
                'id' => 89,
                'status_post' => 1,
                'titulo_post' => '!!!!!!',
                'conteudo_post' => 'imgCarol.png',
                'descricao_post' => 'Terminei esses dias e amei, entrou pra lista de meus animes favoritos com certeza!!!',
                'id_user' => 8,
                'created_at' => Carbon::parse('2025-04-27 00:09:31'),
                'updated_at' => Carbon::parse('2025-04-27 00:09:31')
            ],
            [
                'id' => 90,
                'status_post' => 1,
                'titulo_post' => 'aaa eu preciso disso',
                'conteudo_post' => 'imgCarol2.png',
                'descricao_post' => 'Gente, alguém que já leu pode me dizer se esse livro é bom? To procurando um livro bom de programação pra sabe, programar...',
                'id_user' => 8,
                'created_at' => Carbon::parse('2025-04-27 00:11:17'),
                'updated_at' => Carbon::parse('2025-04-27 00:11:17')
            ],
            [
                'id' => 91,
                'status_post' => 1,
                'titulo_post' => 'anotando',
                'conteudo_post' => 'imgEduardo.jpg',
                'descricao_post' => 'estudando e anotando passo por passo.',
                'id_user' => 6,
                'created_at' => Carbon::parse('2025-04-27 00:13:06'),
                'updated_at' => Carbon::parse('2025-04-27 00:13:06')
            ],
            [
                'id' => 92,
                'status_post' => 1,
                'titulo_post' => 'desculpa mãe desculpa pai',
                'conteudo_post' => 'imgEduardo2.png',
                'descricao_post' => 'desculpa gente, fazem uns dias já, mas eu comecei a usar PHP... eu errei gente desculpa',
                'id_user' => 6,
                'created_at' => Carbon::parse('2025-04-27 00:14:41'),
                'updated_at' => Carbon::parse('2025-04-27 00:14:41')
            ],
            [
                'id' => 93,
                'status_post' => 1,
                'titulo_post' => 'só reclamação aff',
                'conteudo_post' => 'imgEllen.jpg',
                'descricao_post' => 'horas codando uma telinha bonitinha pra todo mundo apontar e dar risada, mds',
                'id_user' => 7,
                'created_at' => Carbon::parse('2025-04-27 00:16:08'),
                'updated_at' => Carbon::parse('2025-04-27 00:16:08')
            ],
            [
                'id' => 94,
                'status_post' => 1,
                'titulo_post' => 'só queria um canto responsa',
                'conteudo_post' => 'imgEllen2.jpg',
                'descricao_post' => 'Deus lhe pedi um canto para ficar e dormir, não um templo demolido acabado feio desmoronado...',
                'id_user' => 7,
                'created_at' => Carbon::parse('2025-04-27 00:19:51'),
                'updated_at' => Carbon::parse('2025-04-27 00:19:51')
            ],
            [
                'id' => 95,
                'status_post' => 1,
                'titulo_post' => 'é o maior',
                'conteudo_post' => 'imgFelipe.jpeg',
                'descricao_post' => '"ai q n sei oq corinthians n sei oq lá" xiu, apenas aceite fi.',
                'id_user' => 9,
                'created_at' => Carbon::parse('2025-04-27 00:21:56'),
                'updated_at' => Carbon::parse('2025-04-27 00:21:56')
            ],
            [
                'id' => 96,
                'status_post' => 1,
                'titulo_post' => 'esse cara é bomzão',
                'conteudo_post' => 'imgFelipe2.jpeg',
                'descricao_post' => 'slk numa hora com esse cara aprendi conteudo de semaninhas. Programação Web o canal do cara, vejam lá o cara ensina bem',
                'id_user' => 9,
                'created_at' => Carbon::parse('2025-04-27 00:24:07'),
                'updated_at' => Carbon::parse('2025-04-27 00:24:07')
            ],
            [
                'id' => 97,
                'status_post' => 1,
                'titulo_post' => 'prontin pra chorar',
                'conteudo_post' => 'imgGuilherme.png',
                'descricao_post' => 'começando esse joguinho agr, to jogando pq é indie ent deve ser bom',
                'id_user' => 1,
                'created_at' => Carbon::parse('2025-04-27 00:43:26'),
                'updated_at' => Carbon::parse('2025-04-27 00:43:26')
            ],
            [
                'id' => 98,
                'status_post' => 1,
                'titulo_post' => 'alguem dá um help',
                'conteudo_post' => 'imgGuilherme2.png',
                'descricao_post' => 'cês consegue recomendar um curso pra eu fazer aí? to mto em dúvida de qual curso fazer pro futuro',
                'id_user' => 1,
                'created_at' => Carbon::parse('2025-04-27 00:49:55'),
                'updated_at' => Carbon::parse('2025-04-27 00:49:55')
            ],
            [
                'id' => 99,
                'status_post' => 1,
                'titulo_post' => 'silencio',
                'conteudo_post' => 'imgVictor.jpg',
                'descricao_post' => 'silêncio rapazes, estou a estudar.',
                'id_user' => 5,
                'created_at' => Carbon::parse('2025-04-27 01:01:28'),
                'updated_at' => Carbon::parse('2025-04-27 01:01:28')
            ],
            [
                'id' => 100,
                'status_post' => 1,
                'titulo_post' => 'incabível essa parada pprt',
                'conteudo_post' => 'imgVictor2.jpeg',
                'descricao_post' => 'o cara não teve nem coragem de esconder que mudou o banco de base do PRÓPRIO JOGO pra passar da gente. (tá guardado Lulu, tá guardado)',
                'id_user' => 5,
                'created_at' => Carbon::parse('2025-04-27 01:02:48'),
                'updated_at' => Carbon::parse('2025-04-27 01:02:48')
            ],
            [
                'id' => 101,
                'status_post' => 1,
                'titulo_post' => 'albumzão forte',
                'conteudo_post' => 'imgKlayver.png',
                'descricao_post' => 'albumzão fortissimo tamaluco, n erra nunca',
                'id_user' => 10,
                'created_at' => Carbon::parse('2025-04-27 01:07:13'),
                'updated_at' => Carbon::parse('2025-04-27 01:07:13')
            ],
            [
                'id' => 102,
                'status_post' => 1,
                'titulo_post' => 'assistam...',
                'conteudo_post' => 'imgKlayver2.jpg',
                'descricao_post' => 'esse carinha ta me motivando a cursar algo da área, parece o tipo de coisa q eu ia me ver trabalhando daqui uns anos',
                'id_user' => 10,
                'created_at' => Carbon::parse('2025-04-27 01:12:02'),
                'updated_at' => Carbon::parse('2025-04-27 01:12:02')
            ],
            [
                'id' => 103,
                'status_post' => 1,
                'titulo_post' => 'pinguim.',
                'conteudo_post' => 'imgClodoaldo.jpg',
                'descricao_post' => 'eu gosto muito de pinguins',
                'id_user' => 14,
                'created_at' => Carbon::parse('2025-04-27 01:19:06'),
                'updated_at' => Carbon::parse('2025-04-27 01:19:06')
            ],
            [
                'id' => 104,
                'status_post' => 1,
                'titulo_post' => 'dúvida genuina',
                'conteudo_post' => 'imgThiago.jpg',
                'descricao_post' => 'Preciso muito de alguém me recomendar o que cursar. To muito em duvida doq escolher antes de me inscrever',
                'id_user' => 16,
                'created_at' => Carbon::parse('2025-04-27 01:20:57'),
                'updated_at' => Carbon::parse('2025-04-27 01:20:57')
            ],
            [
                'id' => 105,
                'status_post' => 1,
                'titulo_post' => 'cansados de TCC, juro',
                'conteudo_post' => 'imgJuniorAline.png',
                'descricao_post' => 'Cansados desses alunos de TCC, só trabalho pra gente nossa, cadê as férias?',
                'id_user' => 19,
                'created_at' => Carbon::parse('2025-04-27 01:22:43'),
                'updated_at' => Carbon::parse('2025-04-27 01:22:43')
            ],
            [
                'id' => 106,
                'status_post' => 1,
                'titulo_post' => 'livro muito bom',
                'conteudo_post' => 'imgLuciano.jpg',
                'descricao_post' => 'Terminei e gostei. Recomendo a leitura pra todos.',
                'id_user' => 17,
                'created_at' => Carbon::parse('2025-04-27 01:24:31'),
                'updated_at' => Carbon::parse('2025-04-27 01:24:31')
            ]
        ]);
    }
}