<?php
namespace Http\Actions\PostLogin;

use Infrastructure\Exceptions\BadInputException;
use Respect\Validation\Validator;

class PostLoginInput
{
    public $username;
    public $password;

    public function __construct($data)
    {
        $this->username = $data['username'];
        $this->password = $data['password'];
    }

    public function validate()
    {
        if (!$this->validateUsername($this->username) || !$this->validatePassword($this->password)) {
            throw new BadInputException(BadInputException::BAD_QUERY_VALUE);
        }
    }

    public function validateUsername($username)
    {
        return Validator::alnum()->noWhitespace()->notEmpty()->validate($username);
    }

    public function validatePassword($password)
    {
        return Validator::notEmpty()->validate($password);
    }
}
