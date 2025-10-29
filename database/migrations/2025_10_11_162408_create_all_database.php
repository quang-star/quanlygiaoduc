<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Example for users table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('email', 255)->unique();
                $table->string('phone_number', 20)->nullable();
                $table->string('password', 255);
                $table->string('avatar', 255)->nullable();
                $table->date('birthday')->nullable();
                $table->double('base_salary')->nullable();
                $table->integer('role'); // ->comment('1=admin, 2=staff, 3=student, 4=supporter')
                $table->integer('active')->nullable(); // 0 || null là đã active, 1 la chua active
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Example for languages table
        if (!Schema::hasTable('languages')) {
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('code', 10);
                $table->string('name', 255);
                $table->timestamps();
            });
        }

        // ... and so on for all other tables
        // ---------------- CERTIFICATES ----------------
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->integer('language_id')->index();
                $table->string('code', 50);
                $table->string('name', 255);
                $table->timestamps();
            });
        }

        // ---------------- LEVELS ----------------
        if (!Schema::hasTable('levels')) {
            Schema::create('levels', function (Blueprint $table) {
                $table->id();
                $table->integer('name'); // Removed size, 'name' column definition was 'int(255)' in original, better as string or specific int type
                $table->integer('certificate_id')->index();
                $table->double('min_score')->nullable();
                $table->double('max_score')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- COURSES ----------------
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50);
                $table->string('name', 255);
                $table->integer('language_id')->index();
                $table->integer('certificate_id')->index();
                $table->integer('level_id')->index();
                $table->double('price')->nullable();
                $table->integer('total_lesson')->nullable();
                $table->integer('lesson_per_week')->nullable();
                $table->integer('max_student')->nullable();
                $table->integer('min_student')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- STUDENT PROFILES ----------------
        if (!Schema::hasTable('student_profiles')) {
            Schema::create('student_profiles', function (Blueprint $table) {
                $table->id();
                $table->integer('student_id')->index();
                $table->integer('language_id')->index();
                $table->integer('current_level_id')->nullable()->index();
                $table->integer('certificate_id')->nullable()->index();
                $table->integer('class_id')->nullable(); // Removed ->index() from original, as there is no `classes.id` yet when student_profiles might be created, better to add as foreign key later
                $table->integer('status');
                $table->timestamps();
            });
        }

        // ---------------- CLASSES ----------------
        if (!Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->integer('teacher_id')->index();
                $table->integer('course_id')->index();
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->integer('total_lesson')->nullable();
                $table->integer('lesson_per_week')->nullable();
                $table->string('schedule', 255)->nullable();
                $table->time('time_start')->nullable();
                $table->time('time_end')->nullable();
                $table->integer('min_student')->nullable();
                $table->integer('max_student')->nullable();
                $table->integer('status')->nullable();
                $table->string('note', 255)->nullable();
                $table->text('day_learn')->nullable(); // Changed to text as per your SQL dump
                $table->timestamps();
                $table->integer('supporter_id')->nullable(); // Added based on your SQL dump
            });
        }

        // ---------------- ATTENDANCES ----------------
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                $table->integer('student_profile_id')->index();
                $table->integer('class_id')->index();
                $table->timestamp('time_attendance')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- ENTRANCE EXAMS ----------------
        if (!Schema::hasTable('entrance_exams')) {
            Schema::create('entrance_exams', function (Blueprint $table) {
                $table->id();
                $table->integer('certificate_id')->index();
                $table->string('name', 255)->nullable();
                $table->string('pdf_test_file', 255)->nullable();
                $table->timestamps();
            });
        }

        // ---------------- TEST RESULTS ----------------
        if (!Schema::hasTable('test_results')) {
            Schema::create('test_results', function (Blueprint $table) {
                $table->id();
                $table->integer('student_profile_id')->index(); // Changed to student_profile_id as per SQL dump
                $table->integer('exam_id')->nullable()->index();
                $table->timestamp('test_date')->nullable();
                $table->double('total_score')->nullable();
                $table->string('result_status', 50)->nullable();
                $table->timestamps();
            });
        }

        // ---------------- CONTRACTS ----------------
        if (!Schema::hasTable('contracts')) {
            Schema::create('contracts', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50);
                $table->integer('student_profile_id')->index();
                $table->integer('course_id')->nullable()->index(); // Added based on SQL dump
                $table->timestamp('sign_date')->nullable();
                $table->integer('certificate_id')->nullable()->index();
                $table->integer('class_id')->nullable()->index();
                $table->text('note')->nullable(); // Changed to text as per SQL dump
                $table->double('collected')->default(0); // Added based on SQL dump
                $table->integer('status')->nullable();
                $table->double('total_value');
                $table->timestamps();
            });
        }

        // ---------------- BANK ACCOUNTS ----------------
        if (!Schema::hasTable('bank_accounts')) {
            Schema::create('bank_accounts', function (Blueprint $table) {
                $table->id();
                $table->string('bank', 255);
                $table->string('account_number', 50);
                $table->timestamps();
                $table->integer('user_id')->nullable(); // Made nullable based on SQL dump
            });
        }

        // ---------------- BILL HISTORIES ----------------
        if (!Schema::hasTable('bill_histories')) {
            Schema::create('bill_histories', function (Blueprint $table) {
                $table->id();
                $table->integer('contract_id')->index();
                $table->timestamp('payment_time')->nullable();
                $table->string('phone_number', 20)->nullable();
                $table->double('money');
                $table->integer('bank_account_id')->nullable()->index();
                $table->string('image', 255)->nullable();
                $table->text('content')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- SHIFTS ----------------
        if (!Schema::hasTable('shifts')) {
            Schema::create('shifts', function (Blueprint $table) {
                $table->id();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->timestamps(); // Default CURRENT_TIMESTAMP is handled by Laravel
            });
        }

        // ---------------- TEACHER SALARIES ----------------
        if (!Schema::hasTable('teacher_salaries')) {
            Schema::create('teacher_salaries', function (Blueprint $table) {
                $table->id();
                $table->integer('teacher_id')->index();
                $table->string('month', 20);
                $table->integer('total_sessions')->default(0);
                $table->double('base_salary')->default(0);
                $table->double('bonus')->default(0);
                $table->double('penalty')->default(0);
                $table->double('total_salary')->default(0);
                $table->string('bank_name')->nullable();
                $table->string('account_number')->nullable();
                $table->tinyInteger('status')->default(0)->comment('0: chưa tính lương, 1: đã tính lương'); // Changed to tinyInteger for 0/1 status
                $table->text('note')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- CHECK EXERCISES ----------------
        if (!Schema::hasTable('check_exercises')) {
            Schema::create('check_exercises', function (Blueprint $table) {
                $table->id();
                $table->timestamp('time_check')->nullable();
                $table->integer('class_id')->nullable();
                $table->integer('student_profile_id')->nullable();
                $table->timestamps();
            });
        }

        // ---------------- SETTINGS ----------------
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // Foreign key constraints can be added separately or after all tables are created
        // This ensures referenced tables exist before constraint creation.

        // Add foreign key for classes.supporter_id after users table exists
        if (Schema::hasTable('classes')) {
            Schema::table('classes', function (Blueprint $table) {
                // Check if the column already exists before adding
                if (!Schema::hasColumn('classes', 'supporter_id')) {
                    $table->integer('supporter_id')->nullable()->after('updated_at'); // Added this line based on your SQL dump
                }
                // $table->foreign('supporter_id')->references('id')->on('users')->onDelete('set null'); // Example foreign key
            });
        }

        // This section is commented out because it's typically added in separate migrations
        // or directly in the table definition if order is guaranteed.
        // It's good practice to add foreign keys in their own `Schema::table` calls
        // to handle potential circular dependencies or out-of-order creation.
        // For example:
        // Schema::table('attendances', function (Blueprint $table) {
        //     $table->foreign('student_profile_id')->references('id')->on('student_profiles')->onDelete('cascade');
        //     $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        // });
        // ... and so on for all relevant foreign keys.
    }

    public function down(): void
    {
        // Drop tables in reverse order of creation to avoid foreign key constraint issues
        Schema::dropIfExists('settings');
        Schema::dropIfExists('check_exercises');
        Schema::dropIfExists('teacher_salaries');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('bill_histories');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('test_results');
        Schema::dropIfExists('entrance_exams');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('users');
    }
};