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
            "full_name" => $user->full_name,
            'first_name' => $user->first_name,
            'last_name'=> $user->last_name,
            'middle_name' => $user->middle_name,
            'avatar' => $user->avatar,
            'phone_number' => $user->phone_number,
            'gender' => $user->gender,
            "email" => $user->email,
            "address" => $user->address,
            "country" => $user->country,
            "state" => $user->state,
            "city" => $user->city,
            "created" => ($user->created_at)
        ];
    }
}
