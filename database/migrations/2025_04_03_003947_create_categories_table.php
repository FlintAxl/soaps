<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->timestamps();
        });

        // Insert the default categories
        DB::table('categories')->insert([
            ['description' => 'Personal Hygiene'],
            ['description' => 'Laundry'],
            ['description' => 'Dishwashing '],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
