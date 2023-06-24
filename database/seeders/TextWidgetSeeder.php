<?php

namespace Database\Seeders;

use App\Models\TextWidget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextWidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TextWidget::create([
            'key' => 'header',
            'title' => 'Tulisan apa saja',
            'active' => 1
        ]);

        TextWidget::create([
            'key' => 'about-us-sidebar',
            'title' => 'About Us',
            'content' => "Saya seorang pengembang Laravel yang berpengalaman dan ahli dalam membangun aplikasi web yang cepat, aman, dan skalabel. Hubungi saya untuk bantuan pengembangan aplikasi web dengan Laravel. Terima kasih!",
            'active' => 1
        ]);

        TextWidget::create([
            'key' => 'about-us-page',
            'title' => 'About-Us',
            'content' => "Selamat datang di halaman 'About Us'! Kami adalah tim pengembang yang berdedikasi dalam dunia pengembangan web, dengan keahlian khusus dalam kerangka kerja Laravel.

            Kami adalah pengembang Laravel yang berpengalaman dan ahli dalam membangun aplikasi web yang cepat, aman, dan skalabel. Dengan pengetahuan mendalam tentang konsep-konsep pemrograman dan praktek terbaik, kami memastikan bahwa setiap proyek yang kami kerjakan dirancang dengan cermat dan dikembangkan dengan standar tinggi.
            
            Kami sangat antusias dalam menghadapi tantangan pengembangan perangkat lunak, dan Laravel telah menjadi fondasi utama bagi kami untuk memberikan solusi yang inovatif dan efisien kepada klien kami. Dalam setiap proyek, kami berusaha memahami kebutuhan unik Anda dan memberikan solusi yang sesuai untuk mencapai tujuan bisnis Anda.
            
            Kami bangga dengan kualitas kerja kami dan dedikasi kami untuk memberikan hasil yang memuaskan kepada klien. Kami selalu berupaya untuk meningkatkan diri dan tetap up-to-date dengan tren terbaru dalam industri ini, sehingga kami dapat terus memberikan solusi terbaik dan terdepan.
            
            Kami berharap dapat bekerja sama dengan Anda dalam proyek berikutnya. Jika Anda memerlukan bantuan dalam pengembangan aplikasi web dengan menggunakan Laravel, jangan ragu untuk menghubungi kami. Kami siap membantu mewujudkan visi Anda menjadi kenyataan.
            
            Terima kasih atas kunjungan Anda ke halaman 'Tentang Kami'. Kami berharap dapat berkolaborasi dengan Anda segera!",
            'active' => 1
        ]);
    }
}
