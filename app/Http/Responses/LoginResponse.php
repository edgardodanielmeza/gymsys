<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Limpiar cualquier selección de sucursal anterior en la sesión
        session()->forget('selected_sucursal_id');
        session()->forget('selected_sucursal_nombre');

        return $request->wantsJson()
                    ? new JsonResponse('', 204)
                    : redirect()->route('sucursal.select');
    }
}
