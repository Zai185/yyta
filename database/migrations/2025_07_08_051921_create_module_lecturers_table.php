<?php

use App\Models\Lecturer;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleLecturersTable extends Migration
{
    public function up()
    {
        Schema::create('module_lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Module::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lecturer::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
            
            $table->unique(['module_id', 'lecturer_id']); // prevent duplicates
        });
    }

    public function down()
    {
        Schema::dropIfExists('module_lecturers');
    }
}
