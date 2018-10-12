<?php
namespace Http\Actions\PostLogin;

use Http\Actions\Action;
use Slim\Http\Request;
use Slim\Http\Response as Response;
use Http\Actions\PostLogin\PostLoginInput as Input;
use Infrastructure\Exceptions\AuthenticationException;

use Models\User;

class PostLoginAction extends Action
{
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $input = new Input($data);

        try {
            $input->validate();
            $user = User::whereUsername($input->username)->first();
            if (!$user) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            if (!$user->checkPassword($input->password)) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            if ($user->isBanned()) {
                throw new AuthenticationException(AuthenticationException::USER_IS_BANNED);
            }
        } catch (\Exception $exception) {
            if (isset($user) && $user) {
                $this->appLogger->notice($exception->getMessage(), array_merge($input->data, ['user_id' => $user->id]));
            }
            $this->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $this->session->set('user_id', $user->id);
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
