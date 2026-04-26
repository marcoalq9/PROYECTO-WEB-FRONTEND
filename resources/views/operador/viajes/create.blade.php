@extends('layouts.dashboard')

@section('title', 'Registrar Salida')
@section('page_title', 'Registrar Salida de Vehículo')

@section('content')
<div class="row">
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-route me-1"></i> Registrar Salida</h3>
      </div>
      <form action="{{ route('operador.viajes.store') }}" method="POST">
        @csrf
        <div class="card-body">

          <div class="mb-3">
            <label class="form-label">Chofer <span class="text-danger">*</span></label>
            <select name="chofer_id" id="chofer_id" class="form-select @error('chofer_id') is-invalid @enderror">
              <option value="">-- Seleccione un chofer --</option>
              @foreach($choferes as $chofer)
                <option value="{{ $chofer['id'] }}"
                  {{ old('chofer_id') == $chofer['id'] ? 'selected' : '' }}>
                  {{ $chofer['nombre'] }}
                </option>
              @endforeach
            </select>
            @error('chofer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Vehículo <span class="text-danger">*</span></label>
            <select name="vehiculo_id" id="vehiculo_id" class="form-select @error('vehiculo_id') is-invalid @enderror" disabled>
              <option value="">-- Seleccione un vehículo --</option>
            </select>
            @error('vehiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div id="vehiculoSolicitudFeedback" class="invalid-feedback"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Ruta <small class="text-muted">(opcional)</small></label>
            <select name="ruta_id" id="ruta_id" class="form-select">
              <option value="">-- Sin ruta asignada --</option>
              @foreach($rutas as $ruta)
                <option value="{{ $ruta['id'] }}"
                  data-distancia="{{ $ruta['distancia'] ?? 0 }}"
                  {{ old('ruta_id') == $ruta['id'] ? 'selected' : '' }}>
                  {{ $ruta['nombre'] }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Fecha y Hora de Salida <span class="text-danger">*</span></label>
            <input type="text" name="fecha_salida"
                   id="fecha_salida"
                   class="form-control js-datetime @error('fecha_salida') is-invalid @enderror"
                   value="{{ old('fecha_salida', date('Y-m-d\TH:i')) }}">
            @error('fecha_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div id="fechaSolicitudFeedback" class="invalid-feedback"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Kilometraje de Salida <span class="text-danger">*</span></label>
            <input type="number" name="km_salida" min="0"
                   id="km_salida"
                   class="form-control @error('km_salida') is-invalid @enderror"
                   value="{{ old('km_salida') }}"
                   readonly
                   placeholder="Ej: 15000">
            @error('km_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Fecha y Hora de Llegada <small class="text-muted">(opcional)</small></label>
            <input type="text" name="fecha_llegada"
                   id="fecha_llegada"
                   class="form-control js-datetime @error('fecha_llegada') is-invalid @enderror"
                   value="{{ old('fecha_llegada') }}">
            @error('fecha_llegada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Kilometraje de Llegada <small class="text-muted">(opcional)</small></label>
            <input type="number" name="km_llegada" min="0"
                   id="km_llegada"
                   class="form-control @error('km_llegada') is-invalid @enderror"
                   value="{{ old('km_llegada') }}"
                   placeholder="Se calcula con la distancia de la ruta">
            @error('km_llegada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Observaciones <small class="text-muted">(opcional)</small></label>
            <textarea name="observaciones" rows="2" class="form-control"
                      placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-car me-1"></i> Registrar Salida
          </button>
          <a href="{{ route('operador.viajes.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-times me-1"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const oldDriverId = @json(old('chofer_id'));
    const oldVehicleId = @json(old('vehiculo_id'));
    const oldStartDate = @json(old('fecha_salida'));
    const oldStartKm = @json(old('km_salida'));
    const oldEndKm = @json(old('km_llegada'));
    const driverSelect = document.getElementById('chofer_id');
    const vehicleSelect = document.getElementById('vehiculo_id');
    const routeSelect = document.getElementById('ruta_id');
    const startInput = document.getElementById('fecha_salida');
    const endInput = document.getElementById('fecha_llegada');
    const startKmInput = document.getElementById('km_salida');
    const endKmInput = document.getElementById('km_llegada');
    const vehicleFeedback = document.getElementById('vehiculoSolicitudFeedback');
    const dateFeedback = document.getElementById('fechaSolicitudFeedback');
    const form = vehicleSelect.closest('form');
    let approvedRequests = [];

    const parseDate = (value) => {
      if (!value) {
        return null;
      }

      return new Date(String(value).replace(' ', 'T'));
    };

    const formatForInput = (value) => {
      if (!value) {
        return '';
      }

      return String(value).replace(' ', 'T').slice(0, 16);
    };

    const setStartDate = (value) => {
      const formattedValue = formatForInput(value);

      if (startInput._flatpickr) {
        startInput._flatpickr.setDate(formattedValue, true, 'Y-m-d\\TH:i');
      } else {
        startInput.value = formattedValue;
      }
    };

    const setEndDate = (value) => {
      const formattedValue = formatForInput(value);

      if (endInput._flatpickr) {
        endInput._flatpickr.setDate(formattedValue, true, 'Y-m-d\\TH:i');
      } else {
        endInput.value = formattedValue;
      }
    };

    const selectedRequest = () => {
      return requestsForSelection().find((request) => {
        return String(request.vehiculo_id) === String(vehicleSelect.value);
      });
    };

    const selectedRouteDistance = () => {
      const distance = Number(routeSelect.selectedOptions[0]?.dataset.distancia || 0);

      return Number.isFinite(distance) ? distance : 0;
    };

    const updateStartKm = () => {
      const request = selectedRequest();

      if (request && !oldStartKm) {
        startKmInput.value = Math.round(Number(request.kilometraje || 0));
      }
    };

    const updateEndKm = () => {
      if (oldEndKm) {
        return;
      }

      const startKm = Number(startKmInput.value || 0);
      const distance = selectedRouteDistance();

      endKmInput.value = distance > 0
        ? Math.round(startKm + distance)
        : '';
    };

    const setFieldError = (field, feedback, message) => {
      field.classList.toggle('is-invalid', Boolean(message));
      feedback.textContent = message || '';
    };

    const requestsForSelection = () => approvedRequests.filter((request) => {
      return String(request.vehiculo_id) === String(vehicleSelect.value);
    });

    const validateRequestDate = () => {
      if (!driverSelect.value || !vehicleSelect.value || !startInput.value) {
        setFieldError(startInput, dateFeedback, '');
        return true;
      }

      const selectedDate = parseDate(startInput.value);
      const isValid = requestsForSelection().some((request) => {
        const start = parseDate(request.fecha_inicio);
        const end = parseDate(request.fecha_fin);

        return selectedDate >= start && selectedDate <= end;
      });

      setFieldError(
        startInput,
        dateFeedback,
        isValid ? '' : 'La fecha y hora debe estar dentro de una solicitud aprobada para este chofer y vehiculo.'
      );

      return isValid;
    };

    const populateVehicles = (requests) => {
      vehicleSelect.innerHTML = '';

      if (!driverSelect.value) {
        vehicleSelect.disabled = true;
        vehicleSelect.add(new Option('-- Seleccione un chofer primero --', ''));
        setFieldError(vehicleSelect, vehicleFeedback, '');
        return;
      }

      if (requests.length === 0) {
        vehicleSelect.disabled = true;
        vehicleSelect.add(new Option('-- Sin vehiculos aprobados disponibles --', ''));
        setFieldError(vehicleSelect, vehicleFeedback, 'El chofer no tiene vehiculos aprobados disponibles.');
        return;
      }

      vehicleSelect.disabled = false;
      vehicleSelect.add(new Option('-- Seleccione un vehiculo --', ''));

      requests.forEach((request) => {
        const option = new Option(
          `${request.vehiculo} | ${formatForInput(request.fecha_inicio)} a ${formatForInput(request.fecha_fin)}`,
          request.vehiculo_id
        );

        option.dataset.start = request.fecha_inicio || '';
        option.dataset.end = request.fecha_fin || '';
        option.dataset.requestId = request.solicitud_id || '';
        option.dataset.mileage = request.kilometraje || 0;
        option.selected = String(oldVehicleId) === String(request.vehiculo_id);
        vehicleSelect.add(option);
      });

      if (!vehicleSelect.value && vehicleSelect.options.length > 1) {
        vehicleSelect.selectedIndex = 1;
      }

      setFieldError(vehicleSelect, vehicleFeedback, '');

      if (vehicleSelect.value && !oldStartDate) {
        setStartDate(vehicleSelect.selectedOptions[0]?.dataset.start || '');
      }

      if (vehicleSelect.value && !@json(old('fecha_llegada'))) {
        setEndDate(vehicleSelect.selectedOptions[0]?.dataset.end || '');
      }

      updateStartKm();
      updateEndKm();

      validateRequestDate();
    };

    const loadVehiclesForDriver = async () => {
      approvedRequests = [];

      if (!driverSelect.value) {
        populateVehicles([]);
        return;
      }

      vehicleSelect.disabled = true;
      vehicleSelect.innerHTML = '';
      vehicleSelect.add(new Option('-- Cargando vehiculos aprobados --', ''));
      setFieldError(vehicleSelect, vehicleFeedback, '');

      try {
        const url = `{{ url('/operador/viajes/chofer') }}/${driverSelect.value}/vehiculos-aprobados`;
        const response = await fetch(url, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
        });

        if (!response.ok) {
          throw new Error('No se pudieron cargar los vehiculos aprobados.');
        }

        const payload = await response.json();
        approvedRequests = payload.data || [];
        populateVehicles(approvedRequests);
      } catch (error) {
        vehicleSelect.innerHTML = '';
        vehicleSelect.add(new Option('-- Error al cargar vehiculos --', ''));
        setFieldError(vehicleSelect, vehicleFeedback, error.message);
      }
    };

    driverSelect.addEventListener('change', loadVehiclesForDriver);
    vehicleSelect.addEventListener('change', () => {
      setStartDate(vehicleSelect.selectedOptions[0]?.dataset.start || '');
      setEndDate(vehicleSelect.selectedOptions[0]?.dataset.end || '');
      updateStartKm();
      updateEndKm();
      validateRequestDate();
    });
    startInput.addEventListener('change', validateRequestDate);
    routeSelect.addEventListener('change', updateEndKm);

    form.addEventListener('submit', (event) => {
      if (!validateRequestDate()) {
        event.preventDefault();
      }
    });

    if (oldDriverId) {
      driverSelect.value = oldDriverId;
    }

    loadVehiclesForDriver();
  });
</script>
@endpush
