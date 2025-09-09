<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Sucursal;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $user_id;
    public $name, $email, $password, $password_confirmation, $selected_role, $sucursal_id_user, $activo = true;

    public $isModalOpen = false;
    public $search = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'selected_role' => 'required|exists:roles,name',
            'sucursal_id_user' => 'required|exists:sucursales,id',
            'activo' => 'boolean',
        ];

        // Password es requerido solo al crear, opcional al editar
        if (!$this->user_id) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function render()
    {
        $users = User::with(['roles', 'sucursal'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.user-manager', [
            'users' => $users,
            'roles' => Role::all(),
            'sucursales' => Sucursal::where('activo', true)->get(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->selected_role = '';
        $this->sucursal_id_user = '';
        $this->activo = true;
    }

    public function store()
    {
        $this->validate();

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'sucursal_id' => $this->sucursal_id_user,
            'activo' => $this->activo,
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->user_id], $userData);

        $user->syncRoles($this->selected_role);

        session()->flash('message', $this->user_id ? 'Usuario actualizado con éxito.' : 'Usuario creado con éxito.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selected_role = $user->roles->first()->name ?? '';
        $this->sucursal_id_user = $user->sucursal_id;
        $this->activo = $user->activo;
        $this->password = '';
        $this->password_confirmation = '';

        $this->openModal();
    }
}
