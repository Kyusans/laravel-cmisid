<?php

use Livewire\Component;
use App\Models\Transaction\InformationSystem;
use App\Models\Transaction\InfoSysDeveloper;
use App\Models\Transaction\InfoSysExternalUser;
use App\Models\Transaction\InfoSysFunding;
use App\Models\Transaction\InfoSysInternalUser;
use App\Models\Transaction\InfoSysRiseAgenda;
use App\Models\Transaction\SystemProblem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public $isAddData;
    public $selectedDataId;

    // for forms
    public $roleName = '';

    public function saveSystemProblems($infoSysId, $systemProblems)
    {
        foreach ($systemProblems as $systemProblem) {
            SystemProblem::create([
                'sysprob_infoSysId' => $infoSysId,
                'sysprob_problem' => $systemProblem['systemProblemName'],
            ]);
        }
    }

    public function saveDevelopers($infoSysId, $developers)
    {
        foreach ($developers as $developer) {
            InfoSysDeveloper::create([
                'infodev_infoSysId' => $infoSysId,
                'infodev_devId' => $developer['devId'],
            ]);
        }
    }

    public function saveFundingSources($infoSysId, $fundingSources)
    {
        foreach ($fundingSources as $fundingSource) {
            InfoSysFunding::create([
                'infoFund_infoSysId' => $infoSysId,
                'infoFund_fundingId' => $fundingSource['fundingSourceId'],
            ]);
        }
    }

    public function saveRiseAgendas($infoSysId, $riseAgendas)
    {
        foreach ($riseAgendas as $riseAgenda) {
            InfoSysRiseAgenda::create([
                'infoAgenda_infoSysId' => $infoSysId,
                'infoAgenda_riseAgendaId' => $riseAgenda['riseAgendaId'],
            ]);
        }
    }

    public function saveInternalUsers($infoSysId, $internalUsers)
    {
        foreach ($internalUsers as $internalUser) {
            InfoSysInternalUser::create([
                'infoInternal_infoSysId' => $infoSysId,
                'infoInternal_officeId' => $internalUser['internalUserId'],
            ]);
        }
    }

    public function saveExternalUsers($infoSysId, $externalUsers)
    {
        foreach ($externalUsers as $externalUser) {
            InfoSysExternalUser::create([
                'infoExternal_infoSysId' => $infoSysId,
                'infoExternal_officeId' => $externalUser['externalUserId'],
            ]);
        }
    }

    public function addInformationSystem()
    {
        // {
        //   "master": {"userId": 1, "rank": 1, "isSmartCityInitiative": true, "systemName": "Information System Management System", "description": "Main system for managing all information systems", "mfoConnection": "MFO connection", "riseAgendaConnection": "Rise Agenda connection", "systemTypeId": 1, "officeId": 2, "systemStatusId": 1, "workEnvId": 1, "devStrategyId": 1, "hasPIA": false, "datePia": null, "initiationYear": "2024"},
        //   "details":{
        //               "systemproblems": [{"systemProblemName":"System Problem 1"}, {"systemProblemName":"System Problem 2"}, {"systemProblemName":"System Problem 3"}],
        //               "developers": [{"devId": 1}],
        //               "fundingSources": [{"fundingSourceId": 1}, {"fundingSourceId": 2}, {"fundingSourceId": 3}],
        //               "riseAgendas": [{"riseAgendaId": 1}, {"riseAgendaId": 2}, {"riseAgendaId": 3}],
        //               "internalUsers": [{"internalUserId": 1}, {"internalUserId": 2}, {"internalUserId": 3}],
        //               "externalUsers": [{"externalUserId": 1}, {"externalUserId": 2}, {"externalUserId": 3}]
        //             }
        // }
        try {
            $validated = $this->validate([
                'master.rank' => 'required|integer',
                'master.isSmartCityInitiative' => 'required|boolean',
                'master.mfoConnection' => 'required|string',
                'master.riseAgendaConnection' => 'required|string',
                'master.systemName' => 'required|string|unique:tblinformationsystems,infoSys_systemName',
                'master.description' => 'required|string',
                'master.systemTypeId' => 'required|integer',
                'master.officeId' => 'required|integer',
                'master.systemStatusId' => 'required|integer',
                'master.workEnvId' => 'required|integer',
                'master.devStrategyId' => 'required|integer',
                'master.userId' => 'required|integer',
                'master.hasPIA' => 'required|boolean',
                'master.datePia' => 'nullable|date',
                'master.initiationYear' => 'required|date_format:Y',
                'details.systemproblems' => 'required|array',
                'details.developers' => 'required|array',
                'details.fundingSources' => 'required|array',
                'details.riseAgendas' => 'required|array',
                'details.internalUsers' => 'required|array',
                'details.externalUsers' => 'required|array',
                'details.systemproblems.*.systemProblemName' => 'required|string',
                'details.developers.*.devId' => 'required|integer',
                'details.fundingSources.*.fundingSourceId' => 'required|integer',
                'details.riseAgendas.*.riseAgendaId' => 'required|integer',
                'details.internalUsers.*.internalUserId' => 'required|integer',
                'details.externalUsers.*.externalUserId' => 'required|integer',
            ]);

            DB::transaction(function () use ($validated) {
                $master = $validated['master'];
                $details = $validated['details'];

                // return response()->json(["master" => $master, "details" => $details, "systemProblems" => $systemProblems]);

                $informationSystem = InformationSystem::create([
                    'infoSys_rank' => $master['rank'],
                    'infoSys_isSmartCityInitiative' => $master['isSmartCityInitiative'],
                    'infoSys_systemName' => $master['systemName'],
                    'infoSys_description' => $master['description'],
                    'infoSys_mfoConnection' => $master['mfoConnection'],
                    'infoSys_riseAgendaConnection' => $master['riseAgendaConnection'],
                    'infoSys_systemTypeId' => $master['systemTypeId'],
                    'infoSys_officeId' => $master['officeId'],
                    'infoSys_systemStatusId' => $master['systemStatusId'],
                    'infoSys_workEnvId' => $master['workEnvId'],
                    'infoSys_devStrategyId' => $master['devStrategyId'],
                    'infoSys_userId' => $master['userId'],
                    'infoSys_hasPIA' => $master['hasPIA'],
                    'infoSys_datePia' => $master['datePia'],
                    'infoSys_initiationYear' => $master['initiationYear'],
                ]);
                $infoSysId = $informationSystem->infoSys_id;

                $this->saveSystemProblems($infoSysId, $details['systemproblems']);
                $this->saveDevelopers($infoSysId, $details['developers']);
                $this->saveFundingSources($infoSysId, $details['fundingSources']);
                $this->saveRiseAgendas($infoSysId, $details['riseAgendas']);
                $this->saveInternalUsers($infoSysId, $details['internalUsers']);
                $this->saveExternalUsers($infoSysId, $details['externalUsers']);
            });
            return response()->json(['message' => 'Success'], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateInformationSystem()
    {
        $validated = $this->validate([
            'rank' => 'required',
            'isSmartCityInitiative' => 'required',
            'systemName' => "required|unique:tblinformationsystems,infoSys_systemName,$this->selectedDataId,infoSys_id",
            'description' => 'required',
            'systemTypeId' => 'required',
            'officeId' => 'required',
            'systemStatusId' => 'required',
            'workEnvId' => 'required',
            'devStrategyId' => 'required',
            'hasPIA' => 'required',
            'datePia' => 'required|date',
            'initiationYear' => 'required|date_format:Y',
        ]);

        InformationSystem::where('infoSys_id', $this->selectedDataId)->update([
            'infoSys_rank' => $validated['rank'],
            'infoSys_isSmartCityInitiative' => $validated['isSmartCityInitiative'],
            'infoSys_systemName' => $validated['systemName'],
            'infoSys_description' => $validated['description'],
            'infoSys_systemTypeId' => $validated['systemTypeId'],
            'infoSys_officeId' => $validated['officeId'],
            'infoSys_systemStatusId' => $validated['systemStatusId'],
            'infoSys_workEnvId' => $validated['workEnvId'],
            'infoSys_devStrategyId' => $validated['devStrategyId'],
            'infoSys_hasPIA' => $validated['hasPIA'],
            'infoSys_datePia' => $validated['datePia'],
            'infoSys_initiationYear' => $validated['initiationYear'],
        ]);

        session()->flash('success', 'Information System updated successfully');
    }

    public function loadData($selectedDataId)
    {
        $data = Role::find($selectedDataId);

        if (!$data) {
            return;
        }

        $this->selectedDataId = $data->role_id;
        $this->roleName = $data->role_name;
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
                <h5 class="fw-semibold mb-1">Create Role</h5>
                <small class="text-muted">Fill in the details to add a new role.</small>
            @else
                <h5 class="fw-semibold mb-1">Edit Role</h5>
                <small class="text-muted">Provide the details to edit this role.</small>
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
        <form wire:submit="{{ $isAddData ? 'addRole' : 'updateRole' }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Role Name *</label>
                <input wire:model="roleName" name="roleName" type="text" class="form-control">
                @error('roleName')
                    <div class="mt-1" style="color: #f87171; font-size: 0.78rem;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target={{ $isAddData ? 'addRole' : 'updateRole' }}>
                        {{ $isAddData ? 'Create' : 'Update' }} role
                    </span>
                    <span wire:loading wire:target={{ $isAddData ? 'addRole' : 'updateRole' }}>
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>
