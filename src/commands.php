<?php
use Domain\User\Commands\CheckUsernameAndPassword;
use Domain\User\Commands\CountUsersByDate;
use Domain\User\Commands\GetLastRegisteredUsers;
use Domain\User\Commands\GetUsersByRole;

use Domain\Comment\Commands\CountCommentsByDate;
use Domain\Comment\Commands\GetLastComments;

use Domain\Post\Commands\CountPostsByCategoryId;
use Domain\Post\Commands\CountPostsByDate;
use Domain\Post\Commands\CountPostsByStatus;
use Domain\Post\Commands\CountPostsFiltered;
use Domain\Post\Commands\GetCategoriesWithPostCount;
use Domain\Post\Commands\GetLastDraftPosts;
use Domain\Post\Commands\GetLastPendingPosts;
use Domain\Post\Commands\GetLastPosts;
use Domain\Post\Commands\GetPostsFilteredPaginated;

global $app;

$container = $app->getContainer();

$container['checkUsernameAndPassword'] = function () {
    return new CheckUsernameAndPassword;
};

$container['countUsersByDate'] = function () {
    return new CountUsersByDate;
};

$container['getLastRegisteredUsers'] = function () {
    return new GetLastRegisteredUsers;
};

$container['getUsersByRole'] = function () {
    return new GetUsersByRole;
};

$container['getLastComments'] = function () {
    return new GetLastComments;
};

$container['countCommentsByDate'] = function () {
    return new CountCommentsByDate;
};

$container['countPostsByCategoryId'] = function () {
    return new CountPostsByCategoryId;
};

$container['countPostsByDate'] = function () {
    return new CountPostsByDate;
};

$container['countPostsByStatus'] = function () {
    return new CountPostsByStatus;
};

$container['countPostsFiltered'] = function () {
    return new CountPostsFiltered;
};

$container['getCategoriesWithPostCount'] = function () {
    return new GetCategoriesWithPostCount;
};

$container['getLastDraftPosts'] = function () {
    return new GetLastDraftPosts;
};

$container['getLastPendingPosts'] = function () {
    return new GetLastPendingPosts;
};

$container['getLastPosts'] = function () {
    return new GetLastPosts;
};

$container['getPostsFilteredPaginated'] = function () {
    return new GetPostsFilteredPaginated;
};
