<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create('ru_RU');

        return [
            'type_id' => 11,
            'case_nomenclature_id' => 15,
            'income_number' => $this->faker->hexColor,
            'registration_date' => $this->faker->date,
            'registration_time' => $this->faker->time,
            'author_email' => 'ivan@test.kz',
            'outgoing_number' => rand(100000, 999999),
            'outgoing_date' => $this->faker->date,
            'sender_id' => rand(8, 10),
            'receiver_id' => rand(8, 10),
            'addressee' => $faker->name . ' ' . $faker->lastName,
            'question' => $faker->realText(300),
            'delivery_type_id' => 4,
            'number_of_sheets' => rand(10, 40),
            'language_id' => rand(1, 3),
            'summary' => $faker->realText(300),
            'shelf_life' => 5,
            'note' => $faker->realText(300),
            'answer_to_number' => rand(1000, 9999),
            'gr_document' => $this->faker->boolean,
            'performer' => $faker->name . ' ' . $faker->lastName,
            'text' => $faker->realText(30000),
            'history' => $faker->realText(500),
            'file' => 'documents/random-file.pdf',
            'file_name' => $this->faker->sentence(2),
            'is_draft' => false,
            'answer_to_date' => $this->faker->date,
            'file_size' => 2
        ];
    }
}
