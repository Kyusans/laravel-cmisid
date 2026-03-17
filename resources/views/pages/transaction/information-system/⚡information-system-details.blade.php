<?php

use Livewire\Component;

new class extends Component {
    public $data = null;

    public function mount($data)
    {
        $this->data = $data;
    }
};
?>

<div class="info-sys-detail">

    {{-- Header --}}
    <div class="detail-header mb-4">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="rank-badge">#{{ $this->data->infoSys_rank }}</span>
                    @if($this->data->infoSys_isSmartCityInitiative)
                        <span class="status-badge badge-smart">Smart City Initiative</span>
                    @endif
                    <span class="status-badge badge-status">{{ $this->data->systemStatus->sysStatus_name }}</span>
                </div>
                <h4 class="fw-semibold mb-1 detail-title">{{ $this->data->infoSys_systemName }}</h4>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ $this->data->infoSys_description }}</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm">Edit</button>
                <button class="btn btn-primary btn-sm">View Report</button>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="row g-3">

        {{-- Left Column --}}
        <div class="col-lg-8 d-flex flex-column gap-3">

            {{-- General Information --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">General Information</span>
                </div>
                <div class="detail-card-body">
                    <div class="row g-0">
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">System Type</span>
                                <span class="info-value">{{ $this->data->systemType->systemType_name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">Office</span>
                                <span class="info-value">{{ $this->data->office->office_name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">Work Environment</span>
                                <span class="info-value">{{ $this->data->workEnvironment->workEnv_name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">Development Strategy</span>
                                <span class="info-value">{{ $this->data->developmentStrategy->devStrategy_name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">Initiation Year</span>
                                <span class="info-value">{{ $this->data->infoSys_initiationYear }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row">
                                <span class="info-label">System Status</span>
                                <span class="info-value">{{ $this->data->systemStatus->sysStatus_name }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row border-bottom-0">
                                <span class="info-label">MFO Connection</span>
                                <span class="info-value">{{ $this->data->infoSys_mfoConnection ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row border-bottom-0">
                                <span class="info-label">RISE Agenda Connection</span>
                                <span class="info-value">{{ $this->data->infoSys_riseAgendaConnection ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Privacy Impact Assessment --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Privacy Impact Assessment</span>
                </div>
                <div class="detail-card-body">
                    <div class="row g-0">
                        <div class="col-sm-6">
                            <div class="info-row border-bottom-0">
                                <span class="info-label">Has PIA</span>
                                @if($this->data->infoSys_hasPIA)
                                    <span class="status-badge badge-smart">Yes</span>
                                @else
                                    <span class="status-badge badge-muted">No</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row border-bottom-0">
                                <span class="info-label">PIA Date</span>
                                <span class="info-value">{{ $this->data->infoSys_datePia ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- System Problems --}}
            @if(count($this->data->systemProblems) > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">System Problems</span>
                    <span class="item-count">{{ count($this->data->systemProblems) }}</span>
                </div>
                <div class="detail-card-body p-0">
                    <ul class="problem-list">
                        @foreach($this->data->systemProblems as $i => $problem)
                        <li class="problem-item {{ $loop->last ? 'last' : '' }}">
                            <span class="problem-index">{{ $i + 1 }}</span>
                            <span class="problem-text">{{ $problem['sysprob_problem'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>

        {{-- Right Column --}}
        <div class="col-lg-4 d-flex flex-column gap-3">

            {{-- Managed By --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Managed By</span>
                </div>
                <div class="detail-card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar">
                            {{ strtoupper(substr($this->data->user->user_firstName, 0, 1)) }}{{ strtoupper(substr($this->data->user->user_lastName, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-medium" style="font-size: 0.875rem;">
                                {{ $this->data->user->user_firstName }} {{ $this->data->user->user_lastName }}
                            </div>
                            <div class="text-muted" style="font-size: 0.78rem;">{{ $this->data->user->user_email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Users</span>
                </div>
                <div class="detail-card-body p-0">
                    <div class="user-section">
                        <div class="user-section-label">Internal</div>
                        <div class="user-section-count">{{ count($this->data->infoSysInternalUsers) }} office(s)</div>
                    </div>
                    <div class="divider"></div>
                    <div class="user-section">
                        <div class="user-section-label">External</div>
                        <div class="user-section-count">{{ count($this->data->infoSysExternalUsers) }} office(s)</div>
                    </div>
                </div>
            </div>

            {{-- Funding Sources --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Funding Sources</span>
                    <span class="item-count">{{ count($this->data->infoSysFundingSources) }}</span>
                </div>
                <div class="detail-card-body">
                    @forelse($this->data->infoSysRiseAgendas as $fund)
                    <div class="tag-pill">Funding #{{ $fund['infoFund_fundingId'] }}</div>
                    @empty
                    <span class="text-muted" style="font-size: 0.8rem;">No funding sources</span>
                    @endforelse
                </div>
            </div>

            {{-- RISE Agendas --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">RISE Agendas</span>
                    <span class="item-count">{{ count($this->data->infoSysRiseAgendas) }}</span>
                </div>
                <div class="detail-card-body">
                    @forelse($this->data->infoSysRiseAgendas as $agenda)
                    <div class="tag-pill">{{ $agenda['infoAgenda_'] }}</div>
                    @empty
                    <span class="text-muted" style="font-size: 0.8rem;">No agendas linked</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

</div>