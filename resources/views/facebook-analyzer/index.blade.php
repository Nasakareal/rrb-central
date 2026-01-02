@extends('layouts.facebook-analyzer')

@section('title','Facebook Analyzer')

@section('content')
<div class="container py-5" id="app" style="max-width:820px;">

  {{-- TOP --}}
  <div class="mb-4 text-center">
    <div class="small opacity-75">RRB Lab</div>
    <h1 class="h3 mb-1">Facebook Analyzer</h1>
  </div>

  {{-- LOGIN FAKE --}}
  <div id="step1" class="card border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="h5 mb-0">Acceso al sistema</h3>
        <span class="badge bg-secondary">sandbox</span>
      </div>

      <label class="form-label small text-muted">Usuario</label>
      <input id="fakeUser" class="form-control mb-3" placeholder="nombre de usuario" autocomplete="off">

      <label class="form-label small text-muted">Contraseña</label>
      <input id="fakePass" class="form-control mb-3" placeholder="••••••••" type="password" autocomplete="off">

      <button class="btn btn-dark w-100" type="button" onclick="handleLogin()">
        Ingresar
      </button>

    </div>
  </div>

  {{-- LINK --}}
  <div id="step2" class="d-none card border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="h5 mb-0">Objetivo</h3>
        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="resetAll()">
          Reiniciar
        </button>
      </div>

      <div class="alert alert-dark mb-3">
        <div class="small opacity-75">Operador autenticado</div>
        <div class="fw-semibold" id="operatorName">—</div>
      </div>

      <label class="form-label small text-muted">Pega el link del Facebook a “hackear”</label>
      <input id="targetUrl" class="form-control mb-3" placeholder="https://facebook.com/perfil" autocomplete="off">

      <button class="btn btn-danger w-100" type="button" onclick="startHack()">
        Iniciar extracción
      </button>

    </div>
  </div>

  {{-- CONSOLA --}}
  <div id="step3" class="d-none card border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="h5 mb-0">Ejecución</h3>
        <span class="badge bg-success">RUNNING</span>
      </div>

      <div class="mb-3">
        <div class="progress" style="height:10px;">
          <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 3%"></div>
        </div>
        <div class="d-flex justify-content-between mt-1">
          <small class="text-muted" id="progressLabel">Inicializando…</small>
          <small class="text-muted" id="progressPct">3%</small>
        </div>
      </div>

      <pre id="console" class="p-3 rounded mb-0"
           style="background:#050505; color:#00ff88; min-height:320px; border:1px solid rgba(255,255,255,.08); overflow:auto;"></pre>
    </div>
  </div>

  {{-- RESULTADO --}}
  <div id="step4" class="d-none card border-0 shadow-sm">
    <div class="card-body p-4 text-center">

      <div class="mb-3">
        <div class="display-6 text-danger fw-bold">ACCESO DENEGADO</div>
        <div class="text-muted">Bloqueo automático por políticas de seguridad</div>
      </div>

      <div class="alert alert-warning text-start">
        <div class="fw-bold mb-1">⚠ Aviso de seguridad</div>
        <div class="small">
          Se generó un reporte y se “notificó” al objetivo de que
          <span class="fw-bold" id="finalUser">—</span>
          intentó realizar un acceso no autorizado.
        </div>
        <div class="small mt-1">
          Objetivo: <span class="fw-semibold" id="finalTarget">—</span>
        </div>
      </div>

      <p class="mt-3 fw-bold mb-2">Análisis alternativo completado</p>

      <ul class="list-unstyled mb-3" style="line-height:1.9;">
        <li>🔍 Celos excesivos: <span class="fw-bold">DETECTADOS</span></li>
        <li>🔐 Falta de confianza: <span class="fw-bold">CRÍTICA</span></li>
        <li>🗣️ Comunicación directa: <span class="fw-bold">NO ENCONTRADA</span></li>
        <li>🧠 Intentos de diálogo: <span class="fw-bold">0</span></li>
      </ul>

      <h5 class="mt-3">
        No es un problema de Facebook.<br>
        Es un problema de relación.
      </h5>

      <small class="text-muted d-block mt-3">
        rrb-soluciones · Programamos sistemas, no dramas
      </small>

      <div class="mt-4 d-grid gap-2">
        <button class="btn btn-outline-secondary" type="button" onclick="resetAll()">Volver a iniciar</button>
      </div>
    </div>
  </div>

