<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\PseudoTypes\PositiveInteger;
use phpDocumentor\Reflection\Types\Integer;

class QuestionAndAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // open json file
        // iterate each line
        // the key becomes the question
        // iterate over each value
        // string becomes answer, int becomes weight

        $data = file_get_contents(resource_path('app_data/questions.json'));
        $parsedToJson = json_decode($data, true);

        collect($parsedToJson)->each(function (array $answers, string $question) {
            $question = Question::query()->updateOrCreate(['text' => $question]);

            collect($answers)->each(function ($answer_values) use ($question) {
               $answer = Answer::query()->updateOrCreate([
                   'question_id' => $question->id,
                   'text' => $answer_values[0],
                   'weight' => $answer_values[1]
               ]);
            });
        });
    }
}
