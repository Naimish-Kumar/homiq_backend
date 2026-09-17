<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;

class ExpireUnconfirmedPropertiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:expire-unconfirmed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set unconfirmed properties past their 30-day window to temporarily unavailable';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Scanning properties for expired availability windows...');

        $expiredCount = Property::where('status', 'approved')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->update([
                'status' => 'temporarily_unavailable'
            ]);

        $this->info("Updated {$expiredCount} properties to 'temporarily_unavailable'.");

        return Command::SUCCESS;
    }
}

