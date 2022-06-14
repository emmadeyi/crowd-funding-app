<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;

    public $role;
    public $role_name;
    public $role_id = null;
    public $permissions = [];
    public $selected_permissions;
    public $roleFormModal = false;
    public $deleteRoleModal = false;
    public $SelectAllPermissions = false;
    public $SelectAllPermissionsName = 'Select All Permissions';

    public function mount(){
        $this->getAllPermissions();
    }

    public function render()
    {
        return view('livewire.account.roles', [
            'roles' => Role::orderBy('name', 'ASC')->paginate(5),
            'role_count' => Role::count(),
        ]);
    }

    public function showRoleFormModal(){
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->roleFormModal = true;
    }

    private function getAllPermissions(){
        try{
            $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
            foreach ($permissions as $key => $value) {
                $this->permissions[$key] = $value;
            }
            return;
        } catch (Exception $e) {
            return [];
        }      
        
    }

    public function updatedSelectAllPermissions($value){
        if($value){
            try {
                if($permissions = Permission::pluck('id')){
                    foreach ($permissions as $key => $value) {
                       $this->selected_permissions[$value] = strval($value);
                    }
                    $this->SelectAllPermissionsName = 'Deselect All Permissions';
                    return;
                }
                $this->selected_permissions = [];
                $this->SelectAllPermissionsName = 'Select All Permissions';
                return;
            } catch (Exception $e) {
                $this->selected_permissions = [];
                $this->SelectAllPermissionsName = 'Select All Permissions';
                return [];
            } 
        }        
        $this->selected_permissions = [];
        $this->SelectAllPermissionsName = 'Select All Permissions';
        return [];
    }

    private function setRolePermissions($role){  
        try {
            $selected_permissions = array();
            if($permissions = $role->permissions()->pluck('id')){
                foreach ($permissions as $key => $value) {
                   $selected_permissions[$value] = strval($value);
                }
            }
            return $selected_permissions;
        } catch (Exception $e) {
            return [];
        }        
    }
    
    public function showUpdateRoleFormModal(Role $role){        
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->roleFormModal = true;
        $this->role = $role;
        $this->role_id = $role->id;
        $this->role_name = $role->name; 
        $this->selected_permissions = null;   
        $this->selected_permissions = $this->setRolePermissions($role);
    }

    public function showDeleteRoleModal(Role $role){        
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $this->deleteRoleModal = true;
        $this->role = $role;
        $this->role_id = $role->id;
    }

    public function deleteRole(Role $role){          
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }    
        if($this->role->delete()){   
            // revoke role pemission
            $this->revokeRolePermissions($this->role);      
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Role Deleted.']);
        }else{            
            $this->emit('alert', ['type' => 'error', 'title' => 'Error', 'message' => 'Role not Deleted.']);
        }
        $this->resetState();
    }

    public function revokeRolePermissions($role){        
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $role_permissions = $this->setRolePermissions($role);
        foreach ($role_permissions as $permission) {
            # code...
            $this->role->revokePermissionTo($permission);
        }
        return;
    }

    public function updateRoles(){        
        // check role and permission
        if(!Auth::user()->hasAnyRole(['Developer'])) {
            $this->emit('alert', ['type' => 'Error', 'title' => 'Authorization Error', 'message' => 'Unauthorized Action!!!']);
            return;
        }
        $validatedData = $this->validate([
            'role_name' => 'required|string|unique:roles,name,'.$this->role_id,
        ]);
        
        if($this->role_id){
            // update
            $role = Role::find($this->role_id);
            $role->name = ucwords($validatedData['role_name']);            
        }else{
            // create
            $role = New Role();
            $role->name = ucwords($validatedData['role_name']);
        }
        if($role->save()){
            $role->syncPermissions($this->selected_permissions);
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'Role Saved.']);
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Saved', 'message' => 'Error occured.']);        
        }
        $this->resetState();        
    }

    public function resetState(){
        $this->roleFormModal = false;
        $this->deleteRoleModal = false;
        $this->role = null;
        $this->role_id = null;
        $this->role_name = null;
        $this->selected_permissions = [];
        $this->SelectAllPermissions = false;
        $this->SelectAllPermissionsName = 'Select All Permissions';
    }
}
