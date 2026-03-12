<?php

use Livewire\Component;
use App\Models\WorkingEnvironment;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $workEnvName = '';
    public $workEnvDescription = '';



    public function addWorkingEnvironment()
    {
        // {"workEnvName":"Work Environment 1", "workEnvDescription":"Description 1"}
        try {
            $validated = $this->validate([
                "workEnvName" => "required|unique:tblworkingenvironments,workEnv_name",
                "workEnvDescription" => "required"
            ]);

            WorkingEnvironment::create([
                "workEnv_name" => $validated["workEnvName"],
                "workEnv_description" => $validated["workEnvDescription"]
            ]);
            $this->dispatch("toast", type: "success", message: "Work Environment added successfully");
            $this->reset(["workEnvName", "workEnvDescription"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateWorkingEnvironment()
    {
        // {"workEnvId":1, "workEnvName":"Work Environment 1", "workEnvDescription":"Description 1"}
        try {
            $validated = $this->validate([
                "workEnvName" => "required|unique:tblworkingenvironments,workEnv_name,$this->selectedDataId,workEnv_id",
                "workEnvDescription" => "required"
            ]);

            WorkingEnvironment::where("workEnv_id", $this->selectedDataId)->update([
                "workEnv_name" => $validated["workEnvName"],
                "workEnv_description" => $validated["workEnvDescription"]
            ]);
            $this->dispatch("toast", type: "success", message: "Work Environment updated successfully");
            $this->dispatch("goBack");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = WorkingEnvironment::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->workEnv_id;
        $this->workEnvName = $data->workEnv_name;
        $this->workEnvDescription = $data->workEnv_description;
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
                <h5 class="fw-semibold mb-1">Create Working Environment</h5>
                <small class="text-muted">Fill in the details to add a new working environment.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Working Environment</h5>
                <small class="text-muted">Provide the details to edit this working environment.</small>
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
        <form wire:submit="{{ $isAddData ? 'addWorkingEnvironment' : 'updateWorkingEnvironment' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Working Environment Name *</label>
                <input wire:model="workEnvName" name="workEnvName" type="text" class="form-control">
                @error('workEnvName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Working Environment Description *</label>
                <textarea type="text" wire:model="workEnvDescription" name="workEnvDescription" class="form-control"
                    rows="4"></textarea>
                @error('workEnvDescription')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addWorkingEnvironment' : 'updateWorkingEnvironment' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} working environment
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addWorkingEnvironment' : 'updateWorkingEnvironment' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>