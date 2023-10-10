<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearCacheImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:clear-cache-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears local storage of cache images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk("public")->files("cache_images");
        foreach ($files as $file) {
            Storage::disk("public")->delete($file);
        }
    }
}
