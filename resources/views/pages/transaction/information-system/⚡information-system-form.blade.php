<?php

use Livewire\Component;
use App\Models\Transaction\InformationSystem;
use App\Models\Transaction\InfoSysDeveloper;
use App\Models\Transaction\InfoSysExternalUser;
use App\Models\Transaction\InfoSysFunding;
use App\Models\Transaction\InfoSysInternalUser;
use App\Models\Transaction\InfoSysRiseAgenda;
use App\Models\Transaction\SystemProblem;
use App\Models\SystemType;
use App\Models\Office;
use App\Models\SystemStatus;
use App\Models\WorkingEnvironment;
use App\Models\DevelopmentStrategy;
use App\Models\Developer;
use App\Models\FundingSource;
use App\Models\RiseAgenda;
use App\Models\User;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public bool $isAddData;
    public bool $isLoading = false;
    public $selectedDataId;

    public $rank = '';
    public $systemName = '';
    public $description = '';
    public $isSmartCityInitiative = '';
    public $mfoConnection = '';
    public $riseAgendaConnection = '';
    public $systemTypeId = '';
    public $officeId = '';
    public $systemStatusId = '';
    public $workEnvId = '';
    public $devStrategyId = '';
    public $userId = '';
    public $hasPIA = '';
    public $datePia = '';
    public $initiationYear = '';

    public array $systemProblems = [];
    public array $developers = [];
    public array $fundingSources = [];
    public array $riseAgendas = [];
    public array $internalUsers = [];
    public array $externalUsers = [];

    public function addSystemProblem()
    {
        $this->systemProblems[] = ['systemProblemName' => ''];
    }
    public function removeSystemProblem(int $i)
    {
        array_splice($this->systemProblems, $i, 1);
    }

    public function addDeveloper()
    {
        $this->developers[] = ['devId' => ''];
    }

    public function removeDeveloper(int $i)
    {
        array_splice($this->developers, $i, 1);
    }

    public function addFundingSource()
    {
        $this->fundingSources[] = ['fundingSourceId' => ''];
    }
    public function removeFundingSource(int $i)
    {
        array_splice($this->fundingSources, $i, 1);
    }

    public function addRiseAgenda()
    {
        $this->riseAgendas[] = ['riseAgendaId' => ''];
    }
    public function removeRiseAgenda(int $i)
    {
        array_splice($this->riseAgendas, $i, 1);
    }

    public function addInternalUser()
    {
        $this->internalUsers[] = ['internalUserId' => ''];
    }
    public function removeInternalUser(int $i)
    {
        array_splice($this->internalUsers, $i, 1);
    }

    public function addExternalUser()
    {
        $this->externalUsers[] = ['externalUserId' => ''];
    }
    public function removeExternalUser(int $i)
    {
        array_splice($this->externalUsers, $i, 1);
    }

    private function saveSystemProblems($id)
    {
        foreach ($this->systemProblems as $row) {
            SystemProblem::create(['sysprob_infoSysId' => $id, 'sysprob_problem' => $row['systemProblemName']]);
        }
    }
    private function saveDevelopers($id)
    {
        foreach ($this->developers as $row) {
            InfoSysDeveloper::create(['infoDev_infoSysId' => $id, 'infoDev_devId' => $row['devId']]);
        }
    }
    private function saveFundingSources($id)
    {
        foreach ($this->fundingSources as $row) {
            InfoSysFunding::create(['infoFund_infoSysId' => $id, 'infoFund_fundingId' => $row['fundingSourceId']]);
        }
    }
    private function saveRiseAgendas($id)
    {
        foreach ($this->riseAgendas as $row) {
            InfoSysRiseAgenda::create(['infoAgenda_infoSysId' => $id, 'infoAgenda_riseAgendaId' => $row['riseAgendaId']]);
        }
    }
    private function saveInternalUsers($id)
    {
        foreach ($this->internalUsers as $row) {
            InfoSysInternalUser::create(['infoInternal_infoSysId' => $id, 'infoInternal_officeId' => $row['internalUserId']]);
        }
    }
    private function saveExternalUsers($id)
    {
        foreach ($this->externalUsers as $row) {
            InfoSysExternalUser::create(['infoExternal_infoSysId' => $id, 'infoExternal_officeId' => $row['externalUserId']]);
        }
    }

    public function toggleSmartCity()
    {
        $this->isSmartCityInitiative = $this->isSmartCityInitiative === '1' ? '0' : '1';
    }

    public function toggleHasPIA()
    {
        $this->hasPIA = $this->hasPIA === '1' ? '0' : '1';
    }

    private function rules(): array
    {
        $unique = $this->isAddData ? 'unique:tblinformationsystems,infoSys_systemName' : "unique:tblinformationsystems,infoSys_systemName,{$this->selectedDataId},infoSys_id";
        return [
            'rank' => 'required|integer|min:1',
            'isSmartCityInitiative' => 'required|in:0,1',
            'mfoConnection' => 'required|string',
            'riseAgendaConnection' => 'required|string',
            'systemName' => "required|string|{$unique}",
            'description' => 'required|string',
            'systemTypeId' => 'required|integer',
            'officeId' => 'required|integer',
            'systemStatusId' => 'required|integer',
            'workEnvId' => 'required|integer',
            'devStrategyId' => 'required|integer',
            'userId' => 'required|integer',
            'hasPIA' => 'required|in:0,1',
            'datePia' => 'nullable|date',
            'initiationYear' => 'required|digits:4',
            'systemProblems' => 'nullable|array',
            'systemProblems.*.systemProblemName' => 'required|string',
            'developers' => 'required|array|min:1',
            'developers.*.devId' => 'required|integer|distinct',
            'fundingSources' => 'required|array|min:1',
            'fundingSources.*.fundingSourceId' => 'required|integer',
            'riseAgendas' => 'required|array|min:1',
            'riseAgendas.*.riseAgendaId' => 'required|integer',
            'internalUsers' => 'required|array|min:1',
            'internalUsers.*.internalUserId' => 'required|integer',
            'externalUsers' => 'nullable|array',
            'externalUsers.*.externalUserId' => 'required|integer',
        ];
    }

    protected function messages(): array
    {
        return [
            'developers.required' => 'At least one developer is required.',
            'developers.min' => 'At least one developer is required.',
            'developers.*.devId.required' => 'Please select a developer on row :position.',
            'developers.*.devId.distinct' => 'Developer on row :position is already added.',
            'developers.*.devId.integer' => 'Invalid developer selected on row :position.',

            'fundingSources.required' => 'At least one funding source is required.',
            'fundingSources.min' => 'At least one funding source is required.',
            'fundingSources.*.fundingSourceId.required' => 'Please select a funding source on row :position.',

            'riseAgendas.required' => 'At least one RISE agenda is required.',
            'riseAgendas.min' => 'At least one RISE agenda is required.',
            'riseAgendas.*.riseAgendaId.required' => 'Please select a RISE agenda on row :position.',

            'internalUsers.required' => 'At least one internal user office is required.',
            'internalUsers.min' => 'At least one internal user office is required.',
            'internalUsers.*.internalUserId.required' => 'Please select an office on row :position.',

            'externalUsers.*.externalUserId.required' => 'Please select an office on row :position.',

            'systemProblems.*.systemProblemName.required' => 'Problem description on row :position cannot be empty.',

            'rank.required' => 'Rank is required.',
            'rank.integer' => 'Rank must be a number.',
            'rank.min' => 'Rank must be at least 1.',
            'systemName.required' => 'System name is required.',
            'systemName.unique' => 'This system name is already taken.',
            'description.required' => 'Description is required.',
            'systemTypeId.required' => 'System type is required.',
            'officeId.required' => 'Office is required.',
            'systemStatusId.required' => 'System status is required.',
            'workEnvId.required' => 'Working environment is required.',
            'devStrategyId.required' => 'Development strategy is required.',
            'hasPIA.required' => 'Please indicate if this system has a PIA.',
            'isSmartCityInitiative.required' => 'Please indicate if this is a Smart City Initiative.',
            'mfoConnection.required' => 'MFO connection is required.',
            'riseAgendaConnection.required' => 'RISE Agenda connection is required.',
            'initiationYear.required' => 'Initiation year is required.',
            'initiationYear.digits' => 'Initiation year must be a 4-digit year.',
        ];
    }

    public function addInformationSystem()
    {
        $this->validate($this->rules());
        $this->isLoading = true;
        sleep(2);
        try {
            DB::transaction(function () {
                $is = InformationSystem::create([
                    'infoSys_rank' => $this->rank,
                    'infoSys_isSmartCityInitiative' => $this->isSmartCityInitiative,
                    'infoSys_systemName' => $this->systemName,
                    'infoSys_description' => $this->description,
                    'infoSys_mfoConnection' => $this->mfoConnection,
                    'infoSys_riseAgendaConnection' => $this->riseAgendaConnection,
                    'infoSys_systemTypeId' => $this->systemTypeId,
                    'infoSys_officeId' => $this->officeId,
                    'infoSys_systemStatusId' => $this->systemStatusId,
                    'infoSys_workEnvId' => $this->workEnvId,
                    'infoSys_devStrategyId' => $this->devStrategyId,
                    'infoSys_userId' => $this->userId,
                    'infoSys_hasPIA' => $this->hasPIA,
                    'infoSys_datePia' => $this->datePia ?: null,
                    'infoSys_initiationYear' => $this->initiationYear,
                ]);
                $id = $is->infoSys_id;
                $this->saveSystemProblems($id);
                $this->saveDevelopers($id);
                $this->saveFundingSources($id);
                $this->saveRiseAgendas($id);
                $this->saveInternalUsers($id);
                $this->saveExternalUsers($id);
            });

            $this->dispatch('toast', type: 'success', message: 'Information System created successfully.');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function updateInformationSystem()
    {
        $this->validate($this->rules());
        $this->isLoading = true;
        try {
            DB::transaction(function () {
                InformationSystem::where('infoSys_id', $this->selectedDataId)->update([
                    'infoSys_rank' => $this->rank,
                    'infoSys_isSmartCityInitiative' => $this->isSmartCityInitiative,
                    'infoSys_systemName' => $this->systemName,
                    'infoSys_description' => $this->description,
                    'infoSys_mfoConnection' => $this->mfoConnection,
                    'infoSys_riseAgendaConnection' => $this->riseAgendaConnection,
                    'infoSys_systemTypeId' => $this->systemTypeId,
                    'infoSys_officeId' => $this->officeId,
                    'infoSys_systemStatusId' => $this->systemStatusId,
                    'infoSys_workEnvId' => $this->workEnvId,
                    'infoSys_devStrategyId' => $this->devStrategyId,
                    'infoSys_userId' => $this->userId,
                    'infoSys_hasPIA' => $this->hasPIA,
                    'infoSys_datePia' => $this->datePia ?: null,
                    'infoSys_initiationYear' => $this->initiationYear,
                ]);

                SystemProblem::where('sysprob_infoSysId', $this->selectedDataId)->delete();
                InfoSysDeveloper::where('infoDev_infoSysId', $this->selectedDataId)->delete();
                InfoSysFunding::where('infoFund_infoSysId', $this->selectedDataId)->delete();
                InfoSysRiseAgenda::where('infoAgenda_infoSysId', $this->selectedDataId)->delete();
                InfoSysInternalUser::where('infoInternal_infoSysId', $this->selectedDataId)->delete();
                InfoSysExternalUser::where('infoExternal_infoSysId', $this->selectedDataId)->delete();

                $this->saveSystemProblems($this->selectedDataId);
                $this->saveDevelopers($this->selectedDataId);
                $this->saveFundingSources($this->selectedDataId);
                $this->saveRiseAgendas($this->selectedDataId);
                $this->saveInternalUsers($this->selectedDataId);
                $this->saveExternalUsers($this->selectedDataId);
            });

            $this->dispatch('toast', type: 'success', message: 'Information System updated successfully.');
            $this->dispatch('goBack');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function loadData($id)
    {
        $is = InformationSystem::with(['systemProblems', 'infoSysDevelopers', 'infoSysFundingSources', 'infoSysRiseAgendas', 'infoSysInternalUsers', 'infoSysExternalUsers'])->find($id);

        if (!$is) {
            return;
        }

        $this->selectedDataId = $is->infoSys_id;
        $this->rank = $is->infoSys_rank;
        $this->systemName = $is->infoSys_systemName;
        $this->description = $is->infoSys_description;
        $this->isSmartCityInitiative = $is->infoSys_isSmartCityInitiative ? '1' : '0';
        $this->mfoConnection = $is->infoSys_mfoConnection;
        $this->riseAgendaConnection = $is->infoSys_riseAgendaConnection;
        $this->systemTypeId = $is->infoSys_systemTypeId;
        $this->officeId = $is->infoSys_officeId;
        $this->systemStatusId = $is->infoSys_systemStatusId;
        $this->workEnvId = $is->infoSys_workEnvId;
        $this->devStrategyId = $is->infoSys_devStrategyId;
        $this->userId = $is->infoSys_userId;
        $this->hasPIA = $is->infoSys_hasPIA ? '1' : '0';
        $this->datePia = $is->infoSys_datePia;
        $this->initiationYear = $is->infoSys_initiationYear;

        $this->systemProblems = $is->systemProblems->map(fn($r) => ['systemProblemName' => $r->sysprob_problem])->toArray();
        $this->developers = $is->infoSysDevelopers->map(fn($r) => ['devId' => $r->infoDev_devId])->toArray();
        $this->fundingSources = $is->infoSysFundingSources->map(fn($r) => ['fundingSourceId' => $r->infoFund_fundingId])->toArray();
        $this->riseAgendas = $is->infoSysRiseAgendas->map(fn($r) => ['riseAgendaId' => $r->infoAgenda_riseAgendaId])->toArray();
        $this->internalUsers = $is->infoSysInternalUsers->map(fn($r) => ['internalUserId' => $r->infoInternal_officeId])->toArray();
        $this->externalUsers = $is->infoSysExternalUsers->map(fn($r) => ['externalUserId' => $r->infoExternal_officeId])->toArray();
    }

    public function mount(bool $isAddData = true, $selectedDataId = null)
    {
        $this->userId = auth()->user()->user_id;
        $this->isAddData = $isAddData;
        $this->selectedDataId = $selectedDataId;

        if (!$isAddData && $selectedDataId) {
            $this->loadData($selectedDataId);
        }
    }

    public function render()
    {
        return $this->view([
            'systemTypes' => SystemType::orderBy('systemType_name')->get(),
            'offices' => Office::orderBy('office_name')->get(),
            'systemStatuses' => SystemStatus::orderBy('sysStatus_name')->get(),
            'workEnvs' => WorkingEnvironment::orderBy('workEnv_name')->get(),
            'devStrategies' => DevelopmentStrategy::orderBy('devStrategy_name')->get(),
            'developersList' => Developer::orderBy('dev_firstName')->get(),
            'fundingList' => FundingSource::orderBy('funding_name')->get(),
            'riseAgendaList' => RiseAgenda::orderBy('riseAgenda_name')->get(),
            'users' => User::orderBy('user_firstName')->get(),
        ]);
    }
};
?>

<div class="isf-root">

    <div class="isf-page-header">
        <div>
            <h1 class="isf-page-title">{{ $isAddData ? 'Add Information System' : 'Edit Information System' }}</h1>
            <p class="isf-page-sub">
                {{ $isAddData ? 'Register a new government information system.' : 'Update the details of this information system.' }}
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="isf-alert" id="isf-alert" x-data x-init="$nextTick(() => $el.scrollIntoView({ behavior: 'smooth', block: 'start' }))">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.8"
                class="flex-shrink-0 mt-1">
                <circle cx="7.5" cy="7.5" r="6.5" />
                <line x1="7.5" y1="4.5" x2="7.5" y2="7.5" />
                <line x1="7.5" y1="10" x2="7.5" y2="10.5" stroke-linecap="round"
                    stroke-width="2" />
            </svg>
            <div>
                <p style="font-size: 0.8rem; font-weight: 600; margin: 0 0 0.35rem;">Please resolve the following
                    issues:
                </p>
                <ul class="isf-alert-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form wire:submit="{{ $isAddData ? 'addInformationSystem' : 'updateInformationSystem' }}" class="isf-form">
        @csrf
        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">01</span>
                <h2 class="isf-section-title">Basic Information</h2>
                <p class="isf-section-desc">Core identity of this information system.</p>
            </div>
            <div class="isf-section-body">

                <div class="isf-field isf-field-full">
                    <label class="isf-label">System Name <span class="isf-req">*</span></label>
                    <input wire:model="systemName" type="text"
                        class="isf-input @error('systemName') is-invalid @enderror"
                        placeholder="e.g. Integrated Financial Management System">
                    @error('systemName')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field isf-field-full">
                    <label class="isf-label">Description <span class="isf-req">*</span></label>
                    <textarea wire:model="description" rows="3"
                        class="isf-input isf-textarea @error('description') is-invalid @enderror" placeholder="What does this system do?"></textarea>
                    @error('description')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Rank <span class="isf-req">*</span></label>
                    <input wire:model="rank" type="number" min="1"
                        class="isf-input @error('rank') is-invalid @enderror" placeholder="1">
                    @error('rank')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Initiation Year <span class="isf-req">*</span></label>
                    <input wire:model="initiationYear" type="number" min="1990" max="{{ date('Y') + 5 }}"
                        class="isf-input @error('initiationYear') is-invalid @enderror"
                        placeholder="{{ date('Y') }}">
                    @error('initiationYear')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>
        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">02</span>
                <h2 class="isf-section-title">Classification</h2>
                <p class="isf-section-desc">Categorize this system by type, office, and lifecycle state.</p>
            </div>
            <div class="isf-section-body">

                <div class="isf-field">
                    <label class="isf-label">Office <span class="isf-req">*</span></label>
                    <select wire:model="officeId" class="isf-select @error('officeId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($offices as $o)
                            <option value="{{ $o->office_id }}">{{ $o->office_name }}</option>
                        @endforeach
                    </select>
                    @error('officeId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">System Type <span class="isf-req">*</span></label>
                    <select wire:model="systemTypeId" class="isf-select @error('systemTypeId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($systemTypes as $t)
                            <option value="{{ $t->systemType_id }}">{{ $t->systemType_name }}</option>
                        @endforeach
                    </select>
                    @error('systemTypeId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">System Status <span class="isf-req">*</span></label>
                    <select wire:model="systemStatusId"
                        class="isf-select @error('systemStatusId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($systemStatuses as $s)
                            <option value="{{ $s->sysStatus_id }}">{{ $s->sysStatus_name }}</option>
                        @endforeach
                    </select>
                    @error('systemStatusId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Working Environment <span class="isf-req">*</span></label>
                    <select wire:model="workEnvId" class="isf-select @error('workEnvId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($workEnvs as $e)
                            <option value="{{ $e->workEnv_id }}">{{ $e->workEnv_name }}</option>
                        @endforeach
                    </select>
                    @error('workEnvId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Development Strategy <span class="isf-req">*</span></label>
                    <select wire:model="devStrategyId"
                        class="isf-select @error('devStrategyId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($devStrategies as $d)
                            <option value="{{ $d->devStrategy_id }}">{{ $d->devStrategy_name }}</option>
                        @endforeach
                    </select>
                    @error('devStrategyId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <div class="isf-field">
                    <label class="isf-label">Assigned User <span class="isf-req">*</span></label>
                    <select wire:model="userId" class="isf-select @error('userId') is-invalid @enderror">
                        <option value="">Select</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->user_id }}">{{ $u->user_firstName }} {{ $u->user_lastName }}
                            </option>
                        @endforeach
                    </select>
                    @error('userId')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div> --}}

            </div>
        </div>

        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">03</span>
                <h2 class="isf-section-title">Connections & Flags</h2>
                <p class="isf-section-desc">Link to MFO, RISE Agenda, and set system flags.</p>
            </div>
            <div class="isf-section-body">

                <div class="isf-field">
                    <label class="isf-label">MFO Connection <span class="isf-req">*</span></label>
                    <input wire:model="mfoConnection" type="text"
                        class="isf-input @error('mfoConnection') is-invalid @enderror"
                        placeholder="Describe MFO connection…">
                    @error('mfoConnection')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">RISE Agenda Connection <span class="isf-req">*</span></label>
                    <input wire:model="riseAgendaConnection" type="text"
                        class="isf-input @error('riseAgendaConnection') is-invalid @enderror"
                        placeholder="Describe RISE Agenda connection…">
                    @error('riseAgendaConnection')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Smart City Initiative <span class="isf-req">*</span></label>
                   <label class="isf-switch">
                        <input type="checkbox"
                            wire:click="toggleSmartCity"
                            {{ $isSmartCityInitiative === '1' ? 'checked' : '' }}>
                        <span class="isf-switch-track">
                            <span class="isf-switch-thumb"></span>
                        </span>
                    </label>
                    @error('isSmartCityInitiative')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field">
                    <label class="isf-label">Has PIA <span class="isf-req">*</span></label>
                    <label class="isf-switch" x-data="{ busy: false }">
                        <input type="checkbox" x-bind:disabled="busy" wire:click="toggleHasPIA"
                            x-on:click="busy = true; setTimeout(() => busy = false, 750)"
                            {{ $hasPIA === '1' ? 'checked' : '0' }}>
                        <span class="isf-switch-track" x-bind:style="busy ? 'opacity:0.6;' : ''">
                            <span class="isf-switch-thumb"></span>
                        </span>
                    </label>
                    @error('hasPIA')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="isf-field" x-data x-show="$wire.hasPIA === '1'" x-transition style="display: none;">
                    <label class="isf-label">PIA Date</label>
                    <input wire:model="datePia" type="date"
                        class="isf-input @error('datePia') is-invalid @enderror">
                    @error('datePia')
                        <p class="isf-error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">04</span>
                <h2 class="isf-section-title">System Problems</h2>
                <p class="isf-section-desc">List known problems or limitations of this system.</p>
            </div>
            <div class="isf-section-body isf-section-body-full">

                @foreach ($systemProblems as $i => $row)
                    <div class="isf-list-row" wire:key="sp-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <input wire:model="systemProblems.{{ $i }}.systemProblemName" type="text"
                            class="isf-input isf-input-flex @error('systemProblems.' . $i . '.systemProblemName') is-invalid @enderror"
                            placeholder="Describe problem…">
                        <button type="button" wire:click="removeSystemProblem({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                        @error('systemProblems.' . $i . '.systemProblemName')
                            <p class="isf-error isf-error-row">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <button type="button" wire:click="addSystemProblem" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add Problem
                </button>
                @error('systemProblems')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror

            </div>
        </div>

        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">05</span>
                <h2 class="isf-section-title">Developers</h2>
                <p class="isf-section-desc">Developers who built or maintain this system.</p>
            </div>
            <div class="isf-section-body isf-section-body-full">

                @foreach ($developers as $i => $row)
                    <div class="isf-list-row" wire:key="dev-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <select wire:model="developers.{{ $i }}.devId"
                            class="isf-select isf-input-flex @error('developers.' . $i . '.devId') is-invalid @enderror">
                            <option value="">Select developer</option>
                            @foreach ($developersList as $d)
                                <option value="{{ $d->dev_id }}">{{ $d->dev_firstName }} {{ $d->dev_lastName }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeDeveloper({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addDeveloper" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add Developer
                </button>
                @error('developers')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">06</span>
                <h2 class="isf-section-title">Funding Sources</h2>
                <p class="isf-section-desc">Where does this system get its funding?</p>
            </div>
            <div class="isf-section-body isf-section-body-full">

                @foreach ($fundingSources as $i => $row)
                    <div class="isf-list-row" wire:key="fund-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <select wire:model="fundingSources.{{ $i }}.fundingSourceId"
                            class="isf-select isf-input-flex @error('fundingSources.' . $i . '.fundingSourceId') is-invalid @enderror">
                            <option value="">Select funding source</option>
                            @foreach ($fundingList as $f)
                                <option value="{{ $f->funding_id }}">{{ $f->funding_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeFundingSource({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addFundingSource" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add Funding Source
                </button>
                @error('fundingSources')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror

            </div>
        </div>
        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">07</span>
                <h2 class="isf-section-title">RISE Agendas</h2>
                <p class="isf-section-desc">RISE agenda items this system supports.</p>
            </div>
            <div class="isf-section-body isf-section-body-full">

                @foreach ($riseAgendas as $i => $row)
                    <div class="isf-list-row" wire:key="rise-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <select wire:model="riseAgendas.{{ $i }}.riseAgendaId"
                            class="isf-select isf-input-flex @error('riseAgendas.' . $i . '.riseAgendaId') is-invalid @enderror">
                            <option value="">Select RISE agenda</option>
                            @foreach ($riseAgendaList as $a)
                                <option value="{{ $a->riseAgenda_id }}">{{ $a->riseAgenda_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeRiseAgenda({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addRiseAgenda" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add RISE Agenda
                </button>
                @error('riseAgendas')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror

            </div>
        </div>

        <div class="isf-section">
            <div class="isf-section-aside">
                <span class="isf-step">08</span>
                <h2 class="isf-section-title">User Offices</h2>
                <p class="isf-section-desc">Offices that use this system, both internally and externally.</p>
            </div>
            <div class="isf-section-body isf-section-body-full">

                <p class="isf-sub-label">
                    <span class="isf-dot isf-dot-green"></span>
                    Internal Users
                </p>

                @foreach ($internalUsers as $i => $row)
                    <div class="isf-list-row" wire:key="int-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <select wire:model="internalUsers.{{ $i }}.internalUserId"
                            class="isf-select isf-input-flex @error('internalUsers.' . $i . '.internalUserId') is-invalid @enderror">
                            <option value="">Select office</option>
                            @foreach ($offices as $o)
                                <option value="{{ $o->office_id }}">{{ $o->office_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeInternalUser({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addInternalUser" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add Internal Office
                </button>
                @error('internalUsers')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror

                <div class="isf-divider"></div>

                <p class="isf-sub-label">
                    <span class="isf-dot isf-dot-blue"></span>
                    External Users
                </p>

                @foreach ($externalUsers as $i => $row)
                    <div class="isf-list-row" wire:key="ext-{{ $i }}">
                        <span class="isf-list-idx">{{ $i + 1 }}</span>
                        <select wire:model="externalUsers.{{ $i }}.externalUserId"
                            class="isf-select isf-input-flex @error('externalUsers.' . $i . '.externalUserId') is-invalid @enderror">
                            <option value="">Select office</option>
                            @foreach ($offices as $o)
                                <option value="{{ $o->office_id }}">{{ $o->office_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" wire:click="removeExternalUser({{ $i }})"
                            class="isf-remove-btn" title="Remove">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                                <line x1="2" y1="2" x2="11" y2="11" />
                                <line x1="11" y1="2" x2="2" y2="11" />
                            </svg>
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addExternalUser" class="isf-add-btn">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round">
                        <line x1="6.5" y1="1" x2="6.5" y2="12" />
                        <line x1="1" y1="6.5" x2="12" y2="6.5" />
                    </svg>
                    Add External Office
                </button>
                @error('externalUsers')
                    <p class="isf-error mt-1">{{ $message }}</p>
                @enderror

            </div>
        </div>

        <div class="isf-actions">
            <button type="button" wire:click="$dispatch('goBack')" class="isf-btn-cancel">Cancel</button>
            <button type="submit" class="isf-btn-submit" @disabled($isLoading)>
                {{ $isAddData ? 'Create Information System' : 'Save Changes' }}
            </button>
        </div>
    </form>
</div>
