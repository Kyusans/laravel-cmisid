<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\transaction\InformationSystem;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination;

    public $isAddData = false;
    public $isSeeDetails = true;
    public $isEditData = false;
    public $selectedDataId = null;
    public $selectedDetails = null;

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
        $this->selectedDetails = InformationSystem::with(
            "systemType",
            "office",
            "systemStatus",
            "workEnvironment",
            "developmentStrategy",
            "user",
            "systemProblems",
            "infoSysDevelopers",
            "infoSysFundingSources",
            "infoSysInternalUsers",
            "infoSysExternalUsers",
            "infoSysRiseAgendas",
            "infoSysDevelopers.developer",
            "infoSysFundingSources.fundingSource",
            "infoSysInternalUsers.infoInternal",
            "infoSysExternalUsers.infoExternal",
            "infoSysRiseAgendas.riseAgenda",
        )->find(3);

        $data = InformationSystem::with(
            "systemType",
            "office",
            "systemStatus",
            "workEnvironment",
            "developmentStrategy",
            "user",
            "systemProblems",
            "infoSysDevelopers",
            "infoSysFundingSources",
            "infoSysInternalUsers",
            "infoSysExternalUsers",
            "infoSysRiseAgendas"
        )
            ->where('infoSys_systemName', 'like', '%' . $this->search . '%')->paginate(10);

        // dd($data->toArray());
        return $this->view([
            'data' => $data,
        ]);
    }

    public function seeDetails($id)
    {
        $this->isSeeDetails = true;

        $this->selectedDetails = InformationSystem::with(
            "systemType",
            "office",
            "systemStatus",
            "workEnvironment",
            "developmentStrategy",
            "user",
            "systemProblems",
            "infoSysDevelopers",
            "infoSysFundingSources",
            "infoSysInternalUsers",
            "infoSysExternalUsers",
            "infoSysRiseAgendas"
        )->find($id);
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
            $data = InformationSystem::find($id);
            $data->delete();
            $this->dispatch('toast', type: 'success', message: 'System deleted successfully');
        } catch (\Throwable $th) {
            $this->dispatch('toast', type: 'danger', message: 'This system is currently in use and cannot be deleted.');
        }
    }
};
?>

<div class="container-fluid">

    @if($this->isSeeDetails)
        <livewire:pages::transaction.information-system.information-system-details :data="$this->selectedDetails" />
    @endif

    @if (!$this->isAddData && !$this->isEditData && !$this->isSeeDetails)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-semibold mb-0">Information systems</h5>
                <small class="text-muted">List of all information systems in the system</small>
            </div>
            <button wire:click="set('isAddData', true)" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add Information Sytem
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
                        <th>Rank</th>
                        <th>System Name</th>
                        <th>Type of system</th>
                        <th>Office</th>
                        <th>Initiation Year</th>
                        <th>PIA Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $element)
                        <tr>
                            <td>{{ $element->infoSys_rank }}</td>
                            <td>{{ $element->infoSys_systemName }}</td>
                            <td>{{ $element->systemType->systemType_name }}</td>
                            <td>{{ $element->office->office_name }}</td>
                            <td>{{ $element->infoSys_initiationYear }}</td>
                            <td>{{ $element->infoSys_hasPIA ? 'Yes' : 'No' }}</td>
                            <td class="text-nowrap">
                                <button class="btn btn-outline-dark"
                                    wire:click="seeDetails({{ $element->infoSys_id }})">Details</button>
                                <button type="button" class="btn btn-primary btn-sm"
                                    wire:click="editData({{ $element->infoSys_id }})">
                                    Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:confirm="Are you sure to delete this system?"
                                    wire:click="delete({{ $element->infoSys_id }})">Delete</button>
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

            <livewire:pages::masterfile.role.role-form :isAddData="$isAddData" :selectedDataId="$selectedDataId" />
        </div>
    @endif
</div>