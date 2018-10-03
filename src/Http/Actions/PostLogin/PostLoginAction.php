<?php
namespace Http\Actions\PostLogin;

use Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\PostLogin\PostLoginInput as Input;
use Infrastructure\Exceptions\UserNotFoundException;
use Infrastructure\Exceptions\BannedUserException;
use Infrastructure\Exceptions\InvalidCredentialException;
use Infrastructure\Exceptions\NotEnoughPermissionsException;

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
                throw new UserNotFoundException(UserNotFoundException::USER_NOT_FOUND);
            }
            if (!password_verify($input->password, $user->password)) {
                throw new InvalidCredentialException(InvalidCredentialException::INCORRECT_PASSWORD);
            }
            if ($user->isBanned()) {
                throw new BannedUserException(BannedUserException::USER_IS_BANNED);
            }
            if (!$user->isAdmin()) {
                throw new NotEnoughPermissionsException(NotEnoughPermissionsException::NOT_ENOUGH_PERMISSIONS);
            }
        } catch (\Exception $exception) {
            if ($exception instanceof InvalidCredentialException ||
                $exception instanceof BannedUserException ||
                $exception instanceof NotEnoughPermissionsException
            ) {
                $this->appLogger->notice($exception->getMessage(), array_merge($input->data, ['user_id' => $user->id]));
            }
            $this->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $this->session->set('user_id', $user->id);
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
