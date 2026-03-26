<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\transaction\InformationSystem;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    public $isAddData = false;
    public $isSeeDetails = false;
    public $isEditData = false;
    public $selectedDataId = null;
    public $selectedDetails = null;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function seeDetails($id)
    {
        $this->isSeeDetails = true;
        $this->selectedDetails = InformationSystem::with(['systemType', 'office', 'systemStatus', 'workEnvironment', 'developmentStrategy', 'user', 'systemProblems', 'infoSysDevelopers.developer.office', 'infoSysFundingSources.fundingSource', 'infoSysInternalUsers.office', 'infoSysExternalUsers.office', 'infoSysRiseAgendas.riseAgenda'])->find($id);
    }

    public function editData($dataId)
    {
        $this->isAddData = false;
        $this->selectedDataId = $dataId;
        $this->isEditData = true;
    }

    public function delete($id)
    {
        try {
            InformationSystem::find($id)->delete();
            $this->dispatch('toast', type: 'success', message: 'System deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This system is currently in use and cannot be deleted.');
        }
    }

    #[On('goBack')]
    public function handleBack()
    {
        $this->isAddData = false;
        $this->isEditData = false;
        $this->isSeeDetails = false;
        $this->selectedDataId = null;
        $this->selectedDetails = null;
    }

    public function render()
    {
        $data = InformationSystem::with(['systemType', 'office', 'systemStatus', 'workEnvironment', 'developmentStrategy', 'user'])
            ->where('infoSys_systemName', 'like', '%' . $this->search . '%')
            ->orderBy('infoSys_rank')
            ->paginate(10);

        return $this->view(['data' => $data]);
    }
};
?>

<div class="container-fluid py-3 px-4">

    @if ($this->isSeeDetails && $this->selectedDetails)
        <div>
            <button wire:click="handleBack" class="is-back-btn mb-4">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 2L4 7l5 5" />
                </svg>
                Back
            </button>
            <livewire:pages::transaction.information-system.information-system-details :data="$this->selectedDetails" />
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
            <livewire:pages::transaction.information-system.information-system-form :isAddData="$isAddData"
                :selectedDataId="$selectedDataId" />
        </div>

    @else
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h5 class="fw-semibold mb-1" style="letter-spacing: -0.02em;">Information Systems</h5>
                <small class="text-muted">List of all registered government information systems.</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <line x1="6.5" y1="1" x2="6.5" y2="12" />
                    <line x1="1" y1="6.5" x2="12" y2="6.5" />
                </svg>
                Add System
            </button>
        </div>

        <div class="mb-3" style="max-width: 300px;">
            <div style="max-width: 320px;">
                <input type="search" wire:model.live.debounce.100ms="search" class="form-control" placeholder="Search...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 56px;">Rank</th>
                        <th>System Name</th>
                        <th>Type</th>
                        <th>Office</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>PIA</th>
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $element)
                        <tr>
                            <td>
                                <span>{{ $element->infoSys_rank }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 500; font-size: 0.85rem; color: var(--text-primary);">
                                    {{ $element->infoSys_systemName }}
                                </div>
                                @if ($element->infoSys_isSmartCityInitiative)
                                    <span class="status-badge badge-smart mt-1" style="display: inline-block;">Smart
                                        City</span>
                                @endif
                            </td>
                            <td>{{ $element->systemType->systemType_name }}</td>
                            <td>{{ $element->office->office_name }}</td>
                            <td>{{ $element->infoSys_initiationYear }}</td>
                            <td>
                                <span class="status-badge badge-status">{{ $element->systemStatus->sysStatus_name }}</span>
                            </td>
                            <td>
                                @if ($element->infoSys_hasPIA)
                                    <span class="status-badge badge-smart">Yes</span>
                                @else
                                    <span class="status-badge badge-muted">No</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <button class="btn btn-outline-dark btn-sm" wire:click="seeDetails({{ $element->infoSys_id }})">
                                    Details
                                </button>
                                <button class="btn btn-primary btn-sm" wire:click="editData({{ $element->infoSys_id }})">
                                    Update
                                </button>
                                <button class="btn btn-danger btn-sm"
                                    wire:confirm="Are you sure you want to delete this system?"
                                    wire:click="delete({{ $element->infoSys_id }})">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted" style="font-size: 0.85rem;">
                                No information systems found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $data->links() }}
        </div>
    @endif

</div>