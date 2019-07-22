<?php

namespace Api\v1\Repositories\Admin;

use App\User;

class UsersRepository
{


    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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

        return $user->save() ? $user : false;
    }

    public function update($id,$data)
    {
        $user = $this->user->find($id);
    
        if($user->update($data))
            return $user;

        return 'Fail updating user';
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
        $orders = $this->user->find($id)->orders;
        return $orders;
    }

    public function wishList($id)
    {
        $wishList = $this->user->find($id)->wishListItems;
        return $wishList;
    }

    public function cartItems($id)
    {
        return $id;
        $cartitems = $this->user->find($id)->cartItems;
        return $cartitems;
    }
    
    /*public function delete($id)
    {

        if ($this->user->destroy($id))
            return 'Delete Success';

        return  'Fail deleting';
    }*/
}
