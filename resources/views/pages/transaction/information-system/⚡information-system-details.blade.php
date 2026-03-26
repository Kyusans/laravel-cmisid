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

    <div class="isd-header">
        <div class="isd-header-left">
            <div class="isd-badges">
                <span class="rank-badge">#{{ $this->data->infoSys_rank }}</span>
                @if($this->data->infoSys_isSmartCityInitiative)
                    <span class="status-badge badge-smart">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="5,1 6.2,3.8 9,4.1 7,6 7.6,9 5,7.5 2.4,9 3,6 1,4.1 3.8,3.8"/></svg>
                        Smart City Initiative
                    </span>
                @endif
                <span class="status-badge badge-status">{{ $this->data->systemStatus->sysStatus_name }}</span>
            </div>
            <h4 class="isd-title">{{ $this->data->infoSys_systemName }}</h4>
            <p class="isd-description">{{ $this->data->infoSys_description }}</p>
        </div>
        <div class="isd-header-actions">
            {{-- <button class="btn btn-outline-secondary btn-sm">Edit</button> --}}
            {{-- <button class="btn btn-primary btn-sm">View Report</button> --}}
        </div>
    </div>

    <div class="row g-3 mt-0">

        <div class="col-lg-8 d-flex flex-column gap-3">

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">General Information</span>
                </div>
                <div class="p-0">
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
                            <div class="info-row info-row-last">
                                <span class="info-label">MFO Connection</span>
                                <span class="info-value">{{ $this->data->infoSys_mfoConnection ?: '—' }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row info-row-last">
                                <span class="info-label">RISE Agenda Connection</span>
                                <span class="info-value">{{ $this->data->infoSys_riseAgendaConnection ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Privacy Impact Assessment</span>
                    @if($this->data->infoSys_hasPIA)
                        <span class="status-badge badge-smart">PIA Completed</span>
                    @else
                        <span class="status-badge badge-muted">No PIA</span>
                    @endif
                </div>
                <div class="p-0">
                    <div class="row g-0">
                        <div class="col-sm-6">
                            <div class="info-row info-row-last">
                                <span class="info-label">Has PIA</span>
                                @if($this->data->infoSys_hasPIA)
                                    <span class="status-badge badge-smart" style="width:fit-content;">Yes</span>
                                @else
                                    <span class="status-badge badge-muted" style="width:fit-content;">No</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="info-row info-row-last">
                                <span class="info-label">PIA Date</span>
                                <span class="info-value">{{ $this->data->infoSys_datePia ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- System Problems --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">System Problems</span>
                    <span class="item-count">{{ $this->data->systemProblems->count() }}</span>
                </div>
                <div class="p-0">
                    @forelse($this->data->systemProblems as $i => $problem)
                        <div class="list-row {{ $loop->last ? 'list-row-last' : '' }}">
                            <span class="list-index">{{ $i + 1 }}</span>
                            <span class="list-text">{{ $problem->sysprob_problem }}</span>
                        </div>
                    @empty
                        <div class="empty-state">No problems recorded.</div>
                    @endforelse
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Developers</span>
                    <span class="item-count">{{ $this->data->infoSysDevelopers->count() }}</span>
                </div>
                <div class="p-0">
                    @forelse($this->data->infoSysDevelopers as $row)
                        <div class="person-row {{ $loop->last ? 'list-row-last' : '' }}">
                            <div class="person-avatar">
                                {{ strtoupper(substr($row->developer->dev_firstName, 0, 1)) }}{{ strtoupper(substr($row->developer->dev_lastName, 0, 1)) }}
                            </div>
                            <div>
                                <div class="person-name">{{ $row->developer->dev_firstName }} {{ $row->developer->dev_lastName }}</div>
                                <div class="person-sub">{{ $row->developer->office->office_name }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">No developers assigned.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="col-lg-4 d-flex flex-column gap-3">

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Added By</span>
                </div>
                <div class="detail-card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="person-avatar person-avatar-lg">
                            {{ strtoupper(substr($this->data->user->user_firstName, 0, 1)) }}{{ strtoupper(substr($this->data->user->user_lastName, 0, 1)) }}
                        </div>
                        <div>
                            <div class="person-name">
                                {{ $this->data->user->user_firstName }} {{ $this->data->user->user_lastName }}
                            </div>
                            <div class="person-sub">{{ $this->data->user->user_email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Internal Users --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Internal Users</span>
                    <span class="item-count">{{ $this->data->infoSysInternalUsers->count() }}</span>
                </div>
                <div class="p-0">
                    @forelse($this->data->infoSysInternalUsers as $row)
                        {{-- relation name from JSON is "office" on InfoSysInternalUser --}}
                        <div class="office-row {{ $loop->last ? 'list-row-last' : '' }}">
                            <span class="office-dot"></span>
                            <span class="office-name">{{ $row->office->office_name }}</span>
                        </div>
                    @empty
                        <div class="empty-state">No internal users.</div>
                    @endforelse
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">External Users</span>
                    <span class="item-count">{{ $this->data->infoSysExternalUsers->count() }}</span>
                </div>
                <div class="p-0">
                    @forelse($this->data->infoSysExternalUsers as $row)
                        <div class="office-row {{ $loop->last ? 'list-row-last' : '' }}">
                            <span class="office-dot office-dot-ext"></span>
                            <span class="office-name">{{ $row->office->office_name }}</span>
                        </div>
                    @empty
                        <div class="empty-state">No external users.</div>
                    @endforelse
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">Funding Sources</span>
                    <span class="item-count">{{ $this->data->infoSysFundingSources->count() }}</span>
                </div>
                <div class="detail-card-body">
                    @forelse($this->data->infoSysFundingSources as $row)
                        <span class="tag-pill">{{ $row->fundingSource->funding_name }}</span>
                    @empty
                        <span class="empty-state-inline">No funding sources.</span>
                    @endforelse
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header">
                    <span class="detail-card-title">RISE Agendas</span>
                    <span class="item-count">{{ $this->data->infoSysRiseAgendas->count() }}</span>
                </div>
                <div class="detail-card-body">
                    @forelse($this->data->infoSysRiseAgendas as $row)
                        <span class="tag-pill">{{ $row->riseAgenda->riseAgenda_name }}</span>
                    @empty
                        <span class="empty-state-inline">No agendas linked.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>