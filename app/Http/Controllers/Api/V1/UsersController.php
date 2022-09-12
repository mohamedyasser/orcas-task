<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchUsersRequest;
use App\Jobs\FetchUsersJob;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(Request $request)
    {
//        dispatch(new FetchUsersJob($this->userRepository));
        return response()->json([
            'data' => $this->userRepository->list($request->get('page', 1)),
            'status' => 'success',
        ]);
    }

    public function search(SearchUsersRequest $request)
    {
        $response = $this->userRepository->search(
            $request->only(['first_name', 'last_name', 'email']),
            $request->get('page', 1)
        );

        return response()->json([
            'data' => $response,
            'status' => 'success',
        ]);
    }
}
