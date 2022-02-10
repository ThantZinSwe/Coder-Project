<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Language;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();

        User::create( array(
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make( 'admin123' ),
            'image'    => 'admin.png',
            'role'     => 'admin',
        ) );

        User::create( array(
            'name'     => 'User One',
            'email'    => 'userone@gmail.com',
            'password' => Hash::make( 'userone123' ),
            'image'    => 'user.png',
            'role'     => 'user',
        ) );

        $category = array( 'Web Design', 'Web Development', 'UI/UX', 'Android' );

        foreach ( $category as $c ) {
            Category::create( array(
                'slug' => Str::slug( $c ),
                'name' => $c,
            ) );
        }

        $language = array( 'Laravel', 'PHP', 'Nodejs', 'React', 'Vue' );

        foreach ( $language as $c ) {
            Language::create( array(
                'slug' => Str::slug( $c ),
                'name' => $c,
            ) );
        }

        Member::create( array(
            'slug'        => 'fifteen-day-plan',
            'title'       => '15 Days Plan',
            'learn_date'  => 15,
            'price'       => 8000,
            'description' => 'Regular Plan',
        ) );

        Member::create( array(
            'slug'        => 'one-month-plan',
            'title'       => '1 Month Plan',
            'learn_date'  => 30,
            'price'       => 15000,
            'description' => 'Regular Plan',
        ) );

    }

}
