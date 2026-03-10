<?php

use Livewire\Component;
use App\Models\FundingSource;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $fundingName = '';

    public function addFundingSource()
    {
        // {"fundingName":"Funding Source 1"}
        $validated = $this->validate([
            "fundingName" => "required|string|unique:tblfundingsource,funding_name",
        ]);
        try {
            FundingSource::create([
                "funding_name" => $validated["fundingName"]
            ]);
            $this->dispatch("toast", type: "success", message: "Funding Source added successfully");
            $this->reset(["fundingName"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateFundingSource()
    {
        // {"fundingId":1, "fundingName":"Funding Source 1"}
        $validated = $this->validate([
            "fundingName" => "required|string|unique:tblfundingsource,funding_name,$this->selectedDataId,funding_id",
        ]);
        try {

            FundingSource::where("funding_id", $this->selectedDataId)->update([
                "funding_name" => $validated["fundingName"]
            ]);
            $this->dispatch("toast", type: "success", message: "Funding Source updated successfully");
            $this->dispatch("goBack");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = FundingSource::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->funding_id;
        $this->fundingName = $data->funding_name;
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
                <h5 class="fw-semibold mb-1">Create Funding Source</h5>
                <small class="text-muted">Fill in the details to add a new funding source</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Funding Source</h5>
                <small class="text-muted">Provide the details to edit this funding source.</small>
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
        <form wire:submit="{{ $isAddData ? 'addFundingSource' : 'updateFundingSource' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Funding Source Name *</label>
                <input wire:model="fundingName" name="fundingName" type="text" class="form-control">
                @error('fundingName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addFundingSource' : 'updateFundingSource' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} funding source
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addFundingSource' : 'updateFundingSource' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>