<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEventSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for existing events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = \App\Models\Event::whereNull('slug')->get();
        
        if ($events->isEmpty()) {
            $this->info('All events already have slugs.');
            return;
        }
        
        $bar = $this->output->createProgressBar($events->count());
        $bar->start();
        
        foreach ($events as $event) {
            $event->slug = str()->slug($event->name);
            $event->save();
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info('Successfully generated slugs for ' . $events->count() . ' events.');
    }
}
