<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination;

    public $permission;
    public $permission_name;
    public $permission_id = null;
    public $selected_permissions;
    public $permissionFormModal = false;
    public $deletePermissionModal = false;

    public function render()
    {
        return view('livewire.account.permissions', [
            'permissions' => Permission::orderBy('name', 'ASC')->paginate(5),
            'permissions_count' => Permission::count(),
        ]);
    }

    public function showPermissionFormModal(){
        $this->permissionFormModal = true;
    }
    
    public function showUpdatePermissionFormModal(Permission $permission){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->permissionFormModal = true;
        $this->permission = $permission;
        $this->permission_id = $permission->id;
        $this->permission_name = $permission->name;
    }

    public function showDeletePermissionModal(Permission $permission){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->deletePermissionModal = true;
        $this->permission = $permission;
        $this->permission_id = $permission->id;
    }

    public function deletePermission(Permission $permission){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        if($this->permission->delete()){            
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Permission Deleted.']);
        }else{            
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Permission not Deleted.']);
        }
        $this->resetState();
    }

    public function updatePermissions(){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $validatedData = $this->validate([
            'permission_name' => 'required|string|unique:permissions,name',
        ]);
        
        if($this->permission_id){
            // update
            $permission = Permission::find($this->permission_id)->update(['name' => ucwords($validatedData['permission_name'])]);
        }else{
            // create
            $permission = Permission::create(['name' => ucwords($validatedData['permission_name'])]);
        }
        if($permission){
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Permission Saved.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Saved', 'message' => 'Error occured.']);        
        }
        $this->resetState();        
    }

    public function resetState(){
        $this->permissionFormModal = false;
        $this->deletePermissionModal = false;
        $this->permission = null;
        $this->permission_id = null;
        $this->permission_name = null;
    }
}
