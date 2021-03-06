<?php
namespace Infrastructure\Authentication;

class Auth
{
    private $oldPasswordHelper;
    private $rehashNeeded;

    public function __construct()
    {
        $this->oldPasswordHelper = new OldPasswordHelper();
    }

    public function passwordVerify(string $password, string $hash): bool
    {
        if ($this->oldPasswordHelper->oldPasswordVerify($password, $hash)) {
            $this->rehashNeeded = true;
            return true;
        }

        if ($this->newPasswordVerify($password, $hash)) {
            $this->rehashNeeded = password_needs_rehash($hash, PASSWORD_DEFAULT);
            return true;
        }

        return false;
    }

    public function passwordHash($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function isRehashNeeded()
    {
        return $this->rehashNeeded;
    }

    private function newPasswordVerify($password, $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function generateRememberToken($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}