</div>

<script>
/**
 * IMPORTANTE:
 * - No hay POST, no hay fetch, no hay almacenamiento en BD.
 * - Todo vive en memoria del navegador (variables JS).
 */

let OPERATOR = '';
let TARGET = '';

function showStep(n){
  document.querySelectorAll('#app > div[id^="step"]').forEach(d => d.classList.add('d-none'));
  const el = document.getElementById('step' + n);
  if(el) el.classList.remove('d-none');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function escapeHtml(str){
  return String(str || '').replace(/[&<>"']/g, (m) => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[m]));
}

function handleLogin(){
  const u = (document.getElementById('fakeUser').value || '').trim();
  OPERATOR = u.length ? u : 'anon';

  document.getElementById('operatorName').textContent = OPERATOR;
  showStep(2);
}

function resetAll(){
  OPERATOR = '';
  TARGET = '';
  const c = document.getElementById('console');
  if(c) c.textContent = '';

  const pb = document.getElementById('progressBar');
  const pl = document.getElementById('progressLabel');
  const pp = document.getElementById('progressPct');
  if(pb) pb.style.width = '3%';
  if(pl) pl.textContent = 'Inicializando…';
  if(pp) pp.textContent = '3%';

  // Limpia inputs
  const ids = ['fakeUser','fakePass','targetUrl'];
  ids.forEach(id => {
    const el = document.getElementById(id);
    if(el) el.value = '';
  });

  showStep(1);
}

function startHack(){
  TARGET = (document.getElementById('targetUrl').value || '').trim();
  if(!TARGET) TARGET = 'https://facebook.com/perfil';

  showStep(3);

  const c = document.getElementById('console');
  c.textContent = '';
  const now = () => new Date().toLocaleTimeString();

  const logs = [
    `[${now()}] init: session=${Math.random().toString(16).slice(2,10)} mode=sandbox`,
    `[${now()}] target: ${TARGET}`,
    `[${now()}] net: resolving host…`,
    `[${now()}] net: establishing secure channel…`,
    `[${now()}] auth: attempting token handshake…`,
    `[${now()}] policy: risk-score evaluation…`,
    `[${now()}] bypass: trust-layer… (simulado)`,
    `[${now()}] scan: content graph analysis…`,
    `[${now()}] scan: relationship heuristics…`,
    `[${now()}] verdict: security policy triggered`,
    `[${now()}] abort: access denied`
  ];

  const progressMap = [
    { pct: 10, label: 'Conectando…' },
    { pct: 22, label: 'Resolviendo DNS…' },
    { pct: 35, label: 'Canal seguro…' },
    { pct: 48, label: 'Handshake…' },
    { pct: 60, label: 'Evaluando riesgo…' },
    { pct: 72, label: 'Inyectando sentido común…' },
    { pct: 84, label: 'Analizando patrones…' },
    { pct: 93, label: 'Compilando reporte…' },
    { pct: 100, label: 'Finalizando…' },
  ];

  let i = 0;
  let p = 0;

  const pb = document.getElementById('progressBar');
  const pl = document.getElementById('progressLabel');
  const pp = document.getElementById('progressPct');

  const interval = setInterval(() => {
    // log
    c.textContent += logs[i] + "\n";
    c.scrollTop = c.scrollHeight;

    // progress
    const step = progressMap[Math.min(p, progressMap.length - 1)];
    pb.style.width = step.pct + '%';
    pl.textContent = step.label;
    pp.textContent = step.pct + '%';
    p++;

    i++;
    if(i >= logs.length){
      clearInterval(interval);

      // set final data
      document.getElementById('finalUser').textContent = OPERATOR || 'anon';
      document.getElementById('finalTarget').textContent = TARGET;

      setTimeout(() => showStep(4), 900);
    }
  }, 520);
}

// default
showStep(1);
</script>
@endsection
