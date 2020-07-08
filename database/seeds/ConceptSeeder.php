<?php

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\Term;

class ConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $teacher_concept = Concept::create(["deprecated" => false]);

        $teacher_terms = [
            ["text" => "Teachers", "preferred" => true],
            ["text" => "Educators", "preferred" => false],
            ["text" => "Faculty (Teachers", "preferred" => false],
            ["text" => "Instructors", "preferred" => false],
            ["text" => "Schoolteachers", "preferred" => false],
            ["text" => "School teachers", "preferred" => false]
        ];

        foreach ($teacher_terms as $term) {
            $teacher_concept->terms()->create($term);
        }

    }
}
