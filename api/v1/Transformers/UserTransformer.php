<?php
namespace Api\v1\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    
    public function transform(User $user)
    {
        return [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "created" => ($user->created_at)
        ];
    }
}
