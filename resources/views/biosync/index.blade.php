<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#062332">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioSync | UTM</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/biosync.css') }}">
</head>
<body class="biosync-app-page">
    <div id="biosyncApp" class="app-shell">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <img src="{{ asset('utm.png') }}" alt="Universidad Tecnológica de Morelia">
                <span>BioSync Web</span>
            </div>

            <nav class="main-nav" aria-label="Navegación principal">
                <button class="nav-item is-active" type="button" data-view="inicio"><span aria-hidden="true">⌂</span>Inicio</button>
                @can('importar poleos biosync')
                <button class="nav-item" type="button" data-view="importar"><span aria-hidden="true">⇧</span>Importar poleo</button>
                @endcan
                @can('gestionar empleados biosync')
                <button class="nav-item" type="button" data-view="empleados"><span aria-hidden="true">♙</span>Empleados</button>
                @endcan
                @can('ver reportes biosync')
                <button class="nav-item" type="button" data-view="reportes"><span aria-hidden="true">▥</span>Reportes</button>
                @endcan
                @can('gestionar usuarios biosync')
                <button class="nav-item" type="button" data-view="usuarios"><span aria-hidden="true">♚</span>Usuarios</button>
                @endcan
                <button class="nav-item" type="button" data-view="configuracion"><span aria-hidden="true">⚙</span>Configuración</button>
            </nav>

            <div class="sidebar-footer">
                <span>Sesión de</span>
                <strong>{{ auth()->user()->name }}</strong>
                <small>rrb-soluciones.com</small>
            </div>
        </aside>

        <div class="app-main">
            <header class="topbar">
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Abrir menú" aria-expanded="false">☰</button>
                <div>
                    <h1 id="pageTitle">Inicio</h1>
                    <p id="pageSubtitle">Resumen operativo de BioSync</p>
                </div>
                <div class="connection-chip" id="connectionChip"><span></span>Consultando</div>
            </header>

            <main class="content">
                <section class="app-view is-active" data-section="inicio">
                    <div class="metrics-grid">
                        <article class="metric-card"><span>Conexión</span><strong id="metricConnection">Consultando</strong><small>Base central</small></article>
                        <article class="metric-card"><span>Poleos servidor</span><strong id="metricAttendances">—</strong><small>Registros de asistencia</small></article>
                        <article class="metric-card"><span>Empleados</span><strong id="metricEmployees">—</strong><small>Usuarios registrados</small></article>
                        <article class="metric-card"><span>Última importación</span><strong id="metricLastImport">—</strong><small>Fecha y hora</small></article>
                    </div>

                    <div class="action-row">
                        @can('importar poleos biosync')
                        <button class="button button-primary" type="button" data-go="importar">Importar poleo</button>
                        @endcan
                        @can('gestionar empleados biosync')
                        <button class="button button-secondary" type="button" data-go="empleados">Registrar usuario</button>
                        @endcan
                        @can('ver reportes biosync')
                        <button class="button button-secondary" type="button" data-go="reportes">Ver reportes</button>
                        @endcan
                        <button class="button button-ghost" id="refreshHome" type="button">Actualizar</button>
                    </div>

                    <div class="panel table-panel">
                        <div class="panel-heading">
                            <div><span class="eyebrow">Actividad reciente</span><h2>Poleos recientes del servidor</h2></div>
                            <span class="record-count" id="recentCount">0 registros</span>
                        </div>
                        <div class="table-wrap"><table><thead><tr><th>ID propio</th><th>Empleado</th><th>Fecha</th><th>Entrada</th><th>Salida</th><th>Marcas</th><th>Observación</th><th>Archivo</th></tr></thead><tbody id="recentTable"></tbody></table></div>
                    </div>
                </section>

                <section class="app-view" data-section="importar">
                    <div class="panel import-panel">
                        <div class="import-toolbar">
                            <label class="button button-primary file-button" for="datFile">Seleccionar poleo<input id="datFile" type="file" accept=".dat,text/plain"></label>
                            <button class="button button-primary" id="uploadPoleo" type="button" disabled>Enviar a servidor</button>
                            <button class="button button-secondary" id="refreshImports" type="button">Actualizar servidor</button>
                        </div>
                        <div class="file-summary">
                            <div><span>Archivo</span><strong id="fileName">Ninguno seleccionado</strong></div>
                            <div><span>Registros</span><strong id="fileRecords">0</strong></div>
                            <div><span>Líneas ignoradas</span><strong id="fileIgnored">0</strong></div>
                        </div>
                    </div>

                    <div class="panel table-panel">
                        <div class="tabs" role="tablist" aria-label="Datos de importación">
                            <button class="tab is-active" type="button" data-tab="archivo">Archivo procesado</button>
                            <button class="tab" type="button" data-tab="asistencias">Asistencias del servidor</button>
                            <button class="tab" type="button" data-tab="importaciones">Importaciones</button>
                        </div>
                        <div class="tab-panel is-active" data-tab-panel="archivo"><div class="table-wrap"><table><thead><tr><th>Empleado</th><th>Fecha</th><th>Entrada</th><th>Salida</th><th>Marcas</th><th>Observaciones</th></tr></thead><tbody id="localFileTable"></tbody></table></div><div class="empty-state" id="fileEmpty">Selecciona un archivo DAT para revisar sus registros antes de enviarlos.</div></div>
                        <div class="tab-panel" data-tab-panel="asistencias"><div class="table-wrap"><table><thead><tr><th>ID propio</th><th>Empleado</th><th>Fecha</th><th>Entrada</th><th>Salida</th><th>Marcas</th><th>Observación</th><th>Archivo</th></tr></thead><tbody id="serverAttendancesTable"></tbody></table></div></div>
                        <div class="tab-panel" data-tab-panel="importaciones"><div class="table-wrap"><table><thead><tr><th>Archivo</th><th>Hash</th><th>Registros</th><th>Importado</th></tr></thead><tbody id="importsTable"></tbody></table></div></div>
                    </div>
                </section>

                <section class="app-view" data-section="empleados">
                    <div class="employee-layout">
                        <form class="panel employee-form" id="employeeForm">
                            <div class="panel-heading"><div><span class="eyebrow">Expediente</span><h2 id="employeeFormTitle">Registrar usuario</h2></div></div>
                            <input id="employeeDatabaseId" type="hidden">
                            <label for="employeeClock">ID propio / No. reloj</label>
                            <input id="employeeClock" name="numero_reloj" type="text" maxlength="50" required>
                            <label for="employeeName">Nombre</label>
                            <input id="employeeName" name="nombre" type="text" maxlength="150">
                            <label for="employeeDepartment">Departamento</label>
                            <input id="employeeDepartment" name="departamento" type="text" maxlength="150" list="departmentOptions">
                            <datalist id="departmentOptions"></datalist>
                            <label for="employeePosition">Puesto</label>
                            <input id="employeePosition" name="puesto" type="text" maxlength="150" list="positionOptions">
                            <datalist id="positionOptions"></datalist>
                            <label for="employeeEmail">Correo</label>
                            <input id="employeeEmail" name="correo" type="email" maxlength="190">
                            <label for="employeeType">Tipo de personal</label>
                            <select id="employeeType" required>
                                <option value="administrativo">Administrativo</option>
                                <option value="docente">Docente</option>
                                <option value="confianza">Confianza</option>
                                <option value="otro">Otro</option>
                            </select>
                            <label class="check-row" for="employeeActive"><input id="employeeActive" type="checkbox" checked><span>Empleado activo</span></label>
                            <div class="form-actions"><button class="button button-primary" id="saveEmployee" type="submit">Registrar usuario</button><button class="button button-secondary" id="newEmployee" type="button">Nuevo</button></div>

                            <div class="schedule-editor">
                                <strong>Bloques asignados</strong>
                                <p id="employeeAssignedSchedules">Guarda o selecciona un empleado para asignarle horarios.</p>
                                <label for="employeeSchedule">Bloque existente</label>
                                <select id="employeeSchedule"><option value="">Seleccionar...</option></select>
                                <label for="scheduleStart">Vigente desde</label>
                                <input id="scheduleStart" type="date">
                                <button class="button button-secondary" id="assignSchedule" type="button">Asignar bloque</button>

                                <details>
                                    <summary>Crear bloque nuevo</summary>
                                    <label for="newScheduleName">Nombre</label>
                                    <input id="newScheduleName" type="text" maxlength="150" placeholder="Ej. Matemáticas lunes 08:00">
                                    <div class="schedule-times"><label for="newScheduleEntry">Entrada<input id="newScheduleEntry" type="time"></label><label for="newScheduleExit">Salida<input id="newScheduleExit" type="time"></label></div>
                                    <fieldset class="weekday-picker"><legend>Días</legend><label><input type="checkbox" value="1" checked>Lu</label><label><input type="checkbox" value="2" checked>Ma</label><label><input type="checkbox" value="3" checked>Mi</label><label><input type="checkbox" value="4" checked>Ju</label><label><input type="checkbox" value="5" checked>Vi</label><label><input type="checkbox" value="6">Sa</label><label><input type="checkbox" value="7">Do</label></fieldset>
                                    <button class="button button-secondary" id="createSchedule" type="button">Crear bloque</button>
                                </details>
                            </div>
                        </form>

                        <div class="panel table-panel employee-list">
                            <div class="panel-heading employee-heading">
                                <div><span class="eyebrow">Directorio</span><h2>Empleados</h2></div>
                                <div class="search-box"><label class="sr-only" for="employeeSearch">Buscar empleado</label><input id="employeeSearch" type="search" placeholder="Buscar por ID, nombre o área"><button class="button button-secondary" id="searchEmployees" type="button">Buscar</button></div>
                            </div>
                            <p class="table-hint">Selecciona una fila para editar al empleado.</p>
                            <div class="table-wrap"><table><thead><tr><th>ID propio</th><th>Nombre</th><th>Departamento</th><th>Puesto</th><th>Correo</th><th>Estatus</th></tr></thead><tbody id="employeesTable"></tbody></table></div>
                        </div>
                    </div>
                </section>

                <section class="app-view" data-section="reportes">
                    <div class="panel report-toolbar">
                        <label for="reportFrom">Desde<input id="reportFrom" type="date"></label>
                        <label for="reportTo">Hasta<input id="reportTo" type="date"></label>
                        <button class="button button-primary" id="generateReport" type="button">Generar</button>
                        <button class="button button-secondary" id="refreshReport" type="button">Actualizar poleos</button>
                        <button class="button button-secondary" id="exportReport" type="button">Exportar CSV</button>
                    </div>
                    <div class="panel table-panel">
                        <div class="panel-heading"><div><span class="eyebrow">Nómina · cálculo sugerido</span><h2>Concentrado mensual</h2></div><span class="record-count" id="reportCount">0 incidencias</span></div>
                        <p class="table-hint" id="reportWarning">Los resultados requieren validación de Recursos Humanos.</p>
                        <div class="table-wrap"><table><thead><tr><th>Mes</th><th>ID</th><th>Empleado</th><th>R1</th><th>R2</th><th>RM</th><th>S1</th><th>S2</th><th>SM</th><th>OES</th><th>Faltas</th><th>Justificadas</th><th>Días sugeridos</th></tr></thead><tbody id="reportSummaryTable"></tbody></table></div>
                    </div>

                    <div class="report-layout">
                        <div class="panel table-panel">
                            <div class="panel-heading"><div><span class="eyebrow">Reglamento UTM 2018</span><h2>Incidencias por bloque</h2></div></div>
                            <p class="table-hint">Selecciona una incidencia para justificarla. R = retardo, S = salida anticipada, OES = omisión de entrada o salida.</p>
                            <div class="table-wrap report-detail-wrap"><table><thead><tr><th>Fecha</th><th>ID</th><th>Empleado</th><th>Bloque</th><th>Programado</th><th>Real</th><th>Código</th><th>Min.</th><th>Estado</th></tr></thead><tbody id="reportTable"></tbody></table></div>
                        </div>

                        @can('gestionar justificaciones biosync')
                        <form class="panel justification-form" id="justificationForm">
                            <div class="panel-heading"><div><span class="eyebrow">Control administrativo</span><h2>Justificar incidencia</h2></div></div>
                            <p id="selectedIncident">Selecciona una incidencia pendiente.</p>
                            <label for="justificationType">Motivo autorizado</label>
                            <select id="justificationType" required>
                                <option value="">Seleccionar...</option>
                                <option value="incapacidad_imss">Incapacidad IMSS</option>
                                <option value="atencion_medica_hijo">Atención médica de hijo menor</option>
                                <option value="receta_imss">Receta IMSS</option>
                                <option value="comision_oficial">Comisión oficial</option>
                                <option value="pase_salida">Pase de salida autorizado</option>
                                <option value="permiso_economico">Permiso económico</option>
                                <option value="defuncion">Defunción de familiar</option>
                                <option value="omision_reloj">Omisión de reloj reportada</option>
                                <option value="permiso_maternidad">Permiso por maternidad</option>
                                <option value="otra_ley_laboral">Otra causa de ley</option>
                            </select>
                            <label for="justificationDescription">Descripción</label>
                            <textarea id="justificationDescription" rows="5" maxlength="2000" required></textarea>
                            <label for="justificationDocument">Documento / folio</label>
                            <input id="justificationDocument" type="text" maxlength="255" placeholder="Folio, oficio, incapacidad, pase...">
                            <label class="check-row"><input id="justificationAvoidDiscount" type="checkbox" checked><span>No incluir en descuento sugerido</span></label>
                            <button class="button button-primary" id="saveJustification" type="submit" disabled>Guardar justificación</button>
                        </form>
                        @endcan
                    </div>
                </section>

                @can('gestionar usuarios biosync')
                <section class="app-view" data-section="usuarios">
                    <div class="user-layout">
                        <form class="panel user-form" id="userForm">
                            <div class="panel-heading"><div><span class="eyebrow">Acceso al portal</span><h2 id="userFormTitle">Crear usuario</h2></div></div>
                            <input id="userDatabaseId" type="hidden">

                            <label for="userName">Nombre</label>
                            <input id="userName" type="text" maxlength="255" autocomplete="name" required>

                            <label for="userEmail">Correo electrónico</label>
                            <input id="userEmail" type="email" maxlength="255" autocomplete="email" required>

                            <label for="userRole">Perfil de acceso</label>
                            <select id="userRole" required>
                                <option value="BioSync Operador">Operador</option>
                                <option value="BioSync Consulta">Consulta</option>
                                <option value="BioSync Administrador">Administrador</option>
                            </select>

                            <label for="userPassword">Contraseña <span id="passwordHint">mínimo 8 caracteres</span></label>
                            <input id="userPassword" type="password" minlength="8" autocomplete="new-password" required>

                            <label for="userPasswordConfirmation">Confirmar contraseña</label>
                            <input id="userPasswordConfirmation" type="password" minlength="8" autocomplete="new-password" required>

                            <div class="form-actions user-actions">
                                <button class="button button-primary" id="saveUser" type="submit">Crear usuario</button>
                                <button class="button button-secondary" id="newUser" type="button">Nuevo</button>
                                <button class="button button-danger" id="revokeUser" type="button" hidden>Revocar acceso</button>
                            </div>
                        </form>

                        <div class="user-content">
                            <div class="role-cards">
                                <article><strong>Administrador</strong><span>Usuarios, empleados, importaciones y reportes.</span></article>
                                <article><strong>Operador</strong><span>Importa poleos, administra empleados y consulta reportes.</span></article>
                                <article><strong>Consulta</strong><span>Solo visualiza el inicio y los reportes.</span></article>
                            </div>

                            <div class="panel table-panel user-list">
                                <div class="panel-heading"><div><span class="eyebrow">Personal autorizado</span><h2>Usuarios de BioSync</h2></div><span class="record-count" id="userCount">0 usuarios</span></div>
                                <p class="table-hint">Selecciona una fila para cambiar el perfil o restablecer la contraseña.</p>
                                <div class="table-wrap"><table><thead><tr><th>Nombre</th><th>Correo</th><th>Perfil</th><th>Tipo</th></tr></thead><tbody id="usersTable"></tbody></table></div>
                            </div>
                        </div>
                    </div>
                </section>
                @endcan

                <section class="app-view" data-section="configuracion">
                    <div class="settings-grid">
                        <article class="panel settings-card"><span class="settings-icon">◎</span><div><span class="eyebrow">Servidor</span><h2>Conexión integrada</h2><p>BioSync trabaja directamente con la base central de RRB Soluciones. Ya no requiere configurar URL, token o licencia por equipo.</p><dl><div><dt>Portal</dt><dd>{{ route('biosync.index') }}</dd></div><div><dt>Estado</dt><dd id="settingsConnection">Consultando</dd></div></dl><button class="button button-secondary" id="testConnection" type="button">Probar conexión</button></div></article>
                        <article class="panel settings-card"><span class="settings-icon">♙</span><div><span class="eyebrow">Cuenta</span><h2>{{ auth()->user()->name }}</h2><p>{{ auth()->user()->email }}</p><p>Perfil: <strong>{{ auth()->user()->getRoleNames()->join(', ') ?: 'Acceso directo' }}</strong></p><p>El acceso y los datos se protegen con tu sesión web.</p><form method="POST" action="{{ route('biosync.logout') }}">@csrf<button class="button button-danger" type="submit">Cerrar sesión</button></form></div></article>
                    </div>
                </section>
            </main>

            <footer class="statusbar"><span class="status-dot"></span><span id="statusText" role="status" aria-live="polite">Listo</span></footer>
        </div>
        <button class="sidebar-overlay" id="sidebarOverlay" type="button" aria-label="Cerrar menú"></button>
    </div>

    <div class="toast" id="toast" role="alert" aria-live="assertive"></div>

    <script>
        window.BioSyncConfig = @json($biosyncConfig);
    </script>
    <script src="{{ asset('js/biosync-web.js') }}" defer></script>
</body>
</html>
