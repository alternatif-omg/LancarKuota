<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Product;
use App\Models\Transaction;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalProduk = Product::count();
        $totalTransaksi = Transaction::count();
        $transaksiSukses = Transaction::where('status', 'success')->count();
        $transaksiGagal = $totalTransaksi - $transaksiSukses;

        // Hitung kategori produk
        $jumlahPulsa = Product::where('category', 'pulsa')->count();
        $jumlahData = Product::where('category', 'data')->count();
        $jumlahGame = Product::where('category', 'game')->count();

        // Hitung persentase
        $persenSukses = $totalTransaksi ? round(($transaksiSukses / $totalTransaksi) * 100, 2) : 0;
        $persenGagal = $totalTransaksi ? round(($transaksiGagal / $totalTransaksi) * 100, 2) : 0;

        return [
            Card::make('Total Produk', $totalProduk)
                ->description("Pulsa: $jumlahPulsa | Data: $jumlahData | Game: $jumlahGame")
                ->color('primary')
                ->icon('heroicon-o-shopping-cart'),

            Card::make('Total Transaksi', $totalTransaksi)
                ->description("Sukses: $transaksiSukses | Gagal: $transaksiGagal")
                ->color('secondary')
                ->icon('heroicon-o-currency-dollar'),

            Card::make('Transaksi Sukses', $transaksiSukses)
                ->description("$persenSukses% dari total")
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Card::make('Transaksi Gagal', $transaksiGagal)
                ->description("$persenGagal% dari total")
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}