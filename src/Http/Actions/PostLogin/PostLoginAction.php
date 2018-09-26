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
            if (!$this->checkUsernameAndPasswordCommand->setup($input->username, $input->password)->run()) {
                throw new UserLogonException(UserLogonException::INCORRECT_PASSWORD);
            }
        } catch (\Exception $exception) {
            $this->logger->notice($exception->getMessage());
            $this->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->router->pathFor('login'));
        }

        return $response->withRedirect($this->router->pathFor('dashboard'));
    }
}
