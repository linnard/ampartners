<?php

use Illuminate\Database\Seeder;

class PropertyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Viber',
            'Skype',
            'Telegram',
            'WhatsApp',
            'Телефон'
        ];

        foreach ($types as $type){
            \App\Models\PropertyType::create([
                'name' => $type
            ]);
        }

    }


}
