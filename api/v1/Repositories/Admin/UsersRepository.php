<?php

namespace Api\v1\Repositories\Admin;

use App\User;
use Api\BaseRepository;
use Api\v1\Transformers\OrderTransformer;
use Api\v1\Transformers\WishListTransformer;
use Api\v1\Transformers\CartTransformer;

class UsersRepository extends BaseRepository
{


    private $user;
    private $orderTransformer;
    private $wishListTransformer;
    private $cartTransformer;

    public function __construct(User $user,
     OrderTransformer $orderTransformer,
     WishListTransformer $wishListTransformer,
     CartTransformer $cartTransformer)
    {
        $this->user = $user;
        $this->orderTransformer = $orderTransformer;
        $this->wishListTransformer = $wishListTransformer;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        return $this->user->paginate(15);
    }

    

    public function find($id)
    {

        return $this->user->findOrFail($id);
    }

    public function create($data)
    {
        $data = (array) $data;
        $user = new $this->user($data);

        return $user->save() ?  response()->json([
            'status'=> 'success',
            'data' => $user
        ],200) : $this->response->error('Failed creating user',Response::HTTP_ACCEPTED);
    }

    public function update($id,$data)
    {
        $user = $this->user->find($id);
    
        return $user->update($data) ?  response()->json([
            'status'=> 'success',
            'data' => $user
        ],200) : $this->response->error('Failed updating user',Response::HTTP_ACCEPTED);
    }

    public function suspend($id)
    {
        $user = $this->user->find($id);
        $user->status = 'suspended';

        if($user->save)
            return $user;
        return 'Failed suspending user';
    }

    public function orders($id)
    {
        $orders = $this->user->findOrFail($id)->orders;
        return $this->response->item($orders, new $this->orderTransformer);
    }

    public function wishList($id)
    {
        $wishList = $this->user->find($id)->wishListItems;
        return $this->response->item($wishList, new $this->wishListTransformer);

    }

    public function cartItems($id)
    {
        
        $cartItems = $this->user->find($id)->cartItems;
        return $this->response->item($cartItems, new $this->cartTransformer);
  
    }
    
    /*public function delete($id)
    {

        if ($this->user->destroy($id))
            return 'Delete Success';

        return  'Fail deleting';
    }*/
}
