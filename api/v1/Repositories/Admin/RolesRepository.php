<?php

namespace Api\v1\Repositories\Admin;

use App\Role;
use App\Traits\GenarateSlug;
use Api\BaseRepository;
use Illuminate\Http\Response;

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
        $roles = $this->role->all();
        return response()->json([
            'status' => 'success',
            'data' => $roles
        ], 200);
    }



    public function find($id)
    {

        $role = $this->role->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $role
        ], 200);
    }

    public function create($data)
    {
        $data = (array) $data;
        $role = new $this->role($data);
        $role->slug = $this->createSlug($this->role, $data['name']);

        return $role->save() ?  response()->json([
            'status' => 'success',
            'data' => $role
        ], 200) : $this->response->error('Failed creating role', Response::HTTP_ACCEPTED);
    }

    public function update($id, $data)
    {
        $role = $this->role->findOrFail($id);

        $role->slug = $this->createSlug($this->role, $data['name'], $id);

        return $role->update($data) ?  response()->json([
            'status' => 'success',
            'data' => $role
        ], 200) : $this->response->error('Failed updating role', Response::HTTP_ACCEPTED);
    }

    public function delete($id)
    {

        return $this->role->destroy($id) ?  response()->json([
            'status' => 'success',
            'message' => 'Role deleted'
        ], 200) : $this->response->error('Failed creating role', Response::HTTP_ACCEPTED);
    }
}
