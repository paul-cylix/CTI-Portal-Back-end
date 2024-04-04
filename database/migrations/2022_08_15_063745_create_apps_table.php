<?php

use App\Models\App;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->string('mode');
            $table->integer('category_id');
            $table->string('notes')->nullable();
            $table->string('loc_address');
            $table->date('date_entry');
            $table->dateTime('time_entry');
            $table->double('latitude');
            $table->double('longitude');
            $table->longText('images');
            $table->string('timestart')->nullable();
            $table->boolean('push_status')->default(App::TRUE)->nullable();
            $table->boolean('first_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
};
