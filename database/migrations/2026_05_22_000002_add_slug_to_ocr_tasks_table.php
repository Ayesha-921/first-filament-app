<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ocr_tasks', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('title');
        });

        $usedSlugs = [];

        DB::table('ocr_tasks')
            ->select(['id', 'title'])
            ->orderBy('id')
            ->get()
            ->each(function (object $task) use (&$usedSlugs): void {
                $baseSlug = Str::slug($task->title) ?: 'ocr-task';
                $slug = $baseSlug;
                $suffix = 2;

                while (in_array($slug, $usedSlugs, true)) {
                    $slug = "{$baseSlug}-{$suffix}";
                    $suffix++;
                }

                $usedSlugs[] = $slug;

                DB::table('ocr_tasks')
                    ->where('id', $task->id)
                    ->update(['slug' => $slug]);
            });

        Schema::table('ocr_tasks', function (Blueprint $table): void {
            $table->unique('slug');
        });
    }

    public function down(): void
    {
        Schema::table('ocr_tasks', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
