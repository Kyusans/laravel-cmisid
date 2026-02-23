<?php
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\Transaction\InformationSystem;


new class extends Component {
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['query', 'searchFilter'];

    public $query;
    public $id;

    #[Computed]
    public function infosystems()
    {
        if (empty($this->query)) {
            return InformationSystem::paginate(10);
        } else {
            return InformationSystem::where('infoSys_systemName', 'like', '%' . $this->query . '%')
                ->paginate(10);
        }
    }

    public function delete($id)
    {
        $infosystem = InformationSystem::find($id);
        $infosystem->delete();
        session()->flash('success', 'Successfully deleted information system!');
    }

    public function search()
    {
        $this->resetPage();
    }
};
?>

<div>
    <!-- Search Information System Card -->
    <div class="card col-6 mx-auto">
        <div class="card-header">Search Information System</div>
        <div class="card-body text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="d-flex">
                            <div class="input-group">
                                <input class="form-control form-control-md" type="search"
                                    placeholder="Information System Name" aria-label="Search">
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
        <div class="card-header">Information Systems</div>
        <div class="card-body">

            <!-- Pagination -->
            {{ $this->infosystems->links() }}

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Office</th>
                            <th scope="col">Initiation Year</th>
                            <th scope="col">PIA Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->infosystems as $infoSys)
                            <tr>
                                <td>{{ $infoSys->infoSys_rank }}</td>
                                <td>{{ $infoSys->infoSys_systemName }}</td>
                                <td>{{ $infoSys->systemType->systemType_name }}</td>
                                <td>{{ $infoSys->office->office_name }}</td>
                                <td>{{ $infoSys->initiationYear }}</td>
                                <td>{{ $infoSys->hasPIA }}</td>
                                <td>
                                    <a href=""><button type="button"
                                            class="btn btn-primary">View More</button></a>
                                    <button type="button" class="btn btn-danger"
                                        wire:confirm="Are you sure to delete this user?"
                                        wire:click="delete({{ $infosystem->infoSys_id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $this->infosystems->links() }}

        </div>
    </div>
</div>