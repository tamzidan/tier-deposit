<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
                $electronicNames = [
            'Power Bank 20000mAh Fast Charging',
            'Earphone Bluetooth 5.0 TWS',
            'Speaker Portable Wireless',
            'Charger USB Type-C 65W',
            'Kabel Data Lightning MFi',
            'Mouse Wireless Gaming RGB',
            'Keyboard Mechanical Blue Switch',
            'Webcam HD 1080p Auto Focus',
            'Lampu LED Smart WiFi',
            'Adaptor Universal Multi Port',
        ];

        $electronicDescriptions = [
            'Teknologi terdepan dengan fitur canggih dan performa maksimal',
            'Garansi resmi 1 tahun dengan layanan purna jual terpercaya',
            'Kompatibel dengan berbagai perangkat dan mudah digunakan',
            'Desain ergonomis dan elegant cocok untuk profesional',
            'Sudah lulus uji kualitas internasional dan aman digunakan',
        ];

        return [
            'name' => $this->faker->randomElement($electronicNames),
            'description' => $this->faker->randomElement($electronicDescriptions),
            'price' => $this->faker->numberBetween(50000, 1500000),
            'image' => 'https://picsum.photos/640/480?random=' . $this->faker->numberBetween(3001, 4000),
            'stock' => $this->faker->numberBetween(1, 255)
        ];
    }
}