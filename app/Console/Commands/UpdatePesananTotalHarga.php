<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;

class UpdatePesananTotalHarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pesanan:update-total-harga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update total harga pesanan yang sudah ada dengan kalkulasi yang benar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai update total harga pesanan...');
        
        $pesananList = Pesanan::with('layanan.hargaUkuran')->get();
        $updated = 0;
        
        foreach ($pesananList as $pesanan) {
            $oldTotal = $pesanan->total_harga;
            $newTotal = $pesanan->calculateTotalPrice();
            
            if ($oldTotal != $newTotal) {
                $pesanan->update(['total_harga' => $newTotal]);
                $updated++;
                
                $this->line("Pesanan ID {$pesanan->id}: {$oldTotal} -> {$newTotal}");
            }
        }
        
        $this->info("Selesai! {$updated} pesanan telah diupdate dari total {$pesananList->count()} pesanan.");
        
        return 0;
    }
}