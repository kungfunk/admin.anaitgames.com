<?php
namespace Http\Actions\PostLogin;

use Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\PostLogin\PostLoginInput as Input;
use Infrastructure\Exceptions\UserLogonException;

class PostLoginAction extends Action
{
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $input = new Input($data);

        try {
            $input->validate();
            $user = $this->usersRepository->getUserByUsername($input->username);
            if (!$user) {
                throw new UserLogonException(UserLogonException::USER_NOT_FOUND);
            }
            if (!password_verify($input->password, $user->password)) {
                throw new UserLogonException(UserLogonException::INCORRECT_PASSWORD);
            }
            if ($user->isBanned()) {
                throw new UserLogonException(UserLogonException::USER_IS_BANNED);
            }
        } catch (\Exception $exception) {
            $this->logger->notice($exception->getMessage());
            $this->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $this->session->set('user_id', $user->id);
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
