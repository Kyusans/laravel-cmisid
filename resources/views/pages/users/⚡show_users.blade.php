<?php
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\User;


new class extends Component {
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $id;

    #[Computed]
    public function users()
    {
        return User::paginate(10);
    }

    public function delete($id) {
        $user = User::find($id);
        $user->delete();
        session()->flash('success', 'Successfully deleted student!');
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
                        <form class="d-flex">
                            <div class="input-group">
                                <input class="form-control form-control-md" type="search"
                                    placeholder="Firstname/Lastname" aria-label="Search">
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
            {{ $this->users->links()  }}

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Office</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->users as $user)
                            <tr>
                                <td>{{ $user->user_firstName }} {{ $user->user_lastName }}</td>
                                <td>{{ $user->user_email }}</td>
                                <td>{{ $user->role->role_name }}</td>
                                <td>{{ $user->office->office_name }}</td>
                                <td>
                                    <a href="{{ route("details.user", $user) }}"><button type="button" class="btn btn-primary">View More</button></a>
                                    <button type="button" class="btn btn-danger" wire:confirm="Are you sure to delete this user?" wire:click="delete({{ $user->user_id }})">Delete</button>
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