<?php

use Livewire\Component;
use App\Models\RiseAgendaType;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $agendaTypeName = '';

    public function addAgendaType()
    {
        // {"agendaTypeName":"AgendaType 1"}
        $validated = $this->validate([
            "agendaTypeName" => "required|string|unique:tblriseagendatypes,agendaType_name",
        ]);
        try {
            RiseAgendaType::create([
                "agendaType_name" => $validated["agendaTypeName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Agenda Type added successfully');
            // $this->dispatch('goBack');
            $this->reset(["agendaTypeName"]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateAgendaType()
    {
        // {"agendaTypeId":1, "agendaTypeName":"AgendaType 5"}
        $validated = $this->validate([
            "agendaTypeName" => "required|string|unique:tblriseagendatypes,agendaType_name,$this->selectedDataId,agendaType_id",
        ]);
        try {
            RiseAgendaType::where("agendaType_id", $this->selectedDataId)->update([
                "agendaType_name" => $validated["agendaTypeName"]
            ]);
            $this->dispatch('toast', type: 'success', message: 'Agenda Type updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = RiseAgendaType::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->agendaType_id;
        $this->agendaTypeName = $data->agendaType_name;
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
                <h5 class="fw-semibold mb-1">Create Rise Agenda Type</h5>
                <small class="text-muted">Fill in the details to add a new rise agenda type</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Agenda Type</h5>
                <small class="text-muted">Provide the details to edit this rise agenda type.</small>
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
        <form wire:submit="{{ $isAddData ? 'addAgendaType' : 'updateAgendaType' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Rise Agenda Type Name *</label>
                <input wire:model="agendaTypeName" name="agendaTypeName" type="text" class="form-control">
                @error('agendaTypeName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addAgendaType' : 'updateAgendaType' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} rise agenda type
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addAgendaType' : 'updateAgendaType' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>