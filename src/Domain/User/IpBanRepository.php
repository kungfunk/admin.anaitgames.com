<?php
namespace Domain\User;

use Carbon\Carbon;
use Domain\Repository;

class IpBanRepository extends Repository
{
    public function __construct()
    {
        $this->model = new IpBan;
        parent::__construct();
    }

    public function getActiveByIp($ip)
    {
        return $this->model->where('ip', $ip)->where('expires', '>', Carbon::now())->first();
    }
}
