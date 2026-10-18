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
        Schema::table('tb_produk', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_produk', 'file_buku')) {
                $table->string('file_buku')->nullable()->after('gambar');
            }
        });

        Schema::table('tb_penjualan', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_penjualan', 'status')) {
                $table->string('status', 50)->default('berhasil')->after('jumlah');
            }
            if (!Schema::hasColumn('tb_penjualan', 'metode_pembayaran')) {
                $table->string('metode_pembayaran', 50)->default('qris')->after('status');
            }
            if (!Schema::hasColumn('tb_penjualan', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_produk', function (Blueprint $table) {
            if (Schema::hasColumn('tb_produk', 'file_buku')) {
                $table->dropColumn('file_buku');
            }
        });

        Schema::table('tb_penjualan', function (Blueprint $table) {
            $table->dropColumn(['status', 'metode_pembayaran', 'bukti_pembayaran']);
        });
    }
};
