<?php

class PostsTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		$faker = Faker\Factory::create();

		foreach (range(5, 20) as $index) {

			$title = 'Test Post ' . $index;
			$desc = '<img src="http://i.imgur.com/YGmIx9q.jpg"><p>' . $faker->paragraph($nbSentences = 5) . '</p>';
			$desc_md = '![Imgur](http://i.imgur.com/YGmIx9q.jpg)' . $faker->paragraph($nbSentences = 5);

			Post::create([
				'title' 			=> $title,
				'slug'				=> Str::slug($title),
				'desc' 				=> $desc,
				'desc_md' 			=> $desc_md,
				'featured_image' 	=> 'http://i.imgur.com/YGmIx9q.jpg',
				'created_by'		=> 'admin'
			]);
		}
	}
}
