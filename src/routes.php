<?php
use Http\Actions\GetDashboard\GetDashboardAction as GetDashboard;
use Http\Actions\GetPosts\GetPostsAction as GetPosts;
use Http\Actions\GetLogin\GetLoginAction as GetLogin;
use Http\Actions\GetComments\GetCommentsAction as GetComments;
use Http\Actions\GetUsers\GetUsersAction as GetUsers;
use Http\Actions\PostLogin\PostLoginAction as PostLogin;

use Infrastructure\Middleware\AuthMiddleware;
use Infrastructure\Middleware\GuestMiddleware;
use Infrastructure\Middleware\BanMiddleware;

global $app;

$container = $app->getContainer();

$app->group('', function () use ($app) {
    $app->get('/login', GetLogin::class)->setName('login');
    $app->post('/login', PostLogin::class);
})->add(new GuestMiddleware($container));

$app->group('', function () use ($app) {
    $app->get('/', GetDashboard::class)->setName('dashboard');
    $app->get('/posts', GetPosts::class)->setName('posts');
    $app->get('/posts/{id}', '')->setName('post');
    $app->get('/comments', GetComments::class)->setName('comments');
    $app->get('/comments/{id}', null)->setName('comment');
    $app->get('/users', GetUsers::class)->setName('users');
    $app->get('/users/{id}', null)->setName('user');
})
    ->add(new BanMiddleware($container))
    ->add(new AuthMiddleware($container));

$request = $container->get('request');

\Illuminate\Pagination\Paginator::currentPageResolver(function () use ($request) {
    return $request->getParam('page');
});

// $app->get('/posts', \Http\Actions\GetPosts\GetPostsAction::class);
// $app->get('/posts/{id}', \Http\Actions\GetPostById\GetPostByIdAction::class);
// $app->get('/posts/{id}/comments', \Http\Actions\GetCommentsFromPost\GetCommentsFromPostAction::class);
// $app->get('/users', \Http\Actions\GetUsers\GetUsersAction::class);
// $app->get('/users/{id}', \Http\Actions\GetUserById\GetUserByIdAction::class);
// $app->get('/users/{id}/logs', \Http\Actions\GetLogsFromUser\GetLogsFromUserAction::class);
// $app->get('/tags', \Http\Actions\GetTags\GetTagsAction::class);
// $app->get('/categories', \Http\Actions\GetCategories\GetCategoriesAction::class);
