<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Hot Drinks', 'description' => 'Warm and comforting beverages.'],
            ['name' => 'Iced Coffee', 'description' => 'Refreshing chilled coffee drinks.'],
            ['name' => 'Frappes', 'description' => 'Blended frozen treats.'],
            ['name' => 'Smoothies', 'description' => 'Fresh and creamy fruit shakes.'],
            ['name' => 'Cakes', 'description' => 'Delicious handcrafted cakes for all occasions.'],
            ['name' => 'Breads & Pastries', 'description' => 'Freshly baked breads and sweet pastries.'],
            ['name' => 'Sandwich & Savory', 'description' => 'Hearty sandwiches and savory delights.'],
        ];

        foreach ($categories as $cat) {
            $this->db->table('categories')->insert($cat);
            $categoryId = $this->db->insertID();

            $products = [];

            if ($cat['name'] === 'Hot Drinks') {
                $products = [
                    ['name' => 'Espresso – Single Shot', 'price' => 50, 'description' => 'Pure concentrated coffee.'],
                    ['name' => 'Espresso – Double Shot', 'price' => 75, 'description' => 'Two shots of pure espresso.'],
                    ['name' => 'Americano', 'price' => 85, 'description' => 'Espresso with hot water.'],
                    ['name' => 'Café Latte', 'price' => 95, 'description' => 'Espresso with steamed milk.'],
                    ['name' => 'Cappuccino', 'price' => 95, 'description' => 'Espresso with foamed milk.'],
                    ['name' => 'Matcha Latte', 'price' => 95, 'description' => 'Premium matcha with steamed milk.'],
                    ['name' => 'Flavored Cappuccino', 'price' => 105, 'description' => 'Cappuccino with your choice of syrup.'],
                    ['name' => 'Flavored Latte*', 'price' => 105, 'description' => 'Latte with your choice of syrup.'],
                    ['name' => 'Black Café Mocha', 'price' => 110, 'description' => 'Espresso with dark chocolate and milk.'],
                    ['name' => 'White Café Mocha', 'price' => 110, 'description' => 'Espresso with white chocolate and milk.'],
                    ['name' => 'Caramel Macchiato', 'price' => 115, 'description' => 'Vanilla latte with caramel drizzle.'],
                    ['name' => 'Tea', 'price' => 50, 'description' => 'Assorted premium tea blends.'],
                ];
            } elseif ($cat['name'] === 'Iced Coffee') {
                $products = [
                    ['name' => 'Iced Café Latte', 'price' => 95, 'description' => 'Chilled espresso with milk over ice.'],
                    ['name' => 'Iced Black Café', 'price' => 90, 'description' => 'Strong iced black coffee.'],
                    ['name' => 'Iced Café Mocha', 'price' => 110, 'description' => 'Chilled chocolate coffee blend.'],
                    ['name' => 'Iced White Mocha', 'price' => 110, 'description' => 'Chilled white chocolate coffee.'],
                    ['name' => 'Silky Vanilla', 'price' => 115, 'description' => 'Smooth vanilla iced coffee.'],
                    ['name' => 'Iced Caramel Macchiato', 'price' => 115, 'description' => 'Chilled caramel and vanilla coffee.'],
                ];
            } elseif ($cat['name'] === 'Frappes') {
                $products = [
                    ['name' => 'Vanilla Frappe (No Coffee)', 'price' => 130, 'description' => 'Blended creamy vanilla.'],
                    ['name' => 'Java Hazelnut', 'price' => 130, 'description' => 'Blended coffee with hazelnut.'],
                    ['name' => 'Oreo Frappe', 'price' => 140, 'description' => 'Blended cookies and cream.'],
                    ['name' => 'Black Forest', 'price' => 130, 'description' => 'Blended chocolate and cherry.'],
                    ['name' => 'Rocky Road', 'price' => 130, 'description' => 'Blended chocolate with nuts.'],
                    ['name' => 'Matcha Frappe', 'price' => 130, 'description' => 'Blended premium matcha.'],
                    ['name' => 'Caramel Frappe', 'price' => 130, 'description' => 'Blended sweet caramel.'],
                ];
            } elseif ($cat['name'] === 'Smoothies') {
                $products = [
                    ['name' => 'Mango Milk Shake', 'price' => 130, 'description' => 'Creamy fresh mango shake.'],
                ];
            } elseif ($cat['name'] === 'Cakes') {
                $products = [
                    ['name' => 'Brazo Cupcake', 'price' => 45, 'description' => 'Fluffy brazo de mercedes in a cup.'],
                    ['name' => 'Butter Cake', 'price' => 350, 'description' => 'Rich and buttery classic cake.'],
                    ['name' => 'Choco Moist Cake', 'price' => 450, 'description' => 'Irresistibly moist chocolate cake.'],
                    ['name' => 'Chocolate Cake', 'price' => 400, 'description' => 'Decadent chocolate layer cake.'],
                    ['name' => 'Chocolate Custard Cake', 'price' => 420, 'description' => 'Smooth custard on chocolate cake.'],
                    ['name' => 'Custard Cake', 'price' => 380, 'description' => 'Classic caramel custard cake.'],
                    ['name' => 'Marble Cake', 'price' => 350, 'description' => 'Beautiful swirls of vanilla and chocolate.'],
                    ['name' => 'Red Velvet', 'price' => 500, 'description' => 'Crimson-colored chocolate layer cake.'],
                    ['name' => 'Ube Cake', 'price' => 450, 'description' => 'Filipino purple yam flavored cake.'],
                    ['name' => 'Ube Custard', 'price' => 480, 'description' => 'Ube cake topped with creamy custard.'],
                ];
            } elseif ($cat['name'] === 'Breads & Pastries') {
                $products = [
                    ['name' => 'Ensaymada', 'price' => 35, 'description' => 'Sweet Filipino brioche with cheese.'],
                ];
            } elseif ($cat['name'] === 'Sandwich & Savory') {
                $products = [
                    ['name' => 'Egg Benedict', 'price' => 150, 'description' => 'Poached eggs with hollandaise sauce.'],
                    ['name' => 'Tuna Sandwich', 'price' => 85, 'description' => 'Fresh tuna salad on toasted bread.'],
                ];
            }

            foreach ($products as $p) {
                $p['category_id'] = $categoryId;
                $p['stock_quantity'] = 100; // Default stock
                $p['created_at'] = date('Y-m-d H:i:s');
                $p['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('products')->insert($p);
            }
        }
    }
}
