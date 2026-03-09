<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public $users = [];
    public $isAddUser = true;

    public function render()
    {
        // dd($this->users->toArray());
        return $this->view();
    }

    public function mount()
    {
        $this->users = User::with(['office', 'role'])->get();
    }
};
?>

<div class="container-fluid">

    @if (!$isAddUser)
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">Users</h2>
                <h6 class="text-muted">List of all users in the system</h6>
            </div>
            <div>
                <button wire:click="set('isAddUser', true)" class="btn btn-outline-success"><i class="bi bi-plus-lg"></i> Add
                    User</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Office</th>
                        <th scope="col">Role</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $user->user_lastName }}, {{ $user->user_firstName }}
                                {{ $user->user_middleName ?? '' }}
                            </td>
                            <td>{{ $user->office->office_name }}</td>
                            <td>{{ $user->role->role_name }}</td>
                            <td class="text-nowrap">{{ $user->user_email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @elseif ($isAddUser)
        <div>
            <button wire:click="set('isAddUser', false)" class="btn border-0 bg-transparent"><h4><i class="bi bi-arrow-left"></i></h4></button>
            @livewire('pages::masterfile.users.user-create')
        </div>
        
    @endif



</div>
