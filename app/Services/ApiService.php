<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8001/api');
    }

    private function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . Session::get('api_token'),
            'Accept'        => 'application/json',
        ];
    }

    public function get(string $endpoint, array $params = [])
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/{$endpoint}", $params);
        return $response->json();
    }

    public function post(string $endpoint, array $data = [])
    {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/{$endpoint}", $data);
        return $response->json();
    }

    public function put(string $endpoint, array $data = [])
    {
        $response = Http::withHeaders($this->headers())
            ->put("{$this->baseUrl}/{$endpoint}", $data);
        return $response->json();
    }

    public function patch(string $endpoint, array $data = [])
    {
        $response = Http::withHeaders($this->headers())
            ->patch("{$this->baseUrl}/{$endpoint}", $data);
        return $response->json();
    }

    public function delete(string $endpoint)
    {
        $response = Http::withHeaders($this->headers())
            ->delete("{$this->baseUrl}/{$endpoint}");
        return $response->json();
    }

    public function postPublic(string $endpoint, array $data = [])
    {
        $response = Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}/{$endpoint}", $data);
        return $response->json();
    }

    public function postWithFile(string $endpoint, array $data = [], string $fileField = null, $file = null)
    {
        $request = Http::withHeaders($this->headers());

        if ($fileField && $file) {
            $request = $request->attach(
                $fileField,
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $request->post("{$this->baseUrl}/{$endpoint}", $data);
        return $response->json();
    }
}