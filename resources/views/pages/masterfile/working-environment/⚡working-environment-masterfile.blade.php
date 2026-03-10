<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WorkingEnvironment;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    public $isAddData = false;
    public $isEditData = false;
    public $selectedDataId = null;

    public function editData($dataId)
    {
        $this->isAddData = false;
        $this->selectedDataId = $dataId;
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
        $data = WorkingEnvironment::where('workEnv_name', 'like', '%' . $this->search . '%')->paginate(10);
        return $this->view([
            'data' => $data,
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
            $data = WorkingEnvironment::find($id);
            $data->delete();
            $this->dispatch('toast', type: 'success', message: 'Working environment deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This working environment is currently in use and cannot be deleted.');
        }
    }
};
?>

<div class="container-fluid">

    @if (!$this->isAddData && !$this->isEditData)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-0">Working Environment</h5>
                <small class="text-muted">List of all working environment in the system</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Working Environment
            </button>
        </div>
        <hr />

        {{-- Search --}}
        <div class="mb-3">
            <div style="max-width: 320px;">
                <input type="search" wire:model.live.debounce.100ms="search" class="form-control"
                    placeholder="Search name or email...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Working Environment Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $element)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $element->workEnv_name }}</td>
                            <td>{{ $element->workEnv_description }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="editData({{ $element->workEnv_id }})">
                                    Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:confirm="Are you sure to delete this working environment?"
                                    wire:click="delete({{ $element->workEnv_id }})">Delete</button>
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
            {{ $data->links() }}
        </div>
    @elseif ($isAddData || $isEditData)
        <div>
            <button wire:click="handleBack()" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="bi bi-arrow-left"></i> Back
            </button>

            <livewire:pages::masterfile.working-environment.working-environment-form :isAddData="$isAddData"
                :selectedDataId="$selectedDataId" />
        </div>
    @endif
</div>