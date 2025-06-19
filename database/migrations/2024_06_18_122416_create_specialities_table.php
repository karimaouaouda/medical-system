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
        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')
                ->nullable();
            $table->timestamps();
        });


        \Illuminate\Support\Facades\DB::table('specialities')->insert([
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Cardiology', 'description' => 'The study and treatment of heart disorders.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Dermatology', 'description' => 'The branch of medicine focused on skin, hair, and nail disorders.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Neurology', 'description' => 'The study and treatment of nervous system disorders.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Pediatrics', 'description' => 'Medical care for infants, children, and adolescents.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Orthopedics', 'description' => 'The study and treatment of musculoskeletal system disorders.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Radiology', 'description' => 'The use of medical imaging to diagnose and treat illnesses.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Gynecology', 'description' => 'The medical practice dealing with the female reproductive system.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Oncology', 'description' => 'The study and treatment of cancer.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Psychiatry', 'description' => 'The diagnosis, prevention, and treatment of mental disorders.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Urology', 'description' => 'The branch of medicine dealing with the urinary tract and male reproductive organs.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Gastroenterology', 'description' => 'The study and treatment of disorders of the digestive system.'],
            ['created_at' => now(), 'updated_at' => now(),  'name' => 'Ophthalmology', 'description' => 'The branch of medicine dealing with the eyes and vision.']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialities');
    }
};
