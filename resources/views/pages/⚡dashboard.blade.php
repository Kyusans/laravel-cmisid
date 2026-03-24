<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Transaction\InformationSystem;
use App\Models\Office;
use App\Models\SystemStatus;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\StreamedResponse;

new class extends Component {
    public string $filterOffice = '';
    public string $filterStatus = '';
    public string $filterYear = '';
    public string $filterPia = '';

    public function resetFilters(): void
    {
        $this->filterOffice = '';
        $this->filterStatus = '';
        $this->filterYear = '';
        $this->filterPia = '';
    }

    protected function baseQuery()
    {
        $q = InformationSystem::query()->with([
            'office',
            'systemStatus',
            'systemType',
            'workEnvironment',
            'developmentStrategy',
            'infoSysRiseAgendas.riseAgenda.riseAgendaType',
            'infoSysDevelopers.developer',
            'infoSysFundingSources.fundingSource',
            'infoSysInternalUsers.office',
            'infoSysExternalUsers.office',
            'office.mfos',
            'office.ppas',
            'systemProblems',
            'infoSysDevelopers.developer',
        ]);

        if (Auth::user()->role->role_name === 'Office User') {
            $q->where('infoSys_officeId', Auth::user()->user_officeId);
        } elseif ($this->filterOffice) {
            $q->where('infoSys_officeId', $this->filterOffice);
        }

        if ($this->filterStatus)
            $q->where('infoSys_systemStatusId', $this->filterStatus);
        if ($this->filterYear)
            $q->where('infoSys_initiationYear', $this->filterYear);
        if ($this->filterPia !== '')
            $q->where('infoSys_hasPIA', (bool) $this->filterPia);

        return $q;
    }

    #[Computed]
    public function systems()
    {
        return $this->baseQuery()->orderBy('infoSys_rank')->get();
    }

    #[Computed]
    public function totalSystems(): int
    {
        return $this->baseQuery()->count();
    }

    #[Computed]
    public function totalPlanned(): int
    {
        return $this->baseQuery()
            ->whereHas('systemStatus', fn($q) => $q->where('sysStatus_name', 'like', '%Plan%'))
            ->count();
    }

    #[Computed]
    public function totalRunning(): int
    {
        return $this->baseQuery()
            ->whereHas('systemStatus', fn($q) => $q
                ->where('sysStatus_name', 'like', '%Running%')
                ->orWhere('sysStatus_name', 'like', '%Active%'))
            ->count();
    }

    #[Computed]
    public function totalWithPia(): int
    {
        return $this->baseQuery()->where('infoSys_hasPIA', true)->count();
    }

    #[Computed]
    public function isAdmin(): bool
    {
        return Auth::user()->role->role_name === 'System Admin';
    }

    #[Computed]
    public function offices()
    {
        return $this->isAdmin ? Office::orderBy('office_name')->get() : collect();
    }

    #[Computed]
    public function statuses()
    {
        return SystemStatus::orderBy('sysStatus_name')->get();
    }

    #[Computed]
    public function years()
    {
        return InformationSystem::selectRaw('DISTINCT infoSys_initiationYear as year')
            ->whereNotNull('infoSys_initiationYear')
            ->orderByDesc('year')
            ->pluck('year');
    }

    // ── helpers ──────────────────────────────────────────────
    protected function riseAgendas($sys): string
    {
        return $sys->infoSysRiseAgendas
            ->map(fn($r) => $r->riseAgenda?->riseAgenda_name)
            ->filter()->implode("\n") ?: '—';
    }

    protected function internalUsers($sys): string
    {
        return $sys->infoSysInternalUsers
            ->map(fn($u) => $u->office?->office_name)
            ->filter()->unique()->implode("\n") ?: '—';
    }

    protected function externalUsers($sys): string
    {
        return $sys->infoSysExternalUsers
            ->map(fn($u) => $u->office?->office_name)
            ->filter()->unique()->implode("\n") ?: '—';
    }

    protected function problems($sys): string
    {
        return $sys->systemProblems
            ->map(fn($p) => $p->sysprob_problem)
            ->filter()->implode("\n") ?: '—';
    }
    protected function fundingSources($sys): string
    {
        return $sys->infoSysFundingSources
            ->map(fn($f) => $f->fundingSource?->funding_name)
            ->filter()->implode("\n") ?: '—';
    }

    protected function mfos($sys): string
    {
        return $sys->office?->mfos
            ->map(fn($m) => $m->mfo_name)
            ->filter()
            ->implode("\n") ?: '—';
    }

    protected function ppas($sys): string
    {
        return $sys->office?->ppas
            ->map(fn($p) => $p->ppa_name)
            ->filter()
            ->implode("\n") ?: '—';
    }

    protected function riseAgendaTypes($sys): string
    {
        return $sys->infoSysRiseAgendas
            ->map(fn($r) => $r->riseAgenda?->riseAgendaType?->agendaType_name)
            ->filter()
            ->unique()
            ->implode("\n") ?: '—';
    }

    protected function developers($sys): string
    {
        return $sys->infoSysDevelopers
            ->map(fn($d) => $d->developer?->dev_lastName . ', ' . $d->developer?->dev_firstName . ' ' . $d->developer?->dev_middleName)
            ->filter()->implode("\n") ?: '—';
    }

    // ── Excel export ─────────────────────────────────────────
    public function exportExcel(): StreamedResponse
    {
        $systems = $this->baseQuery()->orderBy('infoSys_rank')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('IS Report');

        // Title
        $lastCol = 'U';
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'INFORMATION SYSTEM MANAGEMENT SYSTEM — REPORT');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 13],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', 'Generated: ' . now()->format('F d, Y  h:i A'));
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['argb' => 'FF71717A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(16);
        $sheet->getRowDimension(3)->setRowHeight(6);

        // Headers
        $headers = [
            'Rank',
            'Smart City?',
            'Name of Information System / Sub-System',
            'Description (if for enhancement please include components to be added)',
            'RISE Agenda',
            "",
            'Connection to RISE Agenda',
            'Type of System',
            'Status',
            'Initiation Year',
            'Development Strategy',
            'Working Environment',
            'Owner',
            'Internal Users',
            'External Users',
            'MFO',
            'PPA',
            'Issues / Problems',
            'How System Connects with MFO',
            'Sources of Funding',
            'Developers',
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '4', $h);
            $col++;
        }

        $sheet->getStyle("A4:{$lastCol}4")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 10],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF09090B']],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'wrapText' => true
            ],
        ]);
        $sheet->getRowDimension(4)->setRowHeight(30);

        // Data
        $row = 5;
        foreach ($systems as $sys) {
            $values = [
                $sys->infoSys_rank,
                $sys->infoSys_isSmartCityInitiative ? 'Yes' : 'No',
                $sys->infoSys_systemName,
                $sys->infoSys_description ?? '—',
                $this->riseAgendaTypes($sys),
                $this->riseAgendas($sys),
                $sys->infoSys_riseAgendaConnection ?? '—',
                $sys->systemType?->systemType_name ?? '—',
                $sys->systemStatus?->sysStatus_name ?? '—',
                $sys->infoSys_initiationYear ?? '—',
                $sys->developmentStrategy?->devStrategy_name ?? '—',
                $sys->workEnvironment?->workEnv_name ?? '—',
                $sys->office?->office_name ?? '—',
                $this->internalUsers($sys),
                $this->externalUsers($sys),
                $this->mfos($sys),
                $this->ppas($sys),
                $this->problems($sys),
                $sys->infoSys_mfoConnection ?? '—',
                $this->fundingSources($sys),
                $this->developers($sys),
            ];

            $col = 'A';
            foreach ($values as $val) {
                $sheet->setCellValue($col . $row, $val);
                $col++;
            }

            $fill = ($row % 2 === 0) ? 'FFF9F9F9' : 'FFFFFFFF';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $fill]],
                'font' => ['size' => 9],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(36);
            $row++;
        }

        // Borders
        $lastRow = $row - 1;
        if ($lastRow >= 4) {
            $sheet->getStyle("A4:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN)
                ->getColor()->setARGB('FFE4E4E7');
        }

        $widths = [
            'A' => 6,   // Rank
            'B' => 10,  // Smart City
            'C' => 38,  // Name
            'D' => 45,  // Description
            'E' => 25,  // Rise Type
            'F' => 30,  // Rise Agenda
            'G' => 40,  // Connection to Rise Agenda
            'H' => 18,  // Type
            'I' => 18,  // Status
            'J' => 12,  // Year
            'K' => 22,  // Dev Strategy
            'L' => 22,  // Work Env
            'M' => 28,  // Owner
            'N' => 30,  // Internal Users
            'O' => 30,  // External Users
            'P' => 30,  // MFO
            'Q' => 30,  // PPA
            'R' => 40,  // Problems
            'S' => 45,  // MFO Connection
            'T' => 45,  // Funding Sources
            'U' => 30,  // Developers
        ];

        foreach ($widths as $c => $w) {
            $sheet->getColumnDimension($c)->setWidth($w);
        }

        // ✅ Responsive last column
        $sheet->getColumnDimension('T')->setWidth(45);

        $sheet->freezePane('A5');

        $filename = 'is-report-' . now()->format('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
};
?>

<div class="isf-root">

    {{-- ── Page Header ──────────────────────────────────────── --}}
    <div class="isr-header">
        <div>
            <h1 class="isf-page-title" style="margin-bottom:4px;">Information Systems</h1>
            <p class="isf-page-sub">Overview of information systems across city government offices.</p>
        </div>
        <button wire:click="exportExcel" wire:loading.attr="disabled" wire:target="exportExcel" class="isf-btn-submit">
            <span wire:loading.remove wire:target="exportExcel" style="display:inline-flex;align-items:center;gap:6px;">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                Export to Excel
            </span>

            <span wire:loading.flex wire:target="exportExcel" style="display:none;align-items:center;gap:6px;">
                <span class="isf-spinner"></span>
                Exporting…
            </span>

        </button>
    </div>

    {{-- ── Summary Cards ────────────────────────────────────── --}}
    <div class="isr-cards">
        <div class="isr-card">
            <div class="isr-card-icon" style="color:#2563eb;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" />
                    <path d="M3 9h18M9 21V9" />
                </svg>
            </div>
            <div>
                <p class="isr-card-label">Total Systems</p>
                <p class="isr-card-value">{{ $this->totalSystems }}</p>
            </div>
        </div>
        <div class="isr-card">
            <div class="isr-card-icon" style="color:#d97706;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>
            <div>
                <p class="isr-card-label">In Planning</p>
                <p class="isr-card-value">{{ $this->totalPlanned }}</p>
            </div>
        </div>
        <div class="isr-card">
            <div class="isr-card-icon" style="color:#16a34a;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
            </div>
            <div>
                <p class="isr-card-label">Up &amp; Running</p>
                <p class="isr-card-value">{{ $this->totalRunning }}</p>
            </div>
        </div>
        <div class="isr-card">
            <div class="isr-card-icon" style="color:#7c3aed;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <polyline points="9 12 11 14 15 10" />
                </svg>
            </div>
            <div>
                <p class="isr-card-label">With PIA</p>
                <p class="isr-card-value">{{ $this->totalWithPia }}</p>
            </div>
        </div>
    </div>

    {{-- ── Filters ───────────────────────────────────────────── --}}
    <div class="isr-filters">
        <div class="isr-filters-row">

            @if($this->isAdmin)
                <div class="isf-field" style="flex:1;min-width:150px;">
                    <label class="isf-label">Office</label>
                    <select wire:model.live="filterOffice" class="isf-select">
                        <option value="">All Offices</option>
                        @foreach($this->offices as $office)
                            <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="isf-field" style="flex:1;min-width:140px;">
                <label class="isf-label">Status</label>
                <select wire:model.live="filterStatus" class="isf-select">
                    <option value="">All Statuses</option>
                    @foreach($this->statuses as $s)
                        <option value="{{ $s->sysStatus_id }}">{{ $s->sysStatus_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="isf-field" style="flex:1;min-width:110px;max-width:140px;">
                <label class="isf-label">Year</label>
                <select wire:model.live="filterYear" class="isf-select">
                    <option value="">All Years</option>
                    @foreach($this->years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div class="isf-field" style="flex:1;min-width:110px;max-width:140px;">
                <label class="isf-label">PIA</label>
                <select wire:model.live="filterPia" class="isf-select">
                    <option value="">All</option>
                    <option value="1">With PIA</option>
                    <option value="0">Without PIA</option>
                </select>
            </div>

            @if($filterOffice || $filterStatus || $filterYear || $filterPia !== '')
                <div class="isf-field" style="align-self:flex-end;flex-shrink:0;">
                    <button wire:click="resetFilters" class="isr-reset-btn">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Clear
                    </button>
                </div>
            @endif

        </div>
        <p class="isr-result-count">
            <span wire:loading.remove>{{ $this->systems->count() }}
                result{{ $this->systems->count() !== 1 ? 's' : '' }}</span>
            <span wire:loading class="isr-updating">Updating…</span>
        </p>
    </div>

    {{-- ── Table ────────────────────────────────────────────── --}}
    <div class="isr-table-wrap" wire:loading.class="isr-table-dim">

        <div wire:loading wire:target="filterOffice,filterStatus,filterYear,filterPia,resetFilters"
            class="isr-progress-bar"></div>

        @if($this->systems->isEmpty())
            <div class="empty-state" style="padding:3rem 1rem;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                    style="display:block;margin:0 auto 0.6rem;color:var(--text-muted);">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                No systems found matching the selected filters.
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="table" style="margin:0;min-width:1400px;">
                    <thead>
                        <tr>
                            <th style="width:42px;">Rank</th>
                            <th style="width:80px;">Smart City</th>
                            <th style="min-width:220px;">Name of Information System</th>
                            <th style="min-width:200px;">Description</th>
                            <th style="min-width:140px;">RISE Agenda</th>
                            <th style="min-width:160px;">RISE Agenda Connection</th>
                            <th style="min-width:120px;">Type</th>
                            <th style="min-width:120px;">Status</th>
                            <th style="width:72px;">Year</th>
                            <th style="min-width:130px;">Dev. Strategy</th>
                            <th style="min-width:120px;">Work Environment</th>
                            <th style="min-width:150px;">Owner</th>
                            <th style="min-width:150px;">Internal Users</th>
                            <th style="min-width:150px;">External Users</th>
                            <th style="min-width:140px;">MFO Connection</th>
                            <th style="min-width:120px;">Issues / Problems</th>
                            <th style="min-width:140px;">Funding Sources</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->systems as $sys)
                            @php
                                $sName = $sys->systemStatus?->sysStatus_name ?? '';
                                $isRun = str_contains(strtolower($sName), 'running')
                                    || str_contains(strtolower($sName), 'active');

                                $riseAgendas = $sys->infoSysRiseAgendas
                                    ->map(fn($r) => $r->riseAgenda?->riseAgenda_name)
                                    ->filter()->implode(', ') ?: '—';

                                $internalUsers = $sys->infoSysInternalUsers
                                    ->map(fn($u) => $u->office?->office_name)
                                    ->filter()->unique()->implode(', ') ?: '—';

                                $externalUsers = $sys->infoSysExternalUsers
                                    ->map(fn($u) => $u->office?->office_name)
                                    ->filter()->unique()->implode(', ') ?: '—';

                                $problems = $sys->systemProblems
                                    ->map(fn($p) => $p->sysprob_problem)
                                    ->filter()->implode('; ') ?: '—';

                                $fundings = $sys->infoSysFundingSources
                                    ->map(fn($f) => $f->fundingSource?->funding_name)
                                    ->filter()->implode(', ') ?: '—';
                            @endphp
                            <tr>
                                <td><span class="list-index">{{ $sys->infoSys_rank }}</span></td>
                                <td>
                                    @if($sys->infoSys_isSmartCityInitiative)
                                        <span class="status-badge badge-smart">
                                            <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2.5"
                                                viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                            Yes
                                        </span>
                                    @else
                                        <span class="status-badge badge-muted">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size:.84rem;font-weight:500;color:var(--text-primary);">
                                        {{ $sys->infoSys_systemName }}
                                    </div>
                                </td>
                                <td>
                                    <div
                                        style="font-size:.79rem;color:var(--text-secondary);max-width:220px;white-space:normal;line-height:1.4;">
                                        {{ $sys->infoSys_description ?? '—' }}
                                    </div>
                                </td>
                                <td style="font-size:.82rem;color:var(--text-secondary);">{{ $riseAgendas }}</td>
                                <td>
                                    <div
                                        style="font-size:.79rem;color:var(--text-secondary);max-width:180px;white-space:normal;line-height:1.4;">
                                        {{ $sys->infoSys_riseAgendaConnection ?? '—' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="tag-pill" style="margin:0;">
                                        {{ $sys->systemType?->systemType_name ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $isRun ? 'badge-smart' : 'badge-status' }}">
                                        <span
                                            style="width:5px;height:5px;border-radius:50%;background:currentColor;flex-shrink:0;display:inline-block;"></span>
                                        {{ $sName ?: '—' }}
                                    </span>
                                </td>
                                <td style="font-size:.82rem;color:var(--text-secondary);">
                                    {{ $sys->infoSys_initiationYear ?? '—' }}
                                </td>
                                <td style="font-size:.82rem;color:var(--text-secondary);">
                                    {{ $sys->developmentStrategy?->devStrategy_name ?? '—' }}
                                </td>
                                <td style="font-size:.82rem;color:var(--text-secondary);">
                                    {{ $sys->workEnvironment?->workEnv_name ?? '—' }}
                                </td>
                                <td style="font-size:.82rem;color:var(--text-secondary);">
                                    {{ $sys->office?->office_name ?? '—' }}
                                </td>
                                <td style="font-size:.79rem;color:var(--text-secondary);">{{ $internalUsers }}</td>
                                <td style="font-size:.79rem;color:var(--text-secondary);">{{ $externalUsers }}</td>
                                <td>
                                    <div
                                        style="font-size:.79rem;color:var(--text-secondary);max-width:160px;white-space:normal;line-height:1.4;">
                                        {{ $sys->infoSys_mfoConnection ?? '—' }}
                                    </div>
                                </td>
                                <td>
                                    <div
                                        style="font-size:.79rem;color:var(--text-secondary);max-width:180px;white-space:normal;line-height:1.4;">
                                        {{ $problems }}
                                    </div>
                                </td>
                                <td style="font-size:.79rem;color:var(--text-secondary);">{{ $fundings }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>