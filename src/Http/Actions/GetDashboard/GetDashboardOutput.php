<?php
namespace Http\Actions\GetDashboard;

use Illuminate\Support\Collection;

class GetDashboardOutput
{
    public $lastRegisteredUsers;
    public $lastPosts;
    public $lastPendingPosts;
    public $lastDraftPosts;
    public $lastComments;
    public $numberOfPostsToday;
    public $numberOfPostsYesterday;
    public $numberOfUsersToday;
    public $numberOfUsersYesterday;
    public $numberOfCommentsToday;
    public $numberOfCommentsYesterday;

    public function setLastRegisteredUsers(Collection $lastRegisteredUsers)
    {
        $this->lastRegisteredUsers = $lastRegisteredUsers;
    }

    public function setLastPosts(Collection $lastPosts)
    {
        $this->lastPosts = $lastPosts;
    }

    public function setLastPendingPosts(Collection $lastPendingPosts)
    {
        $this->lastPendingPosts = $lastPendingPosts;
    }

    public function setLastDraftPosts(Collection $lastDraftPosts)
    {
        $this->lastDraftPosts = $lastDraftPosts;
    }

    public function setLastComments(Collection $lastComments)
    {
        $this->lastComments = $lastComments;
    }

    public function setNumberOfPostsToday(int $numberOfPostsToday)
    {
        $this->numberOfPostsToday = $numberOfPostsToday;
    }

    public function setNumberOfPostsYesterday(int $numberOfPostsYesterday)
    {
        $this->numberOfPostsYesterday = $numberOfPostsYesterday;
    }

    public function setNumberOfUsersToday(int $numberOfUsersToday)
    {
        $this->numberOfUsersToday = $numberOfUsersToday;
    }

    public function setNumberOfUsersYesterday(int $numberOfUsersYesterday)
    {
        $this->numberOfUsersYesterday = $numberOfUsersYesterday;
    }

    public function setNumberOfCommentsToday(int $numberOfCommentsToday)
    {
        $this->numberOfCommentsToday = $numberOfCommentsToday;
    }

    public function setNumberOfCommentsYesterday(int $numberOfCommentsYesterday)
    {
        $this->numberOfCommentsYesterday = $numberOfCommentsYesterday;
    }
}
