<?php

use Livewire\Component;
use App\Models\DevelopmentStrategy;

new class extends Component {

    public $isAddData;
    public $selectedDataId;

    // for forms
    public $developmentStrategyName = '';

    public function addDevelopmentStrategy()
    {
        // {"developmentStrategyName":"Development Strategy 1"
        $validate = $this->validate([
            "developmentStrategyName" => "required|string|unique:tbldevelopmentstrategies,devStrategy_name"
        ]);
        try {
            DevelopmentStrategy::create([
                "devStrategy_name" => $validate["developmentStrategyName"]
            ]);
            $this->dispatch("toast", type: "success", message: "Development Strategy added successfully");
            $this->reset(["developmentStrategyName"]);
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateDevelopmentStrategy()
    {
        // {"devStrategyId":1,"developmentStrategyName":"Development Strategy 2"}

        $validate = $this->validate([
            "developmentStrategyName" => "required|string|unique:tbldevelopmentstrategies,devStrategy_name,$this->selectedDataId,devStrategy_id"
        ]);
        try {
            DevelopmentStrategy::where("devStrategy_id", $this->selectedDataId)->update([
                "devStrategy_name" => $validate["developmentStrategyName"]
            ]);
            $this->dispatch("toast", type: "success", message: "Development Strategy updated successfully");
            $this->dispatch("goBack");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function loadData($selectedDataId)
    {
        $data = DevelopmentStrategy::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->devStrategy_id;
        $this->developmentStrategyName = $data->devStrategy_name;
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
                <h5 class="fw-semibold mb-1">Create Development Strategy</h5>
                <small class="text-muted">Fill in the details to add a new development strategy</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Development Strategy</h5>
                <small class="text-muted">Provide the details to edit this development strategy.</small>
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
        <form wire:submit="{{ $isAddData ? 'addDevelopmentStrategy' : 'updateDevelopmentStrategy' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Development Strategy Name *</label>
                <input wire:model="developmentStrategyName" name="developmentStrategyName" type="text"
                    class="form-control">
                @error('developmentStrategyName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addDevelopmentStrategy' : 'updateDevelopmentStrategy' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} development strategy
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addDevelopmentStrategy' : 'updateDevelopmentStrategy' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>