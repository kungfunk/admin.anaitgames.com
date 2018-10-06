<?php
namespace Http\Actions\GetPosts;

use Http\Actions\Action;
use Http\Helpers\Pagination;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetPosts\GetPostsInput as Input;
use Http\Actions\GetPosts\GetPostsResponder as Responder;

use Domain\User\User;
use Domain\Post\Post;

class GetPostsAction extends Action
{
    public const POSTS_PER_PAGE = 20;

    private $responder;
    private $input;
    private $output = [];

    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getQueryParams();
        $this->input = new Input($data);

        $filterParams  = [
            $this->input->search,
            $this->input->category_id,
            $this->input->user_id,
            $this->input->status
        ];

        $orderAndPaginationParams = [
            $this->input->order_field,
            $this->input->order_direction,
            self::POSTS_PER_PAGE,
            $this->input->page
        ];

        $this->output['posts'] = $this->postsRepository
            ->setFilters(...$filterParams)
            ->setOrderAndPagination(...$orderAndPaginationParams)
            ->addRelationShips()
            ->get();

        $writerRoles = [User::ROLE_EDITOR, User::ROLE_ADMIN, User::ROLE_SUPERADMIN];

        $this->output['writers'] = $this->usersRepository->getUserByRoles($writerRoles);
        $this->output['categories'] = $this->categoriesRepository->addRelationShips()->get();
        $this->output['statusFilters'] = [
            [
                'name' => Post::STATUS_PUBLISHED_NAME,
                'slug' => Post::STATUS_PUBLISHED,
                'count' => $this->postsRepository->setStatus(Post::STATUS_PUBLISHED)->count()
            ],
            [
                'name' => Post::STATUS_DRAFT_NAME,
                'slug' => Post::STATUS_DRAFT,
                'count' => $this->postsRepository->setStatus(Post::STATUS_DRAFT)->count()
            ],
            [
                'name' => Post::STATUS_TRASH_NAME,
                'slug' => Post::STATUS_TRASH,
                'count' => $this->postsRepository->setStatus(Post::STATUS_TRASH)->count()
            ]
        ];

        $this->output['pagination'] = new Pagination(
            $this->postsRepository->setFilters(...$filterParams)->count(),
            self::POSTS_PER_PAGE,
            $this->input->page
        );

        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
