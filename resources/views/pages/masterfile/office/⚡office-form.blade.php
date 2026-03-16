<?php

use Livewire\Component;
use App\Models\Office;
use App\Models\Mfo;
use App\Models\Ppa;

new class extends Component {
    public $isAddData;
    public $selectedDataId;

    public $officeName = '';

    public $mfo = [];
    public $ppa = [];

    public function addMfo()
    {
        $this->mfo[] = ['mfo_id' => null, 'mfoName' => ''];
    }

    public function removeMfo($index)
    {
        unset($this->mfo[$index]);
        $this->mfo = array_values($this->mfo);
    }

    public function addPpa()
    {
        $this->ppa[] = ['ppa_id' => null, 'ppaName' => ''];
    }

    public function removePpa($index)
    {
        unset($this->ppa[$index]);
        $this->ppa = array_values($this->ppa);
    }

    public function loadData($selectedDataId)
    {
        $data = Office::with(['mfos', 'ppas'])->find($selectedDataId);
        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->office_id;
        $this->officeName = $data->office_name;

        $this->mfo = $data->mfos
            ->map(
                fn($item) => [
                    'mfo_id' => $item->mfo_id,
                    'mfoName' => $item->mfo_name,
                ],
            )
            ->toArray();

        $this->ppa = $data->ppas
            ->map(
                fn($item) => [
                    'ppa_id' => $item->ppa_id,
                    'ppaName' => $item->ppa_name,
                ],
            )
            ->toArray();
    }

    public function saveMfo($officeId, $mfo)
    {
        foreach ($mfo as $element) {
            Mfo::updateOrCreate(
                [
                    'mfo_id' => $element['mfo_id'] ?? null,
                ],
                [
                    'mfo_name' => $element['mfoName'],
                    'mfo_officeId' => $officeId,
                ],
            );
        }
    }

    public function savePpa($officeId, $ppa)
    {
        foreach ($ppa as $element) {
            Ppa::updateOrCreate(
                [
                    'ppa_id' => $element['ppa_id'] ?? null,
                ],
                [
                    'ppa_name' => $element['ppaName'],
                    'ppa_officeId' => $officeId,
                ],
            );
        }
    }

    public function addOffice()
    {
        // {"officeName":"CMISID",
        // "mfo":[{"mfoName":"MFO 1", "officeId":1}, {"mfoName":"MFO 2", "officeId":1}],
        // "ppa":[{"ppaName":"PPA 1", "officeId":1}, {"ppaName":"PPA 2", "officeId":1}]
        // }
        $validated = $this->validate([
            'officeName' => 'required|string|unique:tbloffices,office_name',
        ]);
        try {
            DB::transaction(function () use ($validated) {
                $stmt = Office::create([
                    'office_name' => $validated['officeName'],
                ]);
                $officeId = $stmt->office_id;
                $this->saveMfo($officeId, $this->mfo);
                $this->savePpa($officeId, $this->ppa);
            });

            $this->dispatch('toast', type: 'success', message: 'Office added successfully');
            // $this->dispatch('goBack');
            $this->reset(['officeName']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateOffice()
    {
        // {"officeName":"CITE", "officeId":1
        // "mfo":[{"mfoName":"MFO 1", "officeId":1}, {"mfoName":"MFO 2", "officeId":1}],
        // "ppa":[{"ppaName":"PPA 1", "officeId":1}, {"ppaName":"PPA 2", "officeId":1}]
        // }
        $validated = $this->validate([
            'officeName' => "required|string|unique:tbloffices,office_name,$this->selectedDataId,office_id",
        ]);

        try {
            DB::transaction(function () use ($validated) {
                Office::where('office_id', $this->selectedDataId)->update([
                    'office_name' => $validated['officeName'],
                ]);
            });
            $this->saveMfo($this->selectedDataId, $this->mfo);
            $this->savePpa($this->selectedDataId, $this->ppa);
            $this->dispatch('toast', type: 'success', message: 'Office updated successfully');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // public function loadData($selectedDataId)
    // {
    //     $data = Office::find($selectedDataId);

    //     if (!$data) {
    //         return;
    //     }

    //     $this->selectedDataId = $data->office_id;
    //     $this->officeName = $data->office_name;
    // }

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
    <div class="p-4">
        <div class="mb-4">
            <h5 class="fw-semibold mb-1">{{ $isAddData ? 'Create Office' : 'Edit Office' }}</h5>
            <small class="text-muted">Fill in the details below.</small>
        </div>

        <form wire:submit="{{ $isAddData ? 'addOffice' : 'updateOffice' }}">
            <div class="mb-4">
                <label class="form-label fw-bold">Office Name *</label>
                <input wire:model="officeName" type="text" class="form-control">
                @error('officeName')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <hr>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label fw-bold mb-0">MFOs</label>
                    <button type="button" wire:click="addMfo" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-lg"></i> Add MFO
                    </button>
                </div>

                @foreach ($mfo as $index => $item)
                    <div class="input-group mb-2" key="mfo-{{ $index }}">
                        <input type="text" wire:model="mfo.{{ $index }}.mfoName" class="form-control"
                            placeholder="Enter MFO name">
                        <button type="button" wire:click="removeMfo({{ $index }})"
                            class="btn btn-outline-danger">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    @error("mfo.$index.mfoName")
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label fw-bold mb-0">PPAs</label>
                    <button type="button" wire:click="addPpa" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-lg"></i> Add PPA
                    </button>
                </div>

                @foreach ($ppa as $index => $item)
                    <div class="input-group mb-2" key="ppa-{{ $index }}">
                        <input type="text" wire:model="ppa.{{ $index }}.ppaName" class="form-control"
                            placeholder="Enter PPA name">
                        <button type="button" wire:click="removePpa({{ $index }})"
                            class="btn btn-outline-danger">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    @error("ppa.$index.ppaName")
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ $isAddData ? 'Create' : 'Update' }} Office</span>
                    <span wire:loading class="spinner-border spinner-border-sm"></span>
                </button>
            </div>
        </form>
    </div>
</div>
