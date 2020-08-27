<?php

namespace App\Http\Middleware;
use App\TipoCambio;
use Carbon\Carbon;
use Closure;

class CheckTipoCambio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$consulta){
            return redirect()->route('tipo_cambio.create');
        }
        return $next($request);
    }
}
