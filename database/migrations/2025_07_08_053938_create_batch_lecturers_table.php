<?php

use App\Models\Batch;
use App\Models\Lecturer;
use App\Models\Module;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchLecturersTable extends Migration
{
    public function up()
    {
        Schema::create('batch_lecturers', function (Blueprint $table) {
            // Composite primary key or just unique index

            // Composite primary key
            
            // Foreign keys
            
            $table->foreignIdFor(Batch::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Lecturer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Module::class)->constrained()->cascadeOnDelete();
            $table->primary(['batch_id', 'lecturer_id', 'module_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('batch_lecturers');
    }
}
