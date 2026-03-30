<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImageUpdateSeeder extends Seeder
{
    public function run()
    {
        $updates = [
            // Hot Drinks
            'Espresso – Single Shot' => 'assets/images/hot_drinks/espresso_single_shot.jpg',
            'Espresso – Double Shot' => 'assets/images/hot_drinks/espresso_double_shot.webp',
            'Americano'              => 'assets/images/hot_drinks/americano.jpg',
            'Café Latte'             => 'assets/images/hot_drinks/cafe_latte.jpg',
            'Cappuccino'             => 'assets/images/hot_drinks/cappuccino.jpg',
            'Matcha Latte'           => 'assets/images/hot_drinks/matcha_latte.jpg',
            'Flavored Cappuccino'    => 'assets/images/hot_drinks/flavored_cappuccino.jpg',
            'Flavored Latte*'        => 'assets/images/hot_drinks/flavored_latte.jpg',
            'Black Café Mocha'       => 'assets/images/hot_drinks/black_coffee_mocha.avif',
            'White Café Mocha'       => 'assets/images/hot_drinks/white_cafe_mocha.webp',
            'Caramel Macchiato'      => 'assets/images/hot_drinks/caramel_macchiato.jpg',
            'Tea'                    => 'assets/images/hot_drinks/tea.jpg',

            // Iced Coffee
            'Iced Café Latte'        => 'assets/images/ice_coffee/iced_cafe_latte.jpg',
            'Iced Black Café'        => 'assets/images/ice_coffee/iced_black_cafe.jpg',
            'Iced Café Mocha'        => 'assets/images/ice_coffee/iced_cafe_mocha.jpg',
            'Iced White Mocha'       => 'assets/images/ice_coffee/iced_white_mocha.jpg',
            'Silky Vanilla'          => 'assets/images/ice_coffee/iced_vanilla_coffee.jpg',
            'Iced Caramel Macchiato' => 'assets/images/ice_coffee/iced_caramel_machiato.jpg',

            // Frappes
            'Vanilla Frappe (No Coffee)' => 'assets/images/frappe/vanilla_frappe.webp',
            'Java Hazelnut'              => 'assets/images/frappe/java_hazelnut.webp',
            'Oreo Frappe'                => 'assets/images/frappe/oreo_frappe.jpg',
            'Black Forest'               => 'assets/images/frappe/black_forest_frappe.webp',
            'Rocky Road'                 => 'assets/images/frappe/rocky_road_frappe.jpg',
            'Matcha Frappe'              => 'assets/images/frappe/matcha_frappe.jpg',
            'Caramel Frappe'             => 'assets/images/frappe/caramel_frappe.webp',

            // Smoothies
            'Mango Milk Shake'           => 'assets/images/smoothies/mango_milk_shake.jpg',

            // Cakes
            'Brazo Cupcake'              => 'assets/images/cakes/brazo_cupcake.jpg',
            'Butter Cake'                => 'assets/images/cakes/butter_cake.jpg',
            'Choco Moist Cake'           => 'assets/images/cakes/choco_moist_cake.jpg',
            'Chocolate Cake'             => 'assets/images/cakes/chocolate_cake.jpg',
            'Chocolate Custard Cake'     => 'assets/images/cakes/chocolate_custard_cake.jpg',
            'Custard Cake'               => 'assets/images/cakes/custard_cake.jpg',
            'Marble Cake'                => 'assets/images/cakes/marble_cake.jpg',
            'Red Velvet'                 => 'assets/images/cakes/red_velvet.jpg',
            'Ube Cake'                   => 'assets/images/cakes/ube_cake.jpg',
            'Ube Custard'                => 'assets/images/cakes/ube_custard.png',

            // Breads & Pastries
            'Ensaymada'                  => 'assets/images/breads_and_pastries/ensaymada.jpg',

            // Sandwich & Savory
            'Egg Benedict'               => 'assets/images/sandwich_and_savory/egg_benedict.jpg',
            'Tuna Sandwich'              => 'assets/images/sandwich_and_savory/tuna_sandwich.jpg',
        ];

        foreach ($updates as $name => $path) {
            $this->db->table('products')->where('name', $name)->update(['image_url' => $path]);
        }
    }
}
