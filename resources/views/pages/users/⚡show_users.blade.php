<?php
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\User;
use App\Models\Tables;


new class extends Component {
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['query', 'sortField', 'sortDirection'];

    public $query;
    public $searchFilter = 'Name';
    public $id;
    public $sortField = 'user_lastName';
    public $sortDirection = 'asc';
    public $officeFilter = '';
    public $roleFilter = '';

    #[Computed]
    public function users()
    {
        return User::query()
            ->with(['role', 'office']) // no need for user->role->role_name ..., making it shorter
            ->when($this->query, function ($query) { // search query
                $query->where(function ($q) {
                    if ($this->searchFilter == 'Name') {
                        $q->where('user_firstName', 'like', '%' . $this->query . '%')
                            ->orWhere('user_middleName', 'like', '%' . $this->query . '%')
                            ->orWhere('user_lastName', 'like', '%' . $this->query . '%');
                    }
                    if ($this->searchFilter == 'Email') {
                        $q->where('user_email', 'like', '%' . $this->query . '%');
                    }
                });
            })
            ->when($this->officeFilter, function ($q) {
                $q->where('user_officeId', $this->officeFilter);
            })
            ->when($this->roleFilter, function ($q) {
                $q->where('user_roleId', $this->roleFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'Successfully deleted student!');
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        // If still same column as original selected sorting column
        if ($this->sortField === $field) {
            // Change it to the opp (e.g., if asc change to desc and vice versa)
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }

    public function sortIcon($field)
    {
        if ($this->sortField !== $field) {
            return null;
        }

        return $this->sortDirection === 'asc'
            ? 'bi bi-arrow-up'
            : 'bi bi-arrow-down';
    }
};
?>

<div>
    <x-slot:title>Users</x-slot:title>

    <!-- Search User Card -->
    <div class="card col-6 mx-auto">
        <div class="card-header">Search User</div>
        <div class="card-body text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form wire:submit="search" class="d-flex">
                            <div class="input-group">
                                <input wire:model="query" class="form-control form-control-md" type="search"
                                    placeholder="Search..." aria-label="Search">
                                <select wire:model="searchFilter" class="form-select bg-light"
                                    style="max-width: 130px;">
                                    <option selected>Name</option>
                                    <option>Email</option>
                                </select>
                                <button class="btn btn-primary px-4" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-6 mt-3 mx-auto">
        <div class="card-header">Users</div>
        <div class="card-body">

            <!-- Pagination -->
            <a href="{{ route("create.user") }}"><button class="btn btn-secondary">Create User</button></a>
            {{ $this->users->links() }}

            <!-- Table Filter -->
            <div class="row mt-3 mb-3">
                <span class="mb-3">Include:</span>
                <div class="col">
                    <select wire:model.live="officeFilter" class="form-select">
                        <option value="">All Offices</option>
                        @foreach (\App\Models\Office::all() as $office)
                            <option value="{{ $office->office_id }}">
                                {{ $office->office_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <select wire:model.live="roleFilter" class="form-select">
                        <option value="">All Roles</option>
                        <option value="1">Admin</option>
                        <option value="2">Office User</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('user_lastName')" style="cursor:pointer" scope="col">
                                Name
                                @if ($icon = $this->sortIcon('user_lastName'))
                                    <i class="{{ $icon }} ms-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('user_email')" style="cursor:pointer" scope="col">
                                Email
                                @if ($icon = $this->sortIcon('user_email'))
                                    <i class="{{ $icon }} ms-1"></i>
                                @endif
                            </th>
                            <th scope="col">Role</th>
                            <th scope="col">Office</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->users as $user)
                            <tr>
                                <td>{{ $user->user_lastName }}, {{ $user->user_firstName }} {{ $user->user_middleName }}
                                </td>
                                <td>{{ $user->user_email }}</td>
                                <td>{{ $user->role->role_name }}</td>
                                <td>{{ $user->office->office_name }}</td>
                                <td>
                                    <a href="{{ route("details.user", $user) }}"><button type="button"
                                            class="btn btn-primary">View More</button></a>
                                    <button type="button" class="btn btn-danger"
                                        wire:confirm="Are you sure to delete this user?"
                                        wire:click="delete({{ $user->user_id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $this->users->links()  }}

        </div>
    </div>
</div>