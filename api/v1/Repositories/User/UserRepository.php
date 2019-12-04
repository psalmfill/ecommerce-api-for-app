<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\v1\Transformers\UserTransformer;
use Api\BaseRepository;
use App\User;

class UserRepository extends BaseRepository
{

    protected $user;
    protected $userTransformer;

    public function __construct(User $user, UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->user = $user;
    }

    public function getProfile($id)
    {
        $user = $this->user->find($id);

        return fractal($user, $this->userTransformer);
    }

    /**
     * function to update user profile
     *
     * @param string $id
     * @param object $data
     * @return response
     */
    public function updateProfile($data)
    {
        $user = $this->user->find(auth()->user()->id);
        if ($user->update($data))
            return fractal($user, $this->userTransformer);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed updating profile'
        ], 200);
    }

    public function changePassword($data)
    {
        $user = $this->user->find(auth()->user()->id);
        $user->password = bcrypt($data['password']);
        if ($user->save())
            return response()->json([
                'status' => 'success',
                'message' => 'Password updated'
            ], 200);
        return response()->json([
            'status' => 'error',
            'message' => 'Password changed failed'
        ], 200);
    }

    public function updateImage($data)
    {
        //TODO LOGIC TO UPLOAD IMAGES
        
    }

    public function suspendAccount($id)
    {
        //TODO user can suspend account
    }
}
