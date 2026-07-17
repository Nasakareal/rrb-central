(function () {
    'use strict';

    var config = window.BioSyncConfig || {};
    var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var state = {
        view: 'inicio',
        file: null,
        fileHash: '',
        records: [],
        ignoredLines: 0,
        employees: []
    };
    var titles = {
        inicio: ['Inicio', 'Resumen operativo de BioSync'],
        importar: ['Importar poleo', 'Carga de archivo DAT y consulta de poleos enviados'],
        empleados: ['Empleados', 'Registro y consulta de usuarios por ID propio'],
        reportes: ['Reportes', 'Resumen de asistencia por rango de fechas'],
        usuarios: ['Usuarios', 'Cuentas, perfiles y permisos de BioSync'],
        configuracion: ['Configuración', 'Conexión y seguridad del portal']
    };
    var toastTimer;

    function qs(selector, root) {
        return (root || document).querySelector(selector);
    }

    function qsa(selector, root) {
        return Array.prototype.slice.call((root || document).querySelectorAll(selector));
    }

    function setStatus(message) {
        qs('#statusText').textContent = message;
    }

    function showToast(message, kind) {
        var toast = qs('#toast');
        window.clearTimeout(toastTimer);
        toast.textContent = message;
        toast.className = 'toast is-visible' + (kind ? ' is-' + kind : '');
        toastTimer = window.setTimeout(function () {
            toast.className = 'toast';
        }, 4300);
    }

    function setConnection(online) {
        var chip = qs('#connectionChip');
        var settings = qs('#settingsConnection');
        chip.className = 'connection-chip ' + (online ? 'is-online' : 'is-offline');
        chip.lastChild.nodeValue = online ? 'Conectado' : 'Sin conexión';
        if (settings) {
            settings.textContent = online ? 'Conectado' : 'Sin conexión';
        }
    }

    function api(url, options) {
        var request = options || {};
        request.headers = Object.assign({
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf
        }, request.headers || {});

        if (request.body && typeof request.body !== 'string' && !(request.body instanceof FormData)) {
            request.headers['Content-Type'] = 'application/json';
            request.body = JSON.stringify(request.body);
        }

        return fetch(url, request).then(function (response) {
            return response.json().catch(function () { return {}; }).then(function (payload) {
                if (!response.ok) {
                    var validation = payload.errors ? Object.values(payload.errors)[0] : null;
                    var message = validation ? validation[0] : (payload.message || 'No fue posible completar la operación.');
                    throw new Error(message);
                }
                return payload;
            });
        });
    }

    function goToView(view) {
        if (!titles[view]) {
            return;
        }

        state.view = view;
        qsa('[data-section]').forEach(function (section) {
            section.classList.toggle('is-active', section.getAttribute('data-section') === view);
        });
        qsa('[data-view]').forEach(function (button) {
            button.classList.toggle('is-active', button.getAttribute('data-view') === view);
        });
        qs('#pageTitle').textContent = titles[view][0];
        qs('#pageSubtitle').textContent = titles[view][1];
        closeMenu();

        if (view === 'inicio') { loadHome(); }
        if (view === 'importar') { loadServerData(); }
        if (view === 'empleados') { loadEmployees(); loadCatalogs(); }
        if (view === 'reportes') { loadReport(); }
        if (view === 'usuarios') { loadUsers(); }
        if (view === 'configuracion') { testConnection(false); }
    }

    function openMenu() {
        qs('#biosyncApp').classList.add('menu-open');
        qs('#menuToggle').setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        qs('#biosyncApp').classList.remove('menu-open');
        qs('#menuToggle').setAttribute('aria-expanded', 'false');
    }

    function text(value, fallback) {
        if (value === null || typeof value === 'undefined' || value === '') {
            return fallback || '—';
        }
        return String(value);
    }

    function displayDate(value, includeTime) {
        if (!value) { return '—'; }
        var normalized = String(value).replace(' ', 'T');
        var date = new Date(normalized);
        if (Number.isNaN(date.getTime())) { return String(value); }
        return new Intl.DateTimeFormat('es-MX', includeTime ? {
            dateStyle: 'medium', timeStyle: 'short'
        } : { dateStyle: 'medium' }).format(date);
    }

    function makeCell(value, className) {
        var cell = document.createElement('td');
        cell.textContent = text(value);
        if (className) { cell.className = className; }
        return cell;
    }

    function emptyTable(tbody, message, columns) {
        tbody.textContent = '';
        var row = document.createElement('tr');
        row.className = 'empty-row';
        var cell = document.createElement('td');
        cell.colSpan = columns;
        cell.textContent = message;
        row.appendChild(cell);
        tbody.appendChild(row);
    }

    function attendanceName(item) {
        if (!item.empleado) { return 'Sin nombre'; }
        var parts = [item.empleado.nombre, item.empleado.apellido_paterno, item.empleado.apellido_materno].filter(Boolean);
        return parts.length ? parts.join(' ') : 'Sin nombre';
    }

    function renderAttendances(target, items) {
        var tbody = qs(target);
        tbody.textContent = '';
        if (!items || !items.length) {
            emptyTable(tbody, 'No hay asistencias registradas.', 8);
            return;
        }
        items.forEach(function (item) {
            var row = document.createElement('tr');
            row.appendChild(makeCell(item.empleado ? item.empleado.numero_reloj : '—'));
            row.appendChild(makeCell(attendanceName(item)));
            row.appendChild(makeCell(displayDate(item.fecha, false)));
            row.appendChild(makeCell(item.entrada));
            row.appendChild(makeCell(item.salida, item.salida ? '' : 'cell-muted'));
            row.appendChild(makeCell(item.total_marcas));
            row.appendChild(makeCell(item.observaciones, item.observaciones ? '' : 'cell-muted'));
            row.appendChild(makeCell(item.archivo_origen));
            tbody.appendChild(row);
        });
    }

    function loadHome() {
        setStatus('Consultando servidor...');
        return api(config.resumen).then(function (payload) {
            var data = payload.data;
            qs('#metricConnection').textContent = data.conexion;
            qs('#metricAttendances').textContent = data.asistencias.toLocaleString('es-MX');
            qs('#metricEmployees').textContent = data.empleados.toLocaleString('es-MX');
            qs('#metricLastImport').textContent = data.ultima_importacion ? displayDate(data.ultima_importacion, true) : 'Sin importaciones';
            qs('#recentCount').textContent = data.recientes.length + (data.recientes.length === 1 ? ' registro' : ' registros');
            renderAttendances('#recentTable', data.recientes);
            setConnection(true);
            setStatus('Inicio actualizado.');
        }).catch(function (error) {
            setConnection(false);
            setStatus('No se pudo consultar el servidor.');
            showToast(error.message, 'error');
        });
    }

    function renderLocalRecords() {
        var tbody = qs('#localFileTable');
        var empty = qs('#fileEmpty');
        tbody.textContent = '';
        empty.style.display = state.records.length ? 'none' : 'block';
        state.records.forEach(function (record) {
            var row = document.createElement('tr');
            row.appendChild(makeCell(record.numero_reloj));
            row.appendChild(makeCell(displayDate(record.fecha, false)));
            row.appendChild(makeCell(record.entrada));
            row.appendChild(makeCell(record.salida, record.salida ? '' : 'cell-muted'));
            row.appendChild(makeCell(record.marcas));
            row.appendChild(makeCell(record.observaciones, record.observaciones ? '' : 'cell-muted'));
            tbody.appendChild(row);
        });
    }

    function parseDat(contents) {
        var marks = [];
        var ignored = 0;
        contents.split(/\r?\n/).forEach(function (line) {
            var trimmed = line.trim();
            if (!trimmed) { return; }
            var parts = trimmed.split(/\s+/);
            if (parts.length < 3 || !/^\d{4}-\d{2}-\d{2}$/.test(parts[1]) || !/^\d{2}:\d{2}:\d{2}$/.test(parts[2]) || !validDateTime(parts[1], parts[2])) {
                ignored++;
                return;
            }
            marks.push({ employee: parts[0], date: parts[1], time: parts[2] });
        });

        marks.sort(function (a, b) {
            return (a.employee + '|' + a.date + '|' + a.time).localeCompare(b.employee + '|' + b.date + '|' + b.time);
        });
        var groups = {};
        marks.forEach(function (mark) {
            var key = mark.employee + '|' + mark.date;
            groups[key] = groups[key] || [];
            groups[key].push(mark);
        });

        var records = Object.keys(groups).map(function (key) {
            var dayMarks = groups[key];
            var first = dayMarks[0];
            var last = dayMarks[dayMarks.length - 1];
            return {
                numero_reloj: first.employee,
                fecha: first.date,
                entrada: first.time,
                salida: dayMarks.length === 1 ? null : last.time,
                marcas: dayMarks.length,
                observaciones: dayMarks.length === 1 ? 'Registro incompleto' : (dayMarks.length > 2 ? 'Tiene marcas intermedias' : null)
            };
        });

        return { records: records, ignored: ignored };
    }

    function validDateTime(dateText, timeText) {
        var dateParts = dateText.split('-').map(Number);
        var timeParts = timeText.split(':').map(Number);
        if (timeParts[0] > 23 || timeParts[1] > 59 || timeParts[2] > 59) { return false; }
        var candidate = new Date(Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2]));
        return candidate.getUTCFullYear() === dateParts[0] && candidate.getUTCMonth() === dateParts[1] - 1 && candidate.getUTCDate() === dateParts[2];
    }

    function bufferToHex(buffer) {
        return Array.prototype.map.call(new Uint8Array(buffer), function (byte) {
            return byte.toString(16).padStart(2, '0');
        }).join('');
    }

    function selectFile(file) {
        if (!file) { return; }
        if (!/\.dat$/i.test(file.name)) {
            showToast('Selecciona un archivo con extensión .dat.', 'error');
            return;
        }
        setStatus('Procesando archivo DAT...');
        Promise.all([file.text(), file.arrayBuffer().then(function (buffer) {
            return window.crypto.subtle.digest('SHA-256', buffer).then(bufferToHex);
        })]).then(function (results) {
            var parsed = parseDat(results[0]);
            state.file = file;
            state.fileHash = results[1];
            state.records = parsed.records;
            state.ignoredLines = parsed.ignored;
            qs('#fileName').textContent = file.name;
            qs('#fileRecords').textContent = parsed.records.length.toLocaleString('es-MX');
            qs('#fileIgnored').textContent = parsed.ignored.toLocaleString('es-MX');
            qs('#uploadPoleo').disabled = parsed.records.length === 0;
            renderLocalRecords();
            activateTab('archivo');
            setStatus('Archivo procesado: ' + parsed.records.length + ' registros.');
            if (!parsed.records.length) {
                showToast('El archivo no contiene marcas válidas.', 'error');
            }
        }).catch(function (error) {
            setStatus('No se pudo procesar el archivo.');
            showToast(error.message, 'error');
        });
    }

    function uploadPoleo() {
        if (!state.file || !state.records.length) { return; }
        var button = qs('#uploadPoleo');
        button.disabled = true;
        button.textContent = 'Enviando...';
        setStatus('Enviando poleo al servidor...');
        api(config.importar, {
            method: 'POST',
            body: { archivo: state.file.name, hash: state.fileHash, registros: state.records }
        }).then(function (payload) {
            var result = payload.data;
            showToast(payload.message + ' Nuevos: ' + result.importadas + '. Duplicados: ' + result.duplicadas + '.', 'success');
            setStatus(payload.message);
            return loadServerData();
        }).catch(function (error) {
            setStatus('No se pudo importar el poleo.');
            showToast(error.message, 'error');
        }).finally(function () {
            button.disabled = false;
            button.textContent = 'Enviar a servidor';
        });
    }

    function loadServerData() {
        setStatus('Cargando información del servidor...');
        return Promise.all([api(config.asistencias + '?per_page=100'), api(config.importaciones + '?per_page=100')]).then(function (payloads) {
            renderAttendances('#serverAttendancesTable', payloads[0].data.data);
            renderImports(payloads[1].data.data);
            setConnection(true);
            setStatus('Servidor actualizado. Asistencias: ' + payloads[0].data.total + '. Importaciones: ' + payloads[1].data.total + '.');
        }).catch(function (error) {
            setConnection(false);
            setStatus('No se pudo cargar el servidor.');
            showToast(error.message, 'error');
        });
    }

    function renderImports(items) {
        var tbody = qs('#importsTable');
        tbody.textContent = '';
        if (!items.length) {
            emptyTable(tbody, 'Todavía no hay archivos importados.', 4);
            return;
        }
        items.forEach(function (item) {
            var row = document.createElement('tr');
            row.appendChild(makeCell(item.nombre_archivo));
            row.appendChild(makeCell(item.hash_archivo ? item.hash_archivo.slice(0, 16) + '…' : '—'));
            row.appendChild(makeCell(item.total_registros));
            row.appendChild(makeCell(displayDate(item.created_at, true)));
            tbody.appendChild(row);
        });
    }

    function activateTab(name) {
        qsa('[data-tab]').forEach(function (button) {
            button.classList.toggle('is-active', button.getAttribute('data-tab') === name);
        });
        qsa('[data-tab-panel]').forEach(function (panel) {
            panel.classList.toggle('is-active', panel.getAttribute('data-tab-panel') === name);
        });
    }

    function loadEmployees() {
        var search = qs('#employeeSearch').value.trim();
        var url = config.empleados + '?per_page=100' + (search ? '&buscar=' + encodeURIComponent(search) : '');
        setStatus('Cargando empleados...');
        return api(url).then(function (payload) {
            state.employees = payload.data.data;
            renderEmployees(state.employees);
            setStatus(payload.data.total ? 'Empleados cargados: ' + payload.data.total + '.' : 'No hay empleados registrados.');
        }).catch(function (error) {
            setStatus('No se pudieron cargar los empleados.');
            showToast(error.message, 'error');
        });
    }

    function renderEmployees(items) {
        var tbody = qs('#employeesTable');
        tbody.textContent = '';
        if (!items.length) {
            emptyTable(tbody, 'No se encontraron empleados.', 6);
            return;
        }
        items.forEach(function (item) {
            var row = document.createElement('tr');
            row.className = 'is-selectable';
            row.tabIndex = 0;
            row.setAttribute('data-employee-id', item.id);
            row.appendChild(makeCell(item.numero_reloj));
            row.appendChild(makeCell(text(item.nombre, 'Sin nombre')));
            row.appendChild(makeCell(item.departamento ? item.departamento.nombre : null));
            row.appendChild(makeCell(item.puesto ? item.puesto.nombre : null));
            row.appendChild(makeCell(item.correo));
            var statusCell = document.createElement('td');
            var pill = document.createElement('span');
            pill.className = 'status-pill' + (item.estatus === 'activo' ? '' : ' is-inactive');
            pill.textContent = item.estatus === 'activo' ? 'Activo' : 'Inactivo';
            statusCell.appendChild(pill);
            row.appendChild(statusCell);
            row.addEventListener('click', function () { editEmployee(item.id); });
            row.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') { editEmployee(item.id); }
            });
            tbody.appendChild(row);
        });
    }

    function editEmployee(id) {
        var item = state.employees.find(function (employee) { return String(employee.id) === String(id); });
        if (!item) { return; }
        qsa('#employeesTable tr').forEach(function (row) {
            row.classList.toggle('is-selected', row.getAttribute('data-employee-id') === String(id));
        });
        qs('#employeeDatabaseId').value = item.id;
        qs('#employeeClock').value = item.numero_reloj || '';
        qs('#employeeName').value = item.nombre || '';
        qs('#employeeDepartment').value = item.departamento ? item.departamento.nombre : '';
        qs('#employeePosition').value = item.puesto ? item.puesto.nombre : '';
        qs('#employeeEmail').value = item.correo || '';
        qs('#employeeActive').checked = item.estatus === 'activo';
        qs('#employeeFormTitle').textContent = 'Editar usuario';
        qs('#saveEmployee').textContent = 'Guardar cambios';
        setStatus('Editando empleado ' + item.numero_reloj + '.');
        if (window.innerWidth < 840) {
            qs('#employeeForm').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function resetEmployeeForm() {
        qs('#employeeForm').reset();
        qs('#employeeDatabaseId').value = '';
        qs('#employeeActive').checked = true;
        qs('#employeeFormTitle').textContent = 'Registrar usuario';
        qs('#saveEmployee').textContent = 'Registrar usuario';
        qsa('#employeesTable tr').forEach(function (row) { row.classList.remove('is-selected'); });
        setStatus('Listo para registrar un usuario nuevo.');
        qs('#employeeClock').focus();
    }

    function saveEmployee(event) {
        event.preventDefault();
        var id = qs('#employeeDatabaseId').value;
        var button = qs('#saveEmployee');
        var payload = {
            numero_reloj: qs('#employeeClock').value.trim(),
            nombre: qs('#employeeName').value.trim() || null,
            departamento: qs('#employeeDepartment').value.trim() || null,
            puesto: qs('#employeePosition').value.trim() || null,
            correo: qs('#employeeEmail').value.trim() || null,
            estatus: qs('#employeeActive').checked ? 'activo' : 'inactivo'
        };
        if (!payload.numero_reloj) {
            showToast('Captura el ID propio del usuario.', 'error');
            qs('#employeeClock').focus();
            return;
        }
        button.disabled = true;
        button.textContent = 'Guardando...';
        setStatus(id ? 'Actualizando usuario...' : 'Registrando usuario...');
        api(config.empleados + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            body: payload
        }).then(function (response) {
            showToast(response.message, 'success');
            resetEmployeeForm();
            loadCatalogs();
            return loadEmployees();
        }).catch(function (error) {
            setStatus('No se pudo guardar el usuario.');
            showToast(error.message, 'error');
        }).finally(function () {
            button.disabled = false;
            button.textContent = qs('#employeeDatabaseId').value ? 'Guardar cambios' : 'Registrar usuario';
        });
    }

    function loadCatalogs() {
        return api(config.catalogos).then(function (payload) {
            fillDatalist('#departmentOptions', payload.data.departamentos);
            fillDatalist('#positionOptions', payload.data.puestos);
        }).catch(function () {});
    }

    function fillDatalist(selector, values) {
        var list = qs(selector);
        list.textContent = '';
        values.forEach(function (value) {
            var option = document.createElement('option');
            option.value = value;
            list.appendChild(option);
        });
    }

    function loadUsers() {
        if (!qs('#usersTable')) { return; }
        setStatus('Cargando usuarios autorizados...');
        return api(config.usuarios).then(function (payload) {
            state.users = payload.data.usuarios;
            renderUsers(state.users);
            qs('#userCount').textContent = state.users.length + (state.users.length === 1 ? ' usuario' : ' usuarios');
            setStatus('Usuarios autorizados: ' + state.users.length + '.');
        }).catch(function (error) {
            setStatus('No se pudieron cargar los usuarios.');
            showToast(error.message, 'error');
        });
    }

    function roleLabel(role) {
        return text(role, 'Sin perfil').replace('BioSync ', '');
    }

    function renderUsers(items) {
        var tbody = qs('#usersTable');
        tbody.textContent = '';
        if (!items.length) {
            emptyTable(tbody, 'No hay usuarios autorizados.', 4);
            return;
        }
        items.forEach(function (item) {
            var row = document.createElement('tr');
            row.className = 'is-selectable';
            row.tabIndex = 0;
            row.setAttribute('data-user-id', item.id);
            row.appendChild(makeCell(item.name));
            row.appendChild(makeCell(item.email));
            row.appendChild(makeCell(roleLabel(item.rol)));
            row.appendChild(makeCell(item.es_global ? 'Cuenta global' : 'BioSync'));
            row.addEventListener('click', function () { editUser(item.id); });
            row.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') { editUser(item.id); }
            });
            tbody.appendChild(row);
        });
    }

    function editUser(id) {
        var item = (state.users || []).find(function (user) { return String(user.id) === String(id); });
        if (!item) { return; }
        qsa('#usersTable tr').forEach(function (row) {
            row.classList.toggle('is-selected', row.getAttribute('data-user-id') === String(id));
        });
        qs('#userDatabaseId').value = item.id;
        qs('#userName').value = item.name || '';
        qs('#userEmail').value = item.email || '';
        qs('#userRole').value = item.rol_biosync || 'BioSync Administrador';
        qs('#userPassword').value = '';
        qs('#userPasswordConfirmation').value = '';
        qs('#userPassword').required = false;
        qs('#userPasswordConfirmation').required = false;
        qs('#passwordHint').textContent = 'dejar vacía para conservarla';
        qs('#userFormTitle').textContent = 'Editar usuario';
        qs('#saveUser').textContent = 'Guardar cambios';
        qs('#revokeUser').hidden = item.es_actual || item.es_global;
        setStatus('Editando acceso de ' + item.name + '.');
        if (window.innerWidth < 840) {
            qs('#userForm').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function resetUserForm() {
        if (!qs('#userForm')) { return; }
        qs('#userForm').reset();
        qs('#userDatabaseId').value = '';
        qs('#userRole').value = 'BioSync Operador';
        qs('#userPassword').required = true;
        qs('#userPasswordConfirmation').required = true;
        qs('#passwordHint').textContent = 'mínimo 8 caracteres';
        qs('#userFormTitle').textContent = 'Crear usuario';
        qs('#saveUser').textContent = 'Crear usuario';
        qs('#revokeUser').hidden = true;
        qsa('#usersTable tr').forEach(function (row) { row.classList.remove('is-selected'); });
        setStatus('Listo para crear una cuenta nueva.');
    }

    function saveUser(event) {
        event.preventDefault();
        var id = qs('#userDatabaseId').value;
        var password = qs('#userPassword').value;
        var confirmation = qs('#userPasswordConfirmation').value;
        if (password !== confirmation) {
            showToast('La confirmación de contraseña no coincide.', 'error');
            return;
        }
        var payload = {
            name: qs('#userName').value.trim(),
            email: qs('#userEmail').value.trim(),
            rol: qs('#userRole').value,
            password: password || null,
            password_confirmation: confirmation || null
        };
        var button = qs('#saveUser');
        button.disabled = true;
        button.textContent = 'Guardando...';
        setStatus(id ? 'Actualizando usuario...' : 'Creando usuario...');
        api(config.usuarios + (id ? '/' + id : ''), {
            method: id ? 'PUT' : 'POST',
            body: payload
        }).then(function (response) {
            showToast(response.message, 'success');
            resetUserForm();
            return loadUsers();
        }).catch(function (error) {
            setStatus('No se pudo guardar el usuario.');
            showToast(error.message, 'error');
        }).finally(function () {
            button.disabled = false;
            button.textContent = qs('#userDatabaseId').value ? 'Guardar cambios' : 'Crear usuario';
        });
    }

    function revokeUser() {
        var id = qs('#userDatabaseId').value;
        if (!id) { return; }
        var item = (state.users || []).find(function (user) { return String(user.id) === String(id); });
        if (!item || !window.confirm('¿Revocar el acceso de BioSync a ' + item.name + '?')) { return; }
        var button = qs('#revokeUser');
        button.disabled = true;
        api(config.usuarios + '/' + id + '/acceso', { method: 'DELETE' }).then(function (response) {
            showToast(response.message, 'success');
            resetUserForm();
            return loadUsers();
        }).catch(function (error) {
            showToast(error.message, 'error');
        }).finally(function () {
            button.disabled = false;
        });
    }

    function setDefaultDates() {
        var today = new Date();
        var start = new Date(today.getFullYear(), today.getMonth(), 1);
        qs('#reportFrom').value = localDate(start);
        qs('#reportTo').value = localDate(today);
    }

    function localDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }

    function loadReport() {
        var from = qs('#reportFrom').value;
        var to = qs('#reportTo').value;
        if (!from || !to) { return; }
        if (from > to) {
            showToast('La fecha inicial no puede ser mayor que la fecha final.', 'error');
            return;
        }
        setStatus('Generando reporte...');
        return api(config.reportes + '?desde=' + encodeURIComponent(from) + '&hasta=' + encodeURIComponent(to)).then(function (payload) {
            renderReport(payload.data);
            qs('#reportCount').textContent = payload.data.length + (payload.data.length === 1 ? ' día' : ' días');
            setStatus('Reporte generado: ' + payload.data.length + ' días.');
        }).catch(function (error) {
            setStatus('No se pudo generar el reporte.');
            showToast(error.message, 'error');
        });
    }

    function renderReport(items) {
        var tbody = qs('#reportTable');
        tbody.textContent = '';
        if (!items.length) {
            emptyTable(tbody, 'No hay asistencias en el rango seleccionado.', 4);
            return;
        }
        items.forEach(function (item) {
            var row = document.createElement('tr');
            row.appendChild(makeCell(displayDate(item.fecha, false)));
            row.appendChild(makeCell(item.registros));
            row.appendChild(makeCell(item.empleados));
            row.appendChild(makeCell(item.incompletos));
            tbody.appendChild(row);
        });
    }

    function testConnection(notify) {
        setStatus('Probando conexión...');
        api(config.resumen).then(function () {
            setConnection(true);
            setStatus('Conexión correcta.');
            if (notify) { showToast('Conexión correcta con la base central.', 'success'); }
        }).catch(function (error) {
            setConnection(false);
            setStatus('Sin conexión.');
            if (notify) { showToast(error.message, 'error'); }
        });
    }

    function bindEvents() {
        qsa('[data-view]').forEach(function (button) {
            button.addEventListener('click', function () { goToView(button.getAttribute('data-view')); });
        });
        qsa('[data-go]').forEach(function (button) {
            button.addEventListener('click', function () { goToView(button.getAttribute('data-go')); });
        });
        qsa('[data-tab]').forEach(function (button) {
            button.addEventListener('click', function () { activateTab(button.getAttribute('data-tab')); });
        });
        qs('#menuToggle').addEventListener('click', function () {
            if (qs('#biosyncApp').classList.contains('menu-open')) { closeMenu(); } else { openMenu(); }
        });
        qs('#sidebarOverlay').addEventListener('click', closeMenu);
        qs('#refreshHome').addEventListener('click', loadHome);
        qs('#datFile').addEventListener('change', function (event) { selectFile(event.target.files[0]); });
        qs('#uploadPoleo').addEventListener('click', uploadPoleo);
        qs('#refreshImports').addEventListener('click', loadServerData);
        qs('#employeeForm').addEventListener('submit', saveEmployee);
        qs('#newEmployee').addEventListener('click', resetEmployeeForm);
        qs('#searchEmployees').addEventListener('click', loadEmployees);
        qs('#employeeSearch').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') { event.preventDefault(); loadEmployees(); }
        });
        qs('#generateReport').addEventListener('click', loadReport);
        qs('#refreshReport').addEventListener('click', loadReport);
        qs('#testConnection').addEventListener('click', function () { testConnection(true); });
        if (qs('#userForm')) {
            qs('#userForm').addEventListener('submit', saveUser);
            qs('#newUser').addEventListener('click', resetUserForm);
            qs('#revokeUser').addEventListener('click', revokeUser);
        }
    }

    setDefaultDates();
    bindEvents();
    renderLocalRecords();
    loadHome();
}());
