<?php

namespace Api\v1\Repositories\User;

use App\Product;
use App\Traits\GenarateSlug;
use Api\v1\Transformers\UserTransformer;
use Api\BaseRepository;
use App\Traits\FileUpload;
use App\User;
use Illuminate\Http\Response;

class UserRepository extends BaseRepository
{
    use FileUpload;

    protected $user;
    protected $userTransformer;

    public function __construct(User $user, UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->user = $user;
    }

    public function getProfile()
    {
        $user = auth()->user();

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
        $user = auth()->user();
        $oldPhoto = $user->photo;

        if ($user->update(['photo'=>$this->uploadSingleFile('avatars', $data['image'])])) {
            $this->removeFile($oldPhoto);
            return response()->json([
                'status' => 'success',
                'message' => 'Profile photo updated'
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'fail updating profile image'
        ], 200);
    }

    public function suspendAccount($id)
    {
        //TODO user can suspend account
    }
}
