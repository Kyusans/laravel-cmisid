<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    public $isAddData = false;
    public $isEditData = false;
    public $selectedDataId = null;

    public function editData($userId)
    {
        $this->isAddData = false;
        $this->selectedDataId = $userId;
        $this->isEditData = true;
    }

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with(['office', 'role'])
            ->where('user_id', '!=', Auth::user()->user_id)
            ->where(function ($query) {
                $query
                    ->where('user_firstName', 'like', '%' . $this->search . '%')
                    ->orWhere('user_lastName', 'like', '%' . $this->search . '%')
                    ->orWhere('user_email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return $this->view([
            'users' => $users,
        ]);
    }

    #[On('goBack')]
    public function handleBack()
    {
        $this->isAddData = false;
        $this->isEditData = false;
        $this->selectedDataId = null;
    }

    public function delete($id)
    {

        try {
            $user = User::find($id);
            $user->delete();
            $this->dispatch('toast', type: 'success', message: 'User deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This user is currently in use and cannot be deleted.');
        }

    }
};
?>

<div class="container-fluid">

    @if (!$this->isAddData && !$this->isEditData)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-0">Users</h5>
                <small class="text-muted">List of all users in the system</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add User
            </button>
        </div>
        <hr />

        {{-- Search --}}
        <div class="mb-3">
            <div style="max-width: 320px;">
                <input type="search" wire:model.live.debounce.100ms="search" class="form-control" placeholder="Search...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Office</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->user_lastName }}, {{ $user->user_firstName }}
                                {{ $user->user_middleName ?? '' }}
                            </td>
                            <td>{{ $user->office->office_name }}</td>
                            <td>{{ $user->role->role_name }}</td>
                            <td class="text-nowrap">{{ $user->user_email }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="editData({{ $user->user_id }})">
                                    Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:confirm="Are you sure to delete this user?"
                                    wire:click="delete({{ $user->user_id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    @elseif ($isAddData || $isEditData)
        <div>
            <button wire:click="handleBack" class="is-back-btn mb-4">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 2L4 7l5 5" />
                </svg>
                Back
            </button>

            <livewire:pages::masterfile.users.user-form :isAddData="$isAddData" :userId="$selectedDataId" />
        </div>
    @endif
</div>