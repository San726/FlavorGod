<?php

$factory->define(Flavorgod\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(FitlifeGroup\Models\Eloquent\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'titlename' => $faker->name,
        'slug' => str_random(8),
        'description' => $faker->sentence(4),
        'sku'	=> str_random(8),
        'enabled' => 1
    ];
});

<<<<<<< Updated upstream
=======
$factory->define(Flavorgod\Post::class, function ($faker) {
    return [
        'title' => $faker->sentence(mt_rand(3, 10)),
        'content' => join("\n\n", $faker->paragraphs(mt_rand(3, 6))),
        'published_at' => $faker->dateTimeBetween('-1 month', '+3 days'),
    ];
});

>>>>>>> Stashed changes

