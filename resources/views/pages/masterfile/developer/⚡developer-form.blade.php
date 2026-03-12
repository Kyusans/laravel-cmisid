<?php

use Livewire\Component;
use App\Models\Developer;
use App\Models\Office;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $office = [];
    public $devFirstName = '';
    public $devMiddleName = '';
    public $devLastName = '';
    public $devOfficeId = '';


    public function addDeveloper()
    {
        // {"devFirstName":"Bea Ysabel", "devMiddleName": "Macalua", "devLastName": "Lacheca", "devOfficeId": 2}
        $validated = $this->validate([
            "devFirstName" => "required|string",
            "devMiddleName" => "nullable|string",
            "devLastName" => "required|string",
            "devOfficeId" => "required|integer|exists:tbloffices,office_id",
        ]);
        try {
            Developer::create([
                "dev_firstName" => $validated["devFirstName"],
                "dev_middleName" => $validated["devMiddleName"],
                "dev_lastName" => $validated["devLastName"],
                "dev_officeId" => $validated["devOfficeId"],
            ]);

            $this->dispatch('toast', type: 'success', message: 'Developer added successfully');
            $this->reset(["devFirstName", "devMiddleName", "devLastName", "devOfficeId"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateDeveloper()
    {
        // {"devId": 1, "devFirstName": "Bea Ysabel", "devMiddleName": "Macalua", "devLastName": "Macario", "devOfficeId": 2}
        $validated = $this->validate([
            "devFirstName" => "required|string",
            "devMiddleName" => "nullable|string",
            "devLastName" => "required|string",
            "devOfficeId" => "required|integer|exists:tbloffices,office_id",
        ]);
        try {
            Developer::where("dev_id", $this->selectedDataId)->update([
                "dev_firstName" => $validated["devFirstName"],
                "dev_middleName" => $validated["devMiddleName"],
                "dev_lastName" => $validated["devLastName"],
                "dev_officeId" => $validated["devOfficeId"],
            ]);
            $this->dispatch('toast', type: 'success', message: 'Developer updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = Developer::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->dev_id;
        $this->devFirstName = $data->dev_firstName;
        $this->devMiddleName = $data->dev_middleName;
        $this->devLastName = $data->dev_lastName;
        $this->devOfficeId = $data->dev_officeId;
    }

    public function mount($isAddData = true, $selectedDataId = null)
    {
        $this->isAddData = $isAddData;
        $this->office = Office::all();
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
                <h5 class="fw-semibold mb-1">Create Developer</h5>
                <small class="text-muted">Fill in the details to add a developer.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Developer</h5>
                <small class="text-muted">Provide the details to edit this developer.</small>
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
        <form wire:submit="{{ $isAddData ? 'addDeveloper' : 'updateDeveloper' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">First Name *</label>
                <input wire:model="devFirstName" name="devFirstName" type="text" class="form-control">
                @error('devFirstName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Middle Name</label>
                <input wire:model="devMiddleName" name="devMiddleName" type="text" class="form-control">
                @error('devMiddleName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name *</label>
                <input wire:model.live="devLastName" name="devLastName" type="text" class="form-control">
                @error('devLastName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Office</label>
                <select wire:model="devOfficeId" name="devOfficeId" class="form-select">
                    <option value="">Select office...</option>
                    @foreach ($office as $element)
                        <option value="{{ $element->office_id }}">{{ $element->office_name }}</option>
                    @endforeach
                </select>
                @error('devOfficeId')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addDeveloper' : 'updateDeveloper' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} developer
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addDeveloper' : 'updateDeveloper' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>