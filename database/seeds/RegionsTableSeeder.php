<?php

use Illuminate\Database\Seeder;
use App\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
       Region::create([
        'region_id' => '1',
        'region_nombre' => 'Arica y Parinacota',
        'region_ordinal' => 'XV']);

        Region::create([
          'region_id' => '2',
          'region_nombre' => 'Tarapacá',
          'region_ordinal' => 'I']);

        Region::create([
          'region_id' => '3',
          'region_nombre' => 'Antofagasta',
          'region_ordinal' => 'II']);

        Region::create([
          'region_id' => '4',
          'region_nombre' => 'Atacama',
          'region_ordinal' => 'III']);

        Region::create([
          'region_id' => '5',
          'region_nombre' => 'Coquimbo',
          'region_ordinal' => 'IV']);

        Region::create([
          'region_id' => '6',
          'region_nombre' => 'Valparaiso',
          'region_ordinal' => 'V']);

        Region::create([
          'region_id' => '7',
          'region_nombre' => 'Metropolitana de Santiago',
          'region_ordinal' => 'RM']);

        Region::create([
          'region_id' => '8',
          'region_nombre' => 'Libertador General Bernardo OHiggins',
          'region_ordinal' => 'VI']);

        Region::create([
          'region_id' => '9',
          'region_nombre' => 'Maule',
          'region_ordinal' => 'VII']);

        Region::create([
          'region_id' => '10',
          'region_nombre' => 'Biobío',
          'region_ordinal' => 'VIII']);

        Region::create([
          'region_id' => '11',
          'region_nombre' => 'La Araucanía',
          'region_ordinal' => 'IX']);

        Region::create([
          'region_id' => '12',
          'region_nombre' => 'Los Ríos',
          'region_ordinal' => 'XIV']);

        Region::create([
          'region_id' => '13',
          'region_nombre' => 'Los Lagos',
          'region_ordinal' => 'X']);

        Region::create([
          'region_id' => '14',
          'region_nombre' => 'Aisén del General Carlos Ibáñez del Campo',
          'region_ordinal' => 'XI']);

        Region::create([
          'region_id' => '15',
          'region_nombre' => 'Magallanes y de la Antártica Chilena',
          'region_ordinal' => 'XII']);
    }
}
