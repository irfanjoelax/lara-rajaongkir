<?php

use App\City;
use App\Province;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ambil data provinsi dari rajaongkir
        $daftarProvinsi = RajaOngkir::provinsi()->all();

        // perulangan
        foreach ($daftarProvinsi as $provinceRow) {
            // create ke dalam database
            Province::create([
                'province_id' => $provinceRow['province_id'],
                'title' => $provinceRow['province']
            ]);

            // ambil data kota sesuai provinsi
            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinceRow['province_id'])->get();

            // perulangan untuk create kedalam database
            foreach ($daftarKota as $cityRow) {
                City::create([
                    'province_id' => $provinceRow['province_id'],
                    'city_id' => $cityRow['city_id'],
                    'title' => $cityRow['city_name'],
                ]);
            }
        }
    }
}
