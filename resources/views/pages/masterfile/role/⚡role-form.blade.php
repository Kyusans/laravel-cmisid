<?php

use Livewire\Component;
use App\Models\Role;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $roleName = '';

    public function addRole()
    {
        // {"roleName":"Role 1"}
        $validated = $this->validate([
            "roleName" => "required|string|unique:tblroles,role_name",
        ]);
        try {
            Role::create([
                "role_name" => $validated["roleName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Role added successfully');
            // $this->dispatch('goBack');
            $this->reset(["roleName"]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateRole()
    {
        // {"roleId":1, "roleName":"Role 5"}
        $validated = $this->validate([
            "roleName" => "required|string|unique:tblroles,role_name,$this->selectedDataId,role_id",
        ]);
        try {
            Role::where("role_id", $this->selectedDataId)->update([
                "role_name" => $validated["roleName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Role updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = Role::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->role_id;
        $this->roleName = $data->role_name;
    }

    public function mount($isAddData = true, $selectedDataId = null)
    {
        $this->isAddData = $isAddData;
        if ($selectedDataId) {
            $this->loadData($selectedDataId);
        }
    }

    public function render()
    {
        return $this->view();
    }
};
?>

<div>
    <div>
        <div class="mb-4">
            @if ($isAddData)
                <h5 class="fw-semibold mb-1">Create Role</h5>
                <small class="text-muted">Fill in the details to add a new role</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Role</h5>
                <small class="text-muted">Provide the details to edit this role.</small>
            @endif
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form wire:submit="{{ $isAddData ? 'addRole' : 'updateRole' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Role Name *</label>
                <input wire:model="roleName" name="roleName" type="text" class="form-control">
                @error('roleName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addRole' : 'updateRole' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} role
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addRole' : 'updateRole' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>