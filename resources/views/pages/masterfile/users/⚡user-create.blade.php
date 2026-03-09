<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Office;

new class extends Component {
    public $roles = [];
    public $offices = [];

    public $userFirstName = '';
    public $userMiddleName = '';
    public $userLastName = '';
    public $userEmail = '';
    public $userPassword = '';
    public $userRoleId = '';
    public $userOfficeId = '';

    public function addUser()
    {
        // {"userFirstName":"Bea Ysabel", "userMiddleName":"Macalua", "userLastName":"Lachica", "userEmail":"bealachica@gmail.com", "userPassword":"beagwapa", "userOfficeId":"2", "userRoleId":"1"}
        $validated = $this->validate([
            'userFirstName' => 'required|string',
            'userMiddleName' => 'nullable|string',
            'userLastName' => 'required|string',
            'userEmail' => 'required|email|unique:tblusers,user_email',
            'userPassword' => 'required|string|min:8',
            'userOfficeId' => 'required|integer|exists:tbloffices,office_id',
            'userRoleId' => 'required|integer|exists:tblroles,role_id',
        ]);
        User::create([
            'user_firstName' => $validated['userFirstName'],
            'user_middleName' => $validated['userMiddleName'],
            'user_lastName' => $validated['userLastName'],
            'user_email' => $validated['userEmail'],
            'user_password' => $validated['userPassword'],
            'user_officeId' => $validated['userOfficeId'],
            'user_roleId' => $validated['userRoleId'],
        ]);
        session()->flash('success', 'User added successfully');
    }

    public function mount()
    {
        $this->roles = Role::all();
        $this->offices = Office::all();
    }

    public function updatedUserLastName($value)
    {
        $this->userPassword = !empty(trim($value)) ? strtoupper($value) . '123' : '';
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
            <h5 class="fw-semibold mb-1">Create User</h5>
            <small class="text-muted">Fill in the details to add a new user</small>
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
        <form wire:submit="addUser">
            @csrf

            <div class="mb-3">
                <label class="form-label">First Name *</label>
                <input wire:model="userFirstName" name="userFirstName" type="text" class="form-control">
                @error('userFirstName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input wire:model="userMiddleName" name="userMiddleName" type="text" class="form-control">
                @error('userMiddleName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name *</label>
                <input wire:model.live="userLastName" name="userLastName" type="text" class="form-control">
                @error('userLastName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input wire:model="userEmail" name="userEmail" type="email" class="form-control">
                @error('userEmail')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Password *
                    <small class="text-secondary">
                        (auto-generated from Last Name)
                    </small>
                </label>
                <input readonly wire:model="userPassword" name="userPassword" type="text" class="form-control">
                @error('userPassword')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="form-label">Role</label>
                    <select wire:model="userRoleId" name="userRoleId" class="form-select">
                        <option value="">Select role...</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    @error('userRoleId')
                        <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label class="form-label">Office</label>
                    <select wire:model="userOfficeId" name="userOfficeId" class="form-select">
                        <option value="">Select office...</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                    @error('userOfficeId')
                        <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-block" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="addUser">Create User</span>
                    <span wire:loading wire:target="addUser">
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
