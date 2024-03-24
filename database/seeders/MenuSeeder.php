<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
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
                'name' => 'Dashboard',
                'route_name' => '#',
                'icon' => 'fas fa-atom fs-3',
                'level' => '1',
                'sequence' => '000'
            ],
            [
                'name' => 'IT',
                'route_name' => 'dashboard.dashboard-it',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '001'
            ],
            [
                'name' => 'Master',
                'route_name' => '#',
                'icon' => 'fas fa-atom fs-3',
                'level' => '1',
                'sequence' => '100'
            ],
            [
                'name' => 'IT',
                'route_name' => '#',
                'icon' => 'bi bi-archive fs-3',
                'level' => '3',
                'sequence' => '110'
            ],
            [
                'name' => 'Tipe Perangkat',
                'route_name' => 'master.tipe-pc.index',
                'icon' => 'bi bi-columns-gap fs-3',
                'level' => '4',
                'sequence' => '111'
            ],
            [
                'name' => 'Item Perangkat',
                'route_name' => 'master.item-pc.index',
                'icon' => 'bi bi-microsoft fs-3',
                'level' => '4',
                'sequence' => '112'
            ],
            [
                'name' => 'Merk',
                'route_name' => 'master.merk.it.index',
                'icon' => 'bi bi-badge-tm-fill fs-3',
                'level' => '4',
                'sequence' => '113'
            ],
            [
                'name' => 'Form Perawatan IT',
                'route_name' => 'form-perawatan-it.index',
                'icon' => 'bi bi-pc-display fs-3',
                'level' => '4',
                'sequence' => '114'
            ],
            [
                'name' => 'Software',
                'route_name' => 'master.it-software.index',
                'icon' => 'bi bi-pc-display fs-3',
                'level' => '4',
                'sequence' => '115'
            ],
            [
                'name' => 'Kantor',
                'route_name' => '#',
                'icon' => 'bi bi-archive fs-3',
                'level' => '3',
                'sequence' => '120'
            ],
            [
                'name' => 'Ruangan',
                'route_name' => 'master.ruangan.index',
                'icon' => 'bi bi-building fs-3',
                'level' => '4',
                'sequence' => '121'
            ],
            [
                'name' => 'Jenis Barang',
                'route_name' => 'master.jenis.index',
                'icon' => 'bi bi-boxes fs-3',
                'level' => '4',
                'sequence' => '122'
            ],
            [
                'name' => 'Merk',
                'route_name' => 'master.merk.kantor.index',
                'icon' => 'bi bi-badge-tm-fill fs-3',
                'level' => '4',
                'sequence' => '123'
            ],
            [
                'name' => 'Nama Inventaris',
                'route_name' => 'master.kantor.nama.inventory.index',
                'icon' => 'bi bi-badge-tm-fill fs-3',
                'level' => '4',
                'sequence' => '124'
            ],
            [
                'name' => 'Inventaris IT',
                'route_name' => '#',
                'icon' => 'fas fa-atom fs-3',
                'level' => '1',
                'sequence' => '200'
            ],
            [
                'name' => 'Data',
                'route_name' => 'inventaris-it.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '210'
            ],
            [
                'name' => 'Maintenance',
                'route_name' => 'maintenance-it.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '220'
            ],
            [
                'name' => 'Print QR Code',
                'route_name' => 'inventaris-it.qrcode',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '230'
            ],
            [
                'name' => 'Assign Perawatan',
                'route_name' => 'perawatan-assign.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '240'
            ],
            [
                'name' => 'Perawatan',
                'route_name' => 'perawatan.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '250'
            ],
            [
                'name' => 'Report',
                'route_name' => 'report.inventaris-it',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '260'
            ],
            [
                'name' => 'Report Maintenance IT',
                'route_name' => 'report.maintenance-it',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '270'
            ],
            [
                'name' => 'Inventaris Kantor',
                'route_name' => '#',
                'icon' => 'fas fa-atom fs-3',
                'level' => '1',
                'sequence' => '300'
            ],
            [
                'name' => 'Data',
                'route_name' => 'inventaris-kantor.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '310'
            ],
            [
                'name' => 'Print QR Code',
                'route_name' => 'inventaris-kantor.qrcode',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '320'
            ],
            [
                'name' => 'Report',
                'route_name' => 'report.inventaris-kantor',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '330'
            ],
            [
                'name' => 'Setting',
                'route_name' => '#',
                'icon' => 'fas fa-atom fs-3',
                'level' => '1',
                'sequence' => '400'
            ],
            [
                'name' => 'Akses Menu',
                'route_name' => 'setting.akses.menu.index',
                'icon' => 'bi bi-card-list fs-3',
                'level' => '2',
                'sequence' => '410'
            ]
        ];

        $parent0 = null;
        $parent1 = null;
        $parent2 = null;
        foreach ($menus as $item) {
            $menu = Menu::firstOrNew([
                'seq' => $item['sequence']
            ]);
            $menu->name       = $item['name'];
            $menu->route_name = $item['route_name'];
            $menu->icon       = $item['icon'];
            $menu->level      = $item['level'];

            $menu->seq        = $item['sequence'];
            if(in_array($item['level'], [2, 3])){
                $menu->parent_id = $parent1;
            }
            if($item['level'] == 4){
                $menu->parent_id = $parent2;
            }
            $menu->save();

            if($menu->level == 1){
                $parent1 = $menu->id;
            }
            if($menu->level == 3){
                $parent2 = $menu->id;
            }
            $menu->save();
        }
    }
}
