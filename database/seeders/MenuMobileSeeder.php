<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuMobile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MenuMobileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $menus = [
            [
                'name' => 'Scan',
            ],
            [
                'name' => 'Daftar Perbaikan',
            ],
            [
                'name' => 'Approval Perbaikan (Operator)',
            ],
            [
                'name' => 'Approval Perbaikan (Manajer)',
            ],
            [
                'name' => 'Approval Perawatan (Operator)',
            ],
            [
                'name' => 'Approval Perawatan (Manajer)',
            ],
            [
                'name' => 'Permohonan Set Up',
            ],
            [
                'name' => 'Pemenuhan Set Up',
            ],
            [
                'name' => 'Approval Pemenuhan Set Up (QA)',
            ],
            [
                'name' => 'Approval Pemenuhan Set Up (Manajer)',
            ],
        ];

        foreach ($menus as $item) {
            $slug = Str::slug($item['name']);
            $menu = MenuMobile::firstOrNew([
                'code' => $slug
            ]);
            $menu->name       = $item['name'];
            $menu->save();
        }
    }
}
