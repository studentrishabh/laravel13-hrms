<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('employees', function (Blueprint $table) {
        $table->id();

        $table->string('employee_code')->unique();

        $table->string('name');

        $table->string('email')->unique();

        $table->string('phone', 15)->nullable();

        $table->string('gender', 20)->nullable();

        $table->string('department');

        $table->string('designation');

        $table->decimal('salary', 12, 2)->default(0);

        $table->date('joining_date');

        $table->enum('status', ['active', 'inactive'])
              ->default('active');

        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('employees', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
    }
};
