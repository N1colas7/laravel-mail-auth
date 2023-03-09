<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = ['Technology-1', 'Technology-2', 'Technology-3', 'Technology-4', 'Technology-5'];

        foreach($technologies as $tech){
            $newTechnology = new Technology();
            $newTechnology->name = $tech;
            $newTechnology->slug = Technology::generateSlug($newTechnology->name);

            $newTechnology->save();
        }
    }
}
