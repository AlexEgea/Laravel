<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

class JwtService
{
    /**
     * Decodifica y verifica un token JWT.
     * Devuelve el payload como array o null si es inválido.
     */
    public static function decode(?string $token): ?array
    {
        if (!$token) {
            return null;
        }

        try {
            $secret = config('jwt.secret');
            $algo   = config('jwt.algo', 'HS256');

            // Decodificar y verificar firma
            $decoded = JWT::decode($token, new Key($secret, $algo));

            // stdClass -> array
            return (array) $decoded;
        } catch (Throwable $e) {
            // Aquí puedes loguear si quieres:
            // \Log::warning('JWT error: '.$e->getMessage());
            return null;
        }
    }

    /**
     * (Opcional) Generar un JWT desde el servidor.
     * Útil si algún día quieres emitir tokens tú.
     */
    public static function encode(array $payload): string
    {
        $secret = config('jwt.secret');
        $algo   = config('jwt.algo', 'HS256');

        return JWT::encode($payload, $secret, $algo);
    }
}
