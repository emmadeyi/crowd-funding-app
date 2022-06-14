<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class UsersList extends Component
{
    use WithPagination;

    public $updateUserStatusModal = false;
    public $user = null;
    public $user_name = null;
    public $user_id = null;
    public $roles = [];
    public $permissions = [];
    public $selected_roles = [];
    public $selected_permissions = [];
    public $SelectAllRoles = false;
    public $SelectAllRolesName = 'Select All Role';
    public $SelectAllPermissions = false;
    public $SelectAllPermissionsName = 'Select All Permissions';

    public function mount(){
        $this->getAllPermissions();
        $this->getAllRoles();
    }

    public function render()
    {
        return view('livewire.account.users-list',[
            'users' => User::orderBy('id', 'DESC')->paginate(10),
            'usersCount' => User::count(),
        ]);
    }

    private function getAllPermissions(){
        $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
        foreach ($permissions as $key => $value) {
           $this->permissions[$key] = $value;
        }
    }

    private function getAllRoles(){
        $roles = Role::orderBy('id', 'ASC')->pluck('name', 'id');
        foreach ($roles as $key => $value) {
           $this->roles[$key] = $value;
        }
    }

    public function updatedSelectAllRoles($value){
        if($value){
            try {
                if($roles = Role::pluck('id')){
                    foreach ($roles as $key => $value) {
                       $this->selected_roles[$value] = strval($value);
                    }
                    $this->SelectAllRolesName = 'Deselect All Roles';
                    return;
                }
                $this->selected_roles = [];
                $this->SelectAllRolesName = 'Select All Roles';
                return;
            } catch (Exception $e) {
                $this->selected_roles = [];
                $this->SelectAllRolesName = 'Select All Roles';
                return [];
            } 
        }        
        $this->selected_roles = [];
        $this->SelectAllRolesName = 'Select All Roles';
        return [];
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

    public function updateUserAclForm(User $user){
        $this->user = $user;
        $this->user_name = $user->name;
        $this->user_id = $user->id;
        $this->selected_roles = $this->setUserRoles($this->user);
        $this->selected_permissions = $this->setUserPermissions($this->user);
    }

    
    private function revokeUserPermissions($user){
        $user_permissions = $this->setUserPermissions($user);
        foreach ($user_permissions as $permission) {
            # code...
            $user->revokePermissionTo($permission);
        }
        return;
    }

    public function updateUserAcl(){   
        if($this->user){
            $user = User::find($this->user->id);
            // update user roles
            $user->syncRoles($this->selected_roles);
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'User Roles Updated.']);
            // update user permissions
            $user->syncPermissions($this->selected_permissions);
            $this->emit('alert', ['type' => 'success', 'title' => 'Saved', 'message' => 'User Permissions Updated.']);  
                  
        }else{
            $this->emit('alert', ['type' => 'error', 'title' => 'Saved', 'message' => 'Error occured.']);        
        }
        $this->resetState(); 
    }

    public function setUserRoles($user){
        try {
            $selected_roles = array();
            if($roles = $user->roles()->pluck('id')){
                foreach ($roles as $key => $value) {
                   $selected_roles[$value] = strval($value);
                }
            }
            return $selected_roles;
        } catch (Exception $e) {
            return [];
        }        
    }

    public function setUserPermissions($user){
        try {
            $selected_permissions = array();
            if($permissions = $user->getAllPermissions()->pluck('id')){
                foreach ($permissions as $key => $value) {
                   $selected_permissions[$value] = strval($value);
                }
            }
            return $selected_permissions;
        } catch (Exception $e) {
            return [];
        } 
    }

    public function toggleStatusModal(User $user){
        $this->user = $user;
        $this->updateUserStatusModal = true;
    }

    public function toggleUserStatus(){
        switch ($this->user->status) {
            case '0':
                $this->user->status = '1';
                break;
            case '1':                
                $this->user->status = '2';
                break;
            case '2':
                $this->user->status = '1';
                break;
            
            default:                
                $this->user->status = '0';
                break;
        }
        if($this->user->update()){
            $this->emit('alert', ['type' => 'info', 'title' => 'Update', 'message' => 'User status updated']);
            $this->resetState();
            return;
        }
        $this->emit('alert', ['type' => 'danger', 'title' => 'Error', 'message' => 'Error occured updating user status']);
        $this->resetState();
        return;
    }

    public function resetState(){
        $this->user = null;
        $this->updateUserStatusModal = false;
        $this->user = null;
        $this->user_name = null;
        $this->user_id = null;
        $this->selected_permissions = [];
        $this->selected_roles = [];
        $this->SelectAllRoles = false;
        $this->SelectAllRolesName = 'Select All Role';
        $this->SelectAllPermissions = false;
        $this->SelectAllPermissionsName = 'Select All Permissions';
    }
}
