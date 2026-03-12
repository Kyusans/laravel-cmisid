<?php

use Livewire\Component;
use App\Models\RiseAgenda;
use App\Models\RiseAgendaType;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $riseAgendaTypes = [];
    public $riseAgendaName = '';
    public $riseAgendaDescription = '';
    public $riseAgendaTypeId = '';

    public function addRiseAgenda()
    {
        // {"riseAgendaName":"Rise Agenda 1"}
        $validated = $this->validate([
            "riseAgendaName" => "required|unique:tblriseagendas,riseAgenda_name",
            "riseAgendaDescription" => "required",
            "riseAgendaTypeId" => "required",
        ]);
        try {
            RiseAgenda::create([
                "riseAgenda_name" => $validated["riseAgendaName"],
                "riseAgenda_description" => $validated["riseAgendaDescription"],
                "riseAgenda_agendaTypeId" => $validated["riseAgendaTypeId"],
            ]);
            $this->reset(["riseAgendaName", "riseAgendaDescription", "riseAgendaTypeId"]);
            $this->dispatch("toast", type: "success", message: "Rise agenda added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateRiseAgenda()
    {
        // {"riseAgendaId":1, "riseAgendaName":"Rise Agenda 1"}
        $validated = $this->validate([
            "riseAgendaName" => "required|unique:tblriseagendas,riseAgenda_name,$this->selectedDataId,riseAgenda_id",
            "riseAgendaDescription" => "required",
            "riseAgendaTypeId" => "required",
        ]);

        try {
            RiseAgenda::where("riseAgenda_id", $this->selectedDataId)->update([
                "riseAgenda_name" => $validated["riseAgendaName"],
                "riseAgenda_description" => $validated["riseAgendaDescription"],
                "riseAgenda_agendaTypeId" => $validated["riseAgendaTypeId"],
            ]);

            $this->dispatch("toast", type: "success", message: "Rise agenda updated successfully");
            $this->dispatch("goBack");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = RiseAgenda::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->riseAgenda_id;
        $this->riseAgendaName = $data->riseAgenda_name;
        $this->riseAgendaDescription = $data->riseAgenda_description;
        $this->riseAgendaTypeId = $data->riseAgenda_agendaTypeId;
    }

    public function mount($isAddData = true, $selectedDataId = null)
    {
        $this->isAddData = $isAddData;
        $this->riseAgendaTypes = RiseAgendaType::all();
        // dd($this->riseAgendaTypes->toArray());
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
                <h5 class="fw-semibold mb-1">Create rise agenda</h5>
                <small class="text-muted">Fill in the details to add a new rise agenda.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit rise agenda</h5>
                <small class="text-muted">Provide the details to edit this rise agenda.</small>
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
        <form wire:submit="{{ $isAddData ? 'addRiseAgenda' : 'updateRiseAgenda' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Rise Agenda Name *</label>
                <input wire:model="riseAgendaName" name="riseAgendaName" type="text" class="form-control">
                @error('riseAgendaName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rise Agenda Description *</label>
                <textarea type="text" wire:model="riseAgendaDescription" name="riseAgendaDescription"
                    class="form-control" rows="4"></textarea>
                @error('riseAgendaDescription')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rise agenda type</label>
                <select wire:model="riseAgendaTypeId" name="riseAgendaTypeId" class="form-select">
                    <option value="">Select rise agenda type...</option>
                    @foreach ($riseAgendaTypes as $element)
                        <option value="{{ $element->agendaType_id }}">{{ $element->agendaType_name }}</option>
                    @endforeach
                </select>
                @error('riseAgendaTypeId')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>


            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addRiseAgenda' : 'updateRiseAgenda' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} rise agenda
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addRiseAgenda' : 'updateRiseAgenda' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>