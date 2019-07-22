<?php

namespace Api\v1\Repositories\Admin;

use App\Role;
use App\Traits\GenarateSlug;
use Api\BaseRepository;

class RolesRepository extends BaseRepository
{

    use GenarateSlug;

    private $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * get all the 
     */
    public function getAll()
    {
        return $this->role->paginate(15);
    }

    

    public function find($id)
    {

        return $this->role->findOrFail($id);
    }

    public function create($data)
    {
        $data = (array) $data;
        $role = new $this->role($data);
        $role->slug = $this->createSlug($this->role, $data['name']);

        return $role->save() ? $role : false;
    }

    public function update($id,$data)
    {
        $role = $this->role->find($id);
    
        $role->slug = $this->createSlug($this->role,$data['name'],$id);
        if($role->update($data))
            return $role;

        return 'Fail updating role';
    }

    public function delete($id)
    {

        if ($this->role->destroy($id))
            return 'Delete Success';

        return  'Fail deleting';
    }
}
