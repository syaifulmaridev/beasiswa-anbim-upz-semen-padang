<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;

use App\Models\User;
use App\Models\SetoranHafalan;
use App\Models\LogNotifikasi;
use App\Models\Setting;

/*
|--------------------------------------------------------------------------
| Default Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
});


/*
|--------------------------------------------------------------------------
| Command Reminder Setoran Hafalan
|--------------------------------------------------------------------------
*/

Artisan::command('setoran:reminder', function () {

    $hari = now()->day;

    // Ambil pengaturan dari database
    $setting = Setting::first();

    if (!$setting) {
        $this->info('Pengaturan belum dibuat.');
        return;
    }

    $mulai   = $setting->setoran_mulai;
    $selesai = $setting->setoran_selesai;

    // Cek apakah hari ini dalam periode
    if ($hari < $mulai || $hari > $selesai) {
        $this->info('Di luar periode setoran.');
        return;
    }

    $users = User::where('role','user')
                ->where('status','approved')
                ->get();

    foreach ($users as $user) {

        // Cek apakah sudah setor bulan ini
        $sudahSetor = SetoranHafalan::where('user_id',$user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->exists();

        if (!$sudahSetor) {

            // Cek apakah sudah dikirim hari ini
            $sudahDikirim = LogNotifikasi::where('user_id',$user->id)
                ->where('tipe','setoran_reminder')
                ->whereDate('tanggal_kirim', now())
                ->exists();

            if (!$sudahDikirim) {

                $nohp = preg_replace('/^0/', '62', $user->no_hp);

                try {

                    Http::post('https://URL-WEBHOOK-N8N', [
                        'nama' => $user->name,
                        'no_hp' => $nohp
                    ]);

                    LogNotifikasi::create([
                        'user_id' => $user->id,
                        'tipe' => 'setoran_reminder',
                        'tanggal_kirim' => now()
                    ]);

                } catch (\Exception $e) {
                    $this->error('Gagal kirim ke user ID: ' . $user->id);
                }
            }
        }
    }

    $this->info('Reminder selesai diproses.');

})->purpose('Kirim reminder setoran hafalan');


/*
|--------------------------------------------------------------------------
| Scheduler
|--------------------------------------------------------------------------
*/

app(Schedule::class)
    ->command('setoran:reminder')
    ->daily();