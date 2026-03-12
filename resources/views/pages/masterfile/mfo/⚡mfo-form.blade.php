<?php

use Livewire\Component;
use App\Models\Mfo;
use App\Models\Office;
new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $offices = [];
    public $mfoName = '';
    public $officeId = '';

    public function addMfo()
    {
        // {"mfoName":"MFO 1", "officeId":1}
        $validated = $this->validate([
            "mfoName" => "required|string",
            "officeId" => "required|integer",
        ]);
        try {
            Mfo::create([
                "mfo_name" => $validated["mfoName"],
                "mfo_officeId" => $validated["officeId"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'MFO added successfully');
            $this->reset(["mfoName", "officeId"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateMfo()
    {
        // {"mfoId":1, "mfoName":"MFO 2", "officeId":2}
        $validated = $this->validate([
            "mfoName" => "required|string",
            "officeId" => "required|integer",
        ]);
        try {
            Mfo::where("mfo_id", $this->selectedDataId)->update([
                "mfo_name" => $validated["mfoName"],
                "mfo_officeId" => $validated["officeId"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'MFO updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    public function loadData($selectedDataId)
    {
        $data = Mfo::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->mfo_id;
        $this->mfoName = $data->mfo_name;
        $this->officeId = $data->mfo_officeId;
    }

    public function mount($isAddData = true, $selectedDataId = null)
    {
        $this->isAddData = $isAddData;
        $this->offices = Office::all();
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
                <h5 class="fw-semibold mb-1">Create MFO</h5>
                <small class="text-muted">Fill in the details to add a MFO.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit MFO</h5>
                <small class="text-muted">Provide the details to edit this MFO.</small>
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
        <form wire:submit="{{ $isAddData ? 'addMfo' : 'updateMfo' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">MFO *</label>
                <input wire:model="mfoName" name="mfoName" type="text" class="form-control">
                @error('mfoName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Office *</label>
                <select wire:model="officeId" name="officeId" class="form-select">
                    <option value="">Select office...</option>
                    @foreach ($offices as $element)
                        <option value="{{ $element->office_id }}">{{ $element->office_name }}</option>
                    @endforeach
                </select>
                @error('officeId')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addMfo' : 'updateMfo' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} MFO
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addMfo' : 'updateMfo' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>