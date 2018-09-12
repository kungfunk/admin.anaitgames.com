<?php
use Http\Actions\Dashboard\DashboardAction as Dashboard;

$app->get('/', Dashboard::class);
// $app->get('/posts', \Http\Actions\GetPosts\GetPostsAction::class);
// $app->get('/posts/{id}', \Http\Actions\GetPostById\GetPostByIdAction::class);
// $app->get('/posts/{id}/comments', \Http\Actions\GetCommentsFromPost\GetCommentsFromPostAction::class);
// $app->get('/users', \Http\Actions\GetUsers\GetUsersAction::class);
// $app->get('/users/{id}', \Http\Actions\GetUserById\GetUserByIdAction::class);
// $app->get('/users/{id}/logs', \Http\Actions\GetLogsFromUser\GetLogsFromUserAction::class);
// $app->get('/tags', \Http\Actions\GetTags\GetTagsAction::class);
// $app->get('/categories', \Http\Actions\GetCategories\GetCategoriesAction::class);
