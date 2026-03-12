<?php

use Livewire\Component;
use App\Models\Ppa;
use App\Models\Office;
new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $offices = [];
    public $ppaName = '';
    public $officeId = '';

    public function addPpa()
    {
        // {"ppaName":"PPA 1", "officeId":1}
        try {
            $validated = $this->validate([
                "ppaName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Ppa::create([
                "ppa_name" => $validated["ppaName"],
                "ppa_officeId" => $validated["officeId"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'PPA added successfully');
            $this->reset(["ppaName", "officeId"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updatePpa()
    {
        // {"ppaId":1,"ppaName":"PPA 2", "officeId":1}
        try {
            $validated = $this->validate([
                "ppaName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Ppa::where("ppa_id", $this->selectedDataId)->update([
                "ppa_name" => $validated["ppaName"],
                "ppa_officeId" => $validated["officeId"]
            ]);
            // return response()->json($stmt);
            $this->dispatch('toast', type: 'success', message: 'PPA updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    public function loadData($selectedDataId)
    {
        $data = Ppa::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->ppa_id;
        $this->ppaName = $data->ppa_name;
        $this->officeId = $data->ppa_officeId;
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
                <h5 class="fw-semibold mb-1">Create PPA</h5>
                <small class="text-muted">Fill in the details to add a PPA.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit PPA</h5>
                <small class="text-muted">Provide the details to edit this PPA.</small>
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
        <form wire:submit="{{ $isAddData ? 'addPpa' : 'updatePpa' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">PPA *</label>
                <input wire:model="ppaName" name="ppaName" type="text" class="form-control">
                @error('ppaName')
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
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addPpa' : 'updatePpa' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} PPA
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addPpa' : 'updatePpa' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>