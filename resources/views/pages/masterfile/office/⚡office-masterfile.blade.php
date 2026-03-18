<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Office;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    public $isAddData = false;
    public $isEditData = false;
    public $selectedDataId = null;
    public $search = '';

    // For Modal Details
    public $viewingDetails = null;

    public function render()
    {
        $data = Office::withCount(['mfos', 'ppas'])
            ->where('office_name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return $this->view(['data' => $data]);
    }

    public function showDetails($id)
    {
        $this->viewingDetails = Office::with(['mfos', 'ppas'])->find($id);
    }

    public function closeDetails()
    {
        $this->viewingDetails = null;
    }

    public function editData($dataId)
    {
        $this->isAddData = false;
        $this->selectedDataId = $dataId;
        $this->isEditData = true;
    }

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
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
            $data = Office::find($id);
            $data->delete();
            $this->dispatch('toast', type: 'success', message: 'Office deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This office is currently in use and cannot be deleted.');
        }
    }
};
?>

<div class="container-fluid">

    @if (!$this->isAddData && !$this->isEditData)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-0">Offices</h5>
                <small class="text-muted">List of all offices in the system</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Offices
            </button>
        </div>
        <hr />

        {{-- Search --}}
        <div class="mb-3">
            <div style="max-width: 320px;">
                <input type="search" wire:model.live.debounce.100ms="search" class="form-control"
                    placeholder="Search...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Office Name</th>
                        <th class="text-center">MFOs</th>
                        <th class="text-center">PPAs</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $element)
                        <tr>
                            <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $element->office_name }}</td>
                            <td class="text-center">{{ $element->mfos_count }}</td>
                            <td class="text-center">{{ $element->ppas_count }}</td>
                            <td class="text-nowrap">
                                <button title="View Details" wire:click="showDetails({{ $element->office_id }})"
                                    class="btn btn-outline-info btn-sm">
                                    Details
                                </button>
                                <button wire:click="editData({{ $element->office_id }})"
                                    class="btn btn-primary btn-sm">Update</button>
                                <button wire:click="delete({{ $element->office_id }})" wire:confirm="Are you sure?"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @empty
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

            <livewire:pages::masterfile.office.office-form :isAddData="$isAddData" :selectedDataId="$selectedDataId" />
        </div>
    @endif

    @if ($viewingDetails)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">

                    <div class="modal-header border-bottom-0 pb-0">
                        <div>
                            <h3 class="modal-title fw-bold mb-0">{{ $viewingDetails->office_name }}</h3>
                            <small class="text-muted">Office Details</small>
                        </div>
                        <button type="button" class="btn-close" wire:click="closeDetails"></button>
                    </div>

                    <div class="modal-body pt-3">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fw-semibold">MFOs</span>    
                                </div>
                                @forelse($viewingDetails->mfos as $mfo)
                                    <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                        <i class="bi bi-dot text-primary fs-5"></i>
                                        <span class="text-muted small">{{ $mfo->mfo_name }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted small fst-italic">No MFOs added.</p>
                                @endforelse
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="fw-semibold">PPAs</span>
                                </div>
                                @forelse($viewingDetails->ppas as $ppa)
                                    <div class="d-flex align-items-center gap-2 py-2 border-bottom">
                                        <i class="bi bi-dot text-success fs-5"></i>
                                        <span class="text-muted small">{{ $ppa->ppa_name }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted small fst-italic">No PPAs added.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-primary btn-sm px-4" wire:click="closeDetails">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
