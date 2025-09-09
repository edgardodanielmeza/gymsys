<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Membresia;
use App\Models\Miembro;
use App\Models\Asistencia;
use App\Models\Venta;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardManager extends Component
{
    // KPIs
    public $ingresosDelMes;
    public $nuevosMiembrosDelMes;
    public $asistenciasHoy;
    public $membresiasPorVencer;

    // Chart Data
    public $asistenciasChartData;
    public $ingresosChartData;

    public function mount()
    {
        $this->calculateKpis();
    }

    public function calculateKpis()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $today = Carbon::today();
        $nextWeek = Carbon::now()->addDays(7);

        // Ingresos del Mes (Pagos de Membresías + Ventas de Productos)
        $ingresosMembresias = Pago::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('monto');
        $ingresosVentas = Venta::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total');
        $this->ingresosDelMes = $ingresosMembresias + $ingresosVentas;

        // Nuevos Miembros del Mes
        $this->nuevosMiembrosDelMes = Miembro::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Asistencias Hoy
        $this->asistenciasHoy = Asistencia::whereDate('created_at', $today)->count();

        // Membresías por Vencer
        $this->membresiasPorVencer = Membresia::where('estado', 'activa')
            ->whereBetween('fecha_fin', [$today, $nextWeek])
            ->count();

        // Preparar datos para gráficos
        $this->prepareChartData();
    }

    public function prepareChartData()
    {
        // Asistencias de los últimos 30 días
        $asistencias = Asistencia::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $this->asistenciasChartData = [
            'labels' => $asistencias->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d/m')),
            'data' => $asistencias->pluck('count'),
        ];

        // Ingresos de los últimos 30 días
        $pagos = Pago::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(monto) as total'))->where('created_at', '>=', Carbon::now()->subDays(30))->groupBy('date')->orderBy('date', 'asc')->get()->keyBy('date');
        $ventas = Venta::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as total'))->where('created_at', '>=', Carbon::now()->subDays(30))->groupBy('date')->orderBy('date', 'asc')->get()->keyBy('date');

        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $dates->push(Carbon::now()->subDays($i)->format('Y-m-d'));
        }

        $ingresosData = $dates->map(function ($date) use ($pagos, $ventas) {
            $totalPagos = $pagos->has($date) ? $pagos->get($date)->total : 0;
            $totalVentas = $ventas->has($date) ? $ventas->get($date)->total : 0;
            return $totalPagos + $totalVentas;
        });

        $this->ingresosChartData = [
            'labels' => $dates->map(fn ($date) => Carbon::parse($date)->format('d/m')),
            'data' => $ingresosData,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-manager')->layout('layouts.app');
    }
}
