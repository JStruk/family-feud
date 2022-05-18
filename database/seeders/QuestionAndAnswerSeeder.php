<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        $data = file_get_contents(resource_path('app_data/questions.json'));
        $parsedToJson = json_decode($data, true);

        Schema::disableForeignKeyConstraints();
        Answer::query()->truncate();
        Question::query()->truncate();
        Schema::enableForeignKeyConstraints();

        $nextQuestionId = 1;
        $questions = collect([]);
        $answersToInsert = collect([]);

        collect($parsedToJson)->unique()->each(function (array $answers, string $question) use (&$nextQuestionId, $questions, $answersToInsert) {
            $questions->add([
                "text" => $question,
                "id" => $nextQuestionId
            ]);

            collect($answers)->unique()->each(function ($answer_values) use ($nextQuestionId, $answersToInsert) {
                $answersToInsert->add([
                    'question_id' => $nextQuestionId,
                    'text' => $answer_values[0],
                    'weight' => $answer_values[1]
                ]);
            });
            $nextQuestionId = $nextQuestionId + 1;
        });

        Question::query()->insert($questions->toArray());
        Answer::query()->insert($answersToInsert->toArray());
    }
}
