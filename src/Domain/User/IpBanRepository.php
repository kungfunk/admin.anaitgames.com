<?php
namespace Domain\User;

use Carbon\Carbon;

class IpBanRepository
{
    private $ipBanModel;

    public function __construct()
    {
        $this->ipBanModel = new IpBan;
    }

    public function getActiveByIp($ip)
    {
        return $this->ipBanModel->where('ip', $ip)->where('expires', '>', Carbon::now())->first();
    }
}
