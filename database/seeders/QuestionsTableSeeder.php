<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            $question = Question::create([
                'subject_id' => 1,
                'question' => 'Question ' . $i,
            ]);

            if($question){
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'A'
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'B'
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'C',
                    'is_correct' => 1
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'D'
                ]);
            }
        }

        for ($i = 1; $i <= 20; $i++) {
            $question = Question::create([
                'subject_id' => 2,
                'question' => 'Question ' . $i,
            ]);

            if($question){
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'A'
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'B'
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'C',
                    'is_correct' => 1
                ]);
                QuestionAnswer::create([
                    'question_id' => $question->id,
                    'value' => 'D'
                ]);
            }
        }
    }
}
