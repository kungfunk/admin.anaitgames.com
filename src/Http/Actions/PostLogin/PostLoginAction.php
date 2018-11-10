<?php
namespace Http\Actions\PostLogin;

use Http\Actions\Action;
use Slim\Http\Request;
use Slim\Http\Response as Response;
use Http\Actions\PostLogin\PostLoginInput as Input;
use Infrastructure\Exceptions\AuthenticationException;
use Infrastructure\Authentication\Auth;

use Models\User;
use Models\Log;

class PostLoginAction extends Action
{
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $input = new Input($data);
        $auth = new Auth;

        try {
            $input->validate();
            $user = User::whereUsername($input->username)->first();
            if (!$user) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            if (!$auth->passwordVerify($input->password, $user->password)) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            if ($auth->isRehashNeeded()) {
                $user->password = $auth->passwordHash($input->password);
                $user->save();
            }
            if ($user->isBanned()) {
                throw new AuthenticationException(AuthenticationException::USER_IS_BANNED);
            }
        } catch (\Exception $exception) {
            if (isset($user) && $user) {
                $this->appLogger->warning(
                    $exception->getMessage(),
                    array_merge($input->data, ['user_id' => $user->id])
                );
            }
            $this->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $user->remember_token = $auth->generateRememberToken(60);
        $user->save();

        $this->session->id(true);
        $this->session->set('user_id', $user->id);
        $this->session->set('token', $user->remember_token);

        $this->appLogger->notice(Log::MSG_USER_LOGGED_IN_ADMIN);
        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
