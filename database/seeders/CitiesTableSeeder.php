<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            'AC' => ['Rio Branco', 'Cruzeiro do Sul'],
            'AL' => ['Maceió', 'Arapiraca'],
            'AM' => ['Manaus', 'Parintins'],
            'AP' => ['Macapá', 'Santana'],
            'BA' => ['Salvador', 'Feira de Santana'],
            'CE' => ['Fortaleza', 'Caucaia'],
            'DF' => ['Brasília', 'Ceilândia'],
            'ES' => ['Vitória', 'Vila Velha'],
            'GO' => ['Goiânia', 'Anápolis'],
            'MA' => ['São Luís', 'Imperatriz'],
            'MG' => ['Belo Horizonte', 'Uberlândia'],
            'MS' => ['Campo Grande', 'Dourados'],
            'MT' => ['Cuiabá', 'Várzea Grande'],
            'PA' => ['Belém', 'Ananindeua'],
            'PB' => ['João Pessoa', 'Campina Grande'],
            'PE' => ['Recife', 'Olinda'],
            'PI' => ['Teresina', 'Picos'],
            'PR' => ['Curitiba', 'Londrina'],
            'RJ' => ['Rio de Janeiro', 'São Gonçalo'],
            'RN' => ['Natal', 'Mossoró'],
            'RO' => ['Porto Velho', 'Ji-Paraná'],
            'RR' => ['Boa Vista', 'Rorainópolis'],
            'RS' => ['Porto Alegre', 'Caxias do Sul'],
            'SC' => ['Florianópolis', 'Joinville'],
            'SE' => ['Aracaju', 'Nossa Senhora do Socorro'],
            'SP' => ['São Paulo', 'Guarulhos'],
            'TO' => ['Palmas', 'Araguaína'],
        ];

        foreach ($states as $state => $cities) {
            
            foreach ($cities as $city) {
                
                City::create([
                    'name' => $city,
                    'state' => $state,
                ]);
            }
        }
    }
}
