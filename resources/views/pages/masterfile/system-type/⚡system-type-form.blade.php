<?php

use Livewire\Component;
use App\Models\SystemType;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $systemTypeName = '';
    public $systemTypeDescription = '';

    public function addSystemType()
    {
        // {"systemTypeName":"System Type 1", "systemTypeDescription":"Description 1"}
        $validated = $this->validate([
            "systemTypeName" => "required|unique:tblsystemtypes,systemType_name",
            "systemTypeDescription" => "required"
        ]);
        try {
            SystemType::create([
                "systemType_name" => $validated["systemTypeName"],
                "systemType_description" => $validated["systemTypeDescription"]
            ]);
            $this->dispatch("toast", type: "success", message: "System type added successfully");
            // $this->dispatch("goBack");
            $this->reset(["systemTypeName", "systemTypeDescription"]);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateSystemType(Request $request)
    {
        // {"systemTypeId":1, "systemTypeName":"System Type 1", "systemTypeDescription":"Description 1"}

        $validated = $this->validate([
            "systemTypeName" => "required|unique:tblsystemtypes,systemType_name,$this->selectedDataId,systemType_id",
            "systemTypeDescription" => "required"
        ]);
        try {
            SystemType::where("systemType_id", $this->selectedDataId)->update([
                "systemType_name" => $validated["systemTypeName"],
                "systemType_description" => $validated["systemTypeDescription"]
            ]);
            $this->dispatch("toast", type: "success", message: "System type updated successfully");
            $this->dispatch("goBack");

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = SystemType::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->systemType_id;
        $this->systemTypeName = $data->systemType_name;
        $this->systemTypeDescription = $data->systemType_description;
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
                <h5 class="fw-semibold mb-1">Create System Type</h5>
                <small class="text-muted">Fill in the details to add a new system type</small>
            @else
                <h5 class="fw-semibold mb-1">Edit System Type</h5>
                <small class="text-muted">Provide the details to edit this system type.</small>
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
        <form wire:submit="{{ $isAddData ? 'addSystemType' : 'updateSystemType' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">System Type Name *</label>
                <input wire:model="systemTypeName" name="systemTypeName" type="text" class="form-control">
                @error('systemTypeName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">System Type Description *</label>
                <textarea type="text" wire:model="systemTypeDescription" name="systemTypeDescription"
                    class="form-control" rows="4"></textarea>
                @error('systemTypeDescription')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addSystemType' : 'updateSystemType' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} system type
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addSystemType' : 'updateSystemType' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>