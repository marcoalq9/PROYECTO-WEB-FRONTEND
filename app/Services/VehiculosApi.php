<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class VehiculosApi
{
    public function get(string $path, array $query = []): Response
    {
        return $this->request()->get($this->url($path), $query);
    }

    public function post(string $path, array $data = []): Response
    {
        return $this->request()->post($this->url($path), $data);
    }

    public function postWithFile(string $path, array $data, string $field, $file): Response
    {
        $request = $this->request();

        if ($file) {
            $request = $request->attach(
                $field,
                fopen($file->getRealPath(), 'r'),
                $file->getClientOriginalName()
            );
        }

        return $request->post($this->url($path), $data);
    }

    public function putWithFile(string $path, array $data, string $field, $file): Response
    {
        return $this->postWithFile($path, array_merge($data, ['_method' => 'PUT']), $field, $file);
    }

    public function put(string $path, array $data = []): Response
    {
        return $this->request()->put($this->url($path), $data);
    }

    public function patch(string $path, array $data = []): Response
    {
        return $this->request()->patch($this->url($path), $data);
    }

    public function delete(string $path): Response
    {
        return $this->request()->delete($this->url($path));
    }

    public function list(string $path, array $query = []): array
    {
        $response = $this->get($path, $query);

        if ($response->failed()) {
            return [];
        }

        $data = $response->json('data');

        return $data['data'] ?? $data ?? [];
    }

    public function item(string $path): ?array
    {
        $response = $this->get($path);

        if ($response->failed()) {
            return null;
        }

        return $response->json('data') ?? $response->json();
    }

    public function ok(Response $response): bool
    {
        return $response->successful();
    }

    public function error(Response $response, string $fallback = 'No se pudo completar la accion.'): string
    {
        $errors = $response->json('errors');

        if (is_array($errors)) {
            $first = collect($errors)->flatten()->first();

            if ($first) {
                return $first;
            }
        }

        return $response->json('message', $fallback);
    }

    public function vehicleStatusToApi(?string $status): int
    {
        return match ($status) {
            'Fuera de servicio' => 0,
            'Asignado' => 2,
            'Mantenimiento' => 3,
            default => 1,
        };
    }

    public function vehicleStatusToView(int|string|null $status): string
    {
        return match ((int) $status) {
            0 => 'Fuera de servicio',
            2 => 'Asignado',
            3 => 'Mantenimiento',
            default => 'Disponible',
        };
    }

    public function requestStatusToView(int|string|null $status): string
    {
        return match ((int) $status) {
            1 => 'Aprobada',
            2 => 'Rechazada',
            3 => 'Finalizada',
            4 => 'Cancelada',
            default => 'Pendiente',
        };
    }

    public function tripStatusToView(int|string|null $status): string
    {
        return match ((int) $status) {
            2 => 'Finalizado',
            0 => 'Cancelado',
            default => 'En curso',
        };
    }

    public function maintenanceStatusToView(int|string|null $status): string
    {
        return (int) $status === 0 ? 'Cerrado' : 'Abierto';
    }

    public function roleId(string $role): int
    {
        return match ($role) {
            'Administrador' => 1,
            'Operador' => 2,
            default => 3,
        };
    }

    public function roleName(int|string|null $roleId, ?array $role = null): string
    {
        return $role['role_name'] ?? match ((int) $roleId) {
            1 => 'Administrador',
            2 => 'Operador',
            default => 'Chofer',
        };
    }

    public function vehicleName(array $vehicle): string
    {
        $brand = $vehicle['brand'] ?? $vehicle['marca'] ?? '';
        $model = $vehicle['model'] ?? $vehicle['modelo'] ?? '';
        $plate = $vehicle['plate'] ?? $vehicle['placa'] ?? '';

        return trim("{$brand} {$model} ({$plate})");
    }

    public function vehicleImageUrl(array $vehicle): ?string
    {
        $image = $vehicle['image_url'] ?? $vehicle['image'] ?? $vehicle['imagen'] ?? null;

        if (! $image) {
            return null;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        return config('services.vehiculos.url') . '/storage/' . ltrim($image, '/');
    }

    public function dateForInput(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function dateTimeForInput(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    public function displayDate(?string $value): string
    {
        if (! $value) {
            return '';
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function displayDateTime(?string $value): string
    {
        if (! $value) {
            return '';
        }

        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    private function request()
    {
        return Http::acceptJson()
            ->withToken(session('api_token'))
            ->timeout(10);
    }

    private function url(string $path): string
    {
        return config('services.vehiculos.url') . '/api/' . ltrim($path, '/');
    }
}
