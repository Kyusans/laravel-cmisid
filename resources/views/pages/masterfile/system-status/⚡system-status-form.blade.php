<?php

use Livewire\Component;
use App\Models\SystemStatus;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $systemStatusName = '';

    public function addSystemStatus()
    {
        // {"systemStatusName":"System Status 1"}

        $validated = $this->validate([
            "systemStatusName" => "required|unique:tblsystemstatus,sysStatus_name",
        ]);
        try {
            SystemStatus::create([
                "sysStatus_name" => $validated["systemStatusName"]
            ]);
            $this->dispatch("toast", type: "success", message: "System Status added successfully");
            $this->reset(["systemStatusName"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateSystemStatus()
    {
        // {"systemStatusId":1, "systemStatusName":"System Status 1"}

        $validated = $this->validate([
            "systemStatusName" => "required|unique:tblsystemstatus,sysStatus_name,$this->selectedDataId,sysStatus_id",
        ]);
        try {
            SystemStatus::where("sysStatus_id", $this->selectedDataId)->update([
                "sysStatus_name" => $validated["systemStatusName"]
            ]);
            $this->dispatch("toast", type: "success", message: "System Status updated successfully");
            $this->dispatch("goBack");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = SystemStatus::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->sysStatus_id;
        $this->systemStatusName = $data->sysStatus_name;
    }

    public function mount($isAddData = true, $selectedDataId = null)
    {
        $this->isAddData = $isAddData;
        if ($selectedDataId) {
            $this->loadData($selectedDataId);
        }
    }

    public function render()
    {
        return $this->view();
    }
};
?>

<div>
    <div>
        <div class="mb-4">
            @if ($isAddData)
                <h5 class="fw-semibold mb-1">Create System Status</h5>
                <small class="text-muted">Fill in the details to add a new system status.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit System Status</h5>
                <small class="text-muted">Provide the details to edit this system status.</small>
            @endif
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form wire:submit="{{ $isAddData ? 'addSystemStatus' : 'updateSystemStatus' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">System Status Name *</label>
                <input wire:model="systemStatusName" name="systemStatusName" type="text" class="form-control">
                @error('systemStatusName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addSystemStatus' : 'updateSystemStatus' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} system status
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addSystemStatus' : 'updateSystemStatus' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>