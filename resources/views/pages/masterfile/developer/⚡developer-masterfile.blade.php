<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Developer;
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
        $data = Developer::with("office")->where('dev_firstName', 'like', '%' . $this->search . '%')
            ->orWhere("dev_lastName", "like", "%" . $this->search . "%")
            ->orWhere("dev_middleName", "like", "%" . $this->search . "%")->paginate(10);

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
            $data = Developer::find($id);
            $data->delete();
            $this->dispatch('toast', type: 'success', message: 'Developer deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This developer is currently in use and cannot be deleted.');
        }
    }
};
?>

<div class="container-fluid">

    @if (!$this->isAddData && !$this->isEditData)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-0">Developer</h5>
                <small class="text-muted">List of all developers in the system</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Developer
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
                        <th>Developer Name</th>
                        <th>Office</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $element)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $element->dev_lastName }}, {{ $element->dev_firstName }}
                                {{ $element->user_middleName ?? '' }}
                            </td>
                            <td>{{ $element->office->office_name }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="editData({{ $element->dev_id }})">
                                    Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:confirm="Are you sure to delete this developer?"
                                    wire:click="delete({{ $element->dev_id }})">Delete</button>
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
            <button wire:click="handleBack" class="is-back-btn mb-4">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 2L4 7l5 5" />
                </svg>
                Back
            </button>

            <livewire:pages::masterfile.developer.developer-form :isAddData="$isAddData"
                :selectedDataId="$selectedDataId" />
        </div>
    @endif
</div>