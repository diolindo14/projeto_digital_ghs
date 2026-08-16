<?php
/**
 * Shared Schedule Grid Partial — Faculdade Moderna de Direito (FMD)
 * Usage: include this file after setting $gridData = $horarioModel->buildWeeklyGrid($turma_id)
 * and $turmaInfo = ['codigo' => ..., 'turno' => ..., 'nivel' => ...]
 */

$diasOrder = ['Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
$diasLabels = ['SEG','TER','QUA','QUI','SEX','SÁB'];
?>

<style>
/* Clean Academic Style FMD */
.horario-container { font-family: 'Outfit', 'Inter', system-ui, -apple-system, sans-serif; color: #0f172a; }
.grade-table-edu { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid #1e3a8a; }
.grade-table-edu th { background-color: #1e3a8a; color: #fff; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; padding: 12px 6px; border: 1px solid #1e3a8a; letter-spacing: 0.5px; }
.grade-table-edu td { border: 1px solid #cbd5e1; padding: 0; vertical-align: middle; height: 60px; }

.col-tempo, .col-hora { text-align: center; font-weight: bold; background: #f8fafc; width: 85px; border-right: 2px solid #1e3a8a; }
.tempo-val { font-size: 1.1rem; color: #1e3a8a; font-weight: 800; }
.hora-val { font-size: 0.75rem; color: #475569; display: block; white-space: nowrap; margin-top: 2px; }

/* Slot Design: Two rows */
.slot-wrapper { display: flex; flex-direction: column; height: 100%; width: 100%; }
.slot-subject { 
    flex: 1; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-weight: 700; 
    font-size: 0.9rem; 
    color: #0f172a;
    border-bottom: 1px solid #e2e8f0;
    padding: 4px;
}
.slot-room { 
    flex: 1; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 0.8rem; 
    color: #1e3a8a;
    font-weight: 600;
    padding: 2px;
    background-color: #f8fafc;
}

.slot-empty-edu { 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    height: 100%; width: 100%;
}
.slot-empty-edu svg { width: 100%; height: 100%; }
.slot-empty-edu line { stroke: #cbd5e1; stroke-width: 1; }

.header-info-edu { margin-bottom: 20px; font-weight: bold; font-size: 1.4rem; text-align: center; color: #1e3a8a; }

@media print {
    .no-print { display: none !important; }
    .horario-container { padding: 0; }
    .grade-table-edu th { background-color: #1e3a8a !important; color: white !important; -webkit-print-color-adjust: exact; }
}
</style>

<div class="horario-container">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3">
            <?php if (!empty($turmaInfo)): ?>
                <h5 class="mb-0 fw-bold text-dark">
                    <ion-icon name="calendar-outline" class="me-1 text-primary"></ion-icon>
                    <?= htmlspecialchars($turmaInfo['codigo']) ?> 
                    <span class="text-muted mx-2">|</span> 
                    <small class="text-secondary"><?= htmlspecialchars($turmaInfo['nivel'] ?? '—') ?></small>
                </h5>
            <?php endif; ?>
            
            <?php if (isset($gridData['grid']) && count($gridData['grid']) > 0): ?>
                <?php 
                $uniqueTurmas = [];
                foreach($gridData['grid'] as $tempo) {
                    foreach($tempo as $dia => $slot) {
                        if (isset($slot['turma_codigo'])) $uniqueTurmas[$slot['turma_id']] = $slot['turma_codigo'];
                    }
                }
                ?>
                <?php if (count($uniqueTurmas) > 1): ?>
                    <div class="ms-3 d-flex align-items-center gap-2">
                        <label class="small fw-bold text-muted text-nowrap">Filtrar Turma:</label>
                        <select class="form-select form-select-sm border-0 shadow-sm bg-light" id="filter-turma-grid" onchange="filterGridByTurma(this.value)" style="width: 160px; border-radius: 8px;">
                            <option value="all">Todas as Turmas</option>
                            <?php foreach($uniqueTurmas as $tid => $tcod): ?>
                                <option value="<?= $tid ?>"><?= $tcod ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-primary fw-bold px-3 shadow-sm" style="background-color: #1e3a8a; border: none;" onclick="window.print()">
                <ion-icon name="print-outline" class="me-1"></ion-icon> Imprimir Horário Oficial FMD
            </button>
        </div>
    </div>

    <?php if (empty($gridData['tempos'])): ?>
        <div class="text-center py-5 text-muted border rounded-3 bg-light">
            <ion-icon name="calendar-outline" class="fs-1 text-muted mb-2"></ion-icon>
            <p class="mb-0 fw-semibold">Horário curricular em fase de homologação para esta turma.</p>
        </div>
    <?php else: ?>

    <div class="d-none d-print-block">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <div style="width: 150px;">
                <img src="<?= URL_ROOT ?>/img/logo_fmd.jpg" alt="Faculdade Moderna de Direito" style="width: 100%; object-fit: contain;">
            </div>
            <div class="text-center flex-grow-1">
                <h2 style="font-family: 'Outfit', sans-serif; font-weight: 800; color: #1e3a8a; margin-bottom: 0;">HORÁRIO ACADÉMICO 2026/2027</h2>
                <div style="font-size: 0.9rem; font-weight: 700; color: #64748b;">FACULDADE MODERNA DE DIREITO (FMD)</div>
            </div>
            <div style="width: 150px; text-align: right; font-size: 0.9rem; color: #475569;">
                Data: <?= date('d/m/Y') ?>
            </div>
        </div>
        <div class="text-center mb-3" style="font-size: 1.15rem; font-weight: 800; font-family: 'Outfit', sans-serif; border-top: 3px solid #1e3a8a; padding-top: 12px; margin-top: 12px; color: #0f172a; text-transform: uppercase;">
            (TURMA: <span id="print-turma-label"><?= htmlspecialchars($turmaInfo['codigo'] ?? 'FMD-1M1') ?></span> | HORÁRIO CURRICULAR | NÍVEL: <span id="print-nivel-label"><?= htmlspecialchars($turmaInfo['nivel'] ?? '1.º ANO') ?></span>)
        </div>
    </div>

    <div class="table-responsive">
        <table class="grade-table-edu">
            <thead>
                <tr>
                    <th class="col-tempo">TEMPO</th>
                    <th class="col-hora">HORA</th>
                    <?php foreach ($diasLabels as $label): ?>
                        <th><?= $label ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gridData['tempos'] as $tempo => $horas): ?>
                    <tr>
                        <td class="col-tempo">
                            <span class="tempo-val"><?= (int)$tempo ?>º</span>
                        </td>
                        <td class="col-hora">
                            <span class="hora-val"><?= substr($horas['inicio'],0,5) ?> - <?= substr($horas['fim'],0,5) ?></span>
                        </td>
                        <?php foreach ($diasOrder as $dia): ?>
                            <td class="slot-container-grid" data-turma-id="<?= $gridData['grid'][$tempo][$dia]['turma_id'] ?? '' ?>">
                                <?php $slot = $gridData['grid'][$tempo][$dia] ?? null; ?>
                                <div class="slot-wrapper" style="<?= !$slot ? 'display:none;' : '' ?>">
                                    <?php if ($slot): ?>
                                        <div class="slot-subject"><?= htmlspecialchars($slot['sigla']) ?></div>
                                        <div class="slot-room"><?= htmlspecialchars($slot['sala'] ?? 'S1') ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="slot-empty-edu" style="<?= $slot ? 'display:none;' : '' ?>">
                                    <svg preserveAspectRatio="none" viewBox="0 0 100 100">
                                        <line x1="0" y1="0" x2="100" y2="100" />
                                        <line x1="100" y1="0" x2="0" y2="100" />
                                    </svg>
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="mt-4 text-center d-none d-print-block" style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.1rem; color: #1e3a8a; letter-spacing: 1px;">
        CIÊNCIA • ÉTICA • RIGOR • JÚRIS
    </div>

    <?php endif; ?>
</div>

<script>
function filterGridByTurma(turmaId) {
    const slots = document.querySelectorAll('.slot-container-grid');
    slots.forEach(slot => {
        if (turmaId === 'all' || slot.getAttribute('data-turma-id') === turmaId) {
            slot.style.opacity = '1';
        } else {
            slot.style.opacity = '0.2';
        }
    });
}
</script>
