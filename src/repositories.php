<?php
use Domain\Post\PostsRepository;
use Domain\Post\CategoriesRepository;
use Domain\Post\TagsRepository;

use Domain\User\UsersRepository;
use Domain\User\LogsRepository;

use Domain\Comment\CommentsRepository;

global $app;

$container = $app->getContainer();

$container['postsRepository'] = function () {
    return new PostsRepository;
};

$container['categoriesRepository'] = function () {
    return new CategoriesRepository;
};

$container['tagsRepository'] = function () {
    return new TagsRepository;
};

$container['usersRepository'] = function () {
    return new UsersRepository;
};

$container['logsRepository'] = function () {
    return new LogsRepository;
};

$container['commentsRepository'] = function () {
    return new CommentsRepository;
};
