<?php

use Livewire\Component;
use App\Models\Office;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $officeName = '';

    public function addOffice()
    {
        // {"officeName":"CMISID"}
        $validated = $this->validate([
            "officeName" => "required|string|unique:tbloffices,office_name",
        ]);
        try {
            Office::create([
                "office_name" => $validated["officeName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Office added successfully');
            // $this->dispatch('goBack');
            $this->reset(["officeName"]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateOffice()
    {
        // {"officeName":"CITE", "officeId":1}
        $validated = $this->validate([
            "officeName" => "required|string|unique:tbloffices,office_name,$this->selectedDataId,office_id",
        ]);
        try {
            Office::where("office_id", $this->selectedDataId)->update([
                "office_name" => $validated["officeName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Role updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function loadData($selectedDataId)
    {
        $data = Office::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->office_id;
        $this->officeName = $data->office_name;
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
                <h5 class="fw-semibold mb-1">Create Office</h5>
                    <small class="text-muted">Fill in the details to add a new office</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Role</h5>
                    <small class="text-muted">Provide the details to edit this office.</small>
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
                <form wire:submit="{{ $isAddData ? 'addOffice' : 'updateOffice' }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Office Name *</label>
                        <input wire:model="officeName" name="officeName" type="text" class="form-control">
                        @error('officeName')
                                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}
                            </div>
                        @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addOffice' : 'updateOffice' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} office
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addOffice' : 'updateOffice' }}>
                        <span class=" spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

            </form>
    </div>
</div>