<?php
use Dotenv\Dotenv as Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Domain\User\User;
use Domain\User\Ban;
use Domain\User\IpBan;
use Domain\Post\Post;
use Domain\Post\Tag;
use Domain\Comment\Comment;
use Domain\Comment\CommentReport;
use Domain\Comment\Mention;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$config = include  __DIR__ . '/../src/config.php';

$capsule = new Capsule;
$capsule->addConnection([
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'database' => getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => getenv('DB_CHARSET'),
    'collation' => getenv('DB_COLLATION')
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$faker = Faker\Factory::create();

$user_number = 100;
$post_number = 50;
$tag_number = 30;
$posts_tags_number = 100;
$comments_number = 300;
$comment_report_number = 100;
$mention_number = 100;
$ban_number = 30;
$ip_ban_number = 10;

for ($i = 1; $i <= $user_number; $i++) {
    User::create(array(
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => password_hash('1234', PASSWORD_DEFAULT),
        'username' => $faker->userName,
        'role' => $faker->randomElement(['user' ,'moderator', 'editor', 'admin', 'superadmin']),
        'patreon_level' => $faker->numberBetween(1, 3),
        'avatar' => $faker->imageUrl($width = 100, $height = 100),
        'rank' => $faker->sentence(3),
        'twitter' => '@' . $faker->userName
    ));
}

$user_ids = User::all()->pluck('id');

for ($i = 1; $i <= $post_number; $i++) {
    Post::create(array(
        'user_id' => $faker->randomElement($user_ids),
        'category_id' => $faker->numberBetween(1, 5),
        'status' => $faker->randomElement(['draft', 'published', 'trash']),
        'publish_date' => $faker
            ->dateTimeBetween($startDate = '-10 years', $endDate = '+1 year')
            ->format('Y-m-d H:i:s'),
        'title' => $faker->sentence(5),
        'subtitle' => $faker->sentence(8),
        'slug' => $faker->slug(5),
        'body' => $faker->text(500),
        'excerpt' => $faker->text(50),
        'original_author' => null,
        'score' => null,
        'num_views' => $faker->numberBetween(1, 1000),
        'metadata' => null
    ));
}

$post_ids = Post::all()->pluck('id');

for ($i = 1; $i <= $tag_number; $i++) {
    Tag::create(array(
        'name' => $faker->sentence(3),
        'slug' => $faker->slug(3)
    ));
}

$tag_ids = Tag::all()->pluck('id');

for ($i = 1; $i <= $posts_tags_number; $i++) {
    Capsule::table('posts_tags')->insert([
        'post_id' => $faker->randomElement($post_ids),
        'tag_id' => $faker->randomElement($tag_ids)
    ]);
}

for ($i = 1; $i <= $comments_number; $i++) {
    Comment::create(array(
        'post_id' => $faker->randomElement($post_ids),
        'user_id' => $faker->randomElement($user_ids),
        'body' => $faker->text(500)
    ));
}

$comment_ids = Comment::all()->pluck('id');

for ($i = 1; $i <= $comment_report_number; $i++) {
    CommentReport::create(array(
        'comment_id' => $faker->randomElement($comment_ids),
        'user_id' => $faker->randomElement($user_ids),
        'body' => $faker->text(100),
        'checked' => $faker->numberBetween(0, 1)
    ));
}

for ($i = 1; $i <= $mention_number; $i++) {
    Mention::create(array(
        'user_from_id' => $faker->randomElement($user_ids),
        'user_to_id' => $faker->randomElement($user_ids),
        'comment_id' => $faker->randomElement($comment_ids),
        'checked' => $faker->numberBetween(0, 1)
    ));
}

for ($i = 1; $i <= $ban_number; $i++) {
    Ban::create(array(
        'user_id' => $faker->randomElement($user_ids),
        'banned_by_id' => $faker->randomElement($user_ids),
        'expires' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'reason' => $faker->sentence(20)
    ));
}

for ($i = 1; $i <= $ip_ban_number; $i++) {
    IpBan::create(array(
        'banned_by_id' => $faker->randomElement($user_ids),
        'expires' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'ip' => $faker->ipv4,
        'reason' => $faker->sentence(20)
    ));
}
