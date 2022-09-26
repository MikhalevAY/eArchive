<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dictionaries')->insert([
            [
                'title' => 'Казахский',
                'type' => 'language'
            ],
            [
                'title' => 'Русский',
                'type' => 'language'
            ],
            [
                'title' => 'Английский',
                'type' => 'language'
            ],
            [
                'title' => 'Электронная почта',
                'type' => 'delivery_type'
            ],
            [
                'title' => 'Курьерский пакет',
                'type' => 'delivery_type'
            ],
            [
                'title' => 'Факс',
                'type' => 'delivery_type'
            ],
            [
                'title' => 'ЕСЭДО',
                'type' => 'delivery_type'
            ],
            [
                'title' => 'Apple',
                'type' => 'counterparty'
            ],
            [
                'title' => 'Samsung',
                'type' => 'counterparty'
            ],
            [
                'title' => 'Xiaomi',
                'type' => 'counterparty'
            ],
            [
                'title' => 'Входящее письмо',
                'type' => 'document_type'
            ],
            [
                'title' => 'Исходящее письмо',
                'type' => 'document_type'
            ],
            [
                'title' => 'Служебная записка',
                'type' => 'document_type'
            ],
            [
                'title' => 'Типовая',
                'type' => 'case_nomenclature'
            ],
            [
                'title' => 'Примерная',
                'type' => 'case_nomenclature'
            ],
            [
                'title' => 'Индивидуальная',
                'type' => 'case_nomenclature'
            ],
        ]);
    }
}
