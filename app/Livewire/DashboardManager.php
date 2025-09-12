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
    // KPIs Mensuales
    public $ingresosDelMes = 0;
    public $nuevosMiembrosDelMes = 0;
    public $asistenciasMes = 0;

    // KPIs Diarios
    public $nuevosMiembrosHoy= 0;
    public $asistenciasHoy = 0;
    public $ingresosCuotasHoy = 0;
    public $ingresosVentasHoy = 0;
    public $ingresosTotalHoy = 0;

    // KPIs Vencimientos
    public $membresiasPorVencer = 0; // Próximos 7 días
    public $vencimientosHoy = 0;

    // Chart Data
    public $asistenciasChartData;
    public $ingresosChartData;
     // Propiedades para el Modal
    public $modalVisible = false;
    public $modalTitle = '';
    public $modalData = [];
    public $modalHeaders = [];
    public function mount()
    {
        $this->calculateKpis();
    }

    private function initializeEmptyDashboard()
    {
        // Poner todos los KPIs a 0 o a un estado vacío por defecto
        $this->ingresosDelMes = 0;
        $this->nuevosMiembrosDelMes = 0;
        $this->asistenciasMes = 0;
        $this->asistenciasHoy = 0;
        $this->ingresosCuotasHoy = 0;
        $this->ingresosVentasHoy = 0;
        $this->ingresosTotalHoy = 0;
        $this->membresiasPorVencer = 0;
        $this->vencimientosHoy = 0;
        $this->asistenciasChartData = ['labels' => [], 'data' => []];
        $this->ingresosChartData = ['labels' => [], 'data' => []];
    }

    public function calculateKpis()
    {
        $sucursalId = session('selected_sucursal_id');

        if (!$sucursalId) {
            $this->initializeEmptyDashboard();
            return;
        }

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $nextWeek = Carbon::now()->addDays(7);

        // --- CÁLCULOS DIARIOS ---
        $this->nuevosMiembrosHoy = Miembro::where('sucursal_id', $sucursalId)
        ->whereDate('created_at', $today)
        ->count();
        $this->asistenciasHoy = Asistencia::where('sucursal_id', $sucursalId)
            ->whereDate('created_at', $today)->count();

        $this->ingresosCuotasHoy = Pago::whereDate('created_at', $today)
            ->whereHas('membresia', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->sum('monto');

        $this->ingresosVentasHoy = Venta::whereDate('created_at', $today)
            ->whereHas('caja', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->sum('total');

        $this->ingresosTotalHoy = $this->ingresosCuotasHoy + $this->ingresosVentasHoy;

        $this->vencimientosHoy = Membresia::where('sucursal_id', $sucursalId)
            ->where('estado', 'activa')
            ->whereDate('fecha_fin', $today)
            ->count();

        // --- CÁLCULOS MENSUALES ---
        $ingresosMembresiasMes = Pago::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereHas('membresia', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->sum('monto');

        $ingresosVentasMes = Venta::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereHas('caja', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->sum('total');

        $this->ingresosDelMes = $ingresosMembresiasMes + $ingresosVentasMes;

        $this->nuevosMiembrosDelMes = Miembro::where('sucursal_id', $sucursalId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $this->asistenciasMes = Asistencia::where('sucursal_id', $sucursalId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // --- CÁLCULOS VENCIMIENTOS ---
        $this->membresiasPorVencer = Membresia::where('sucursal_id', $sucursalId)
            ->where('estado', 'activa')
            ->whereBetween('fecha_fin', [$today->copy()->addDay(), $nextWeek]) // Excluye hoy
            ->count();

        // --- GRÁFICOS ---
        $this->prepareChartData($sucursalId);
    }

    public function prepareChartData($sucursalId)
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        // Asistencias Chart
        $asistencias = Asistencia::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('sucursal_id', $sucursalId)
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->groupBy('date')->orderBy('date', 'asc')->get();

        $this->asistenciasChartData = [
            'labels' => $asistencias->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('d/m')),
            'data' => $asistencias->pluck('count'),
        ];

        // Ingresos Chart
        $pagos = Pago::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(monto) as total'))
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->whereHas('membresia', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->groupBy('date')->orderBy('date', 'asc')->get()->keyBy('date');

        $ventas = Venta::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total) as total'))
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->whereHas('caja', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->groupBy('date')->orderBy('date', 'asc')->get()->keyBy('date');

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
       public function closeModal()
    {
        $this->modalVisible = false;
    }

    public function mostrarModal($dataType)
    {
        $sucursalId = session('selected_sucursal_id');
        if (!$sucursalId) return;

        $today = Carbon::today();
        $nextWeek = Carbon::now()->addDays(7);

        switch ($dataType) {
            case 'ingresosCuotasHoy':
                $this->modalTitle = 'Ingresos por Cuotas (Hoy)';
                $this->modalHeaders = ['Miembro', 'Monto', 'Hora'];
                $this->modalData = $this->getIngresosCuotasHoyData($sucursalId, $today);
                break;

            case 'ingresosVentasHoy':
                $this->modalTitle = 'Ingresos por Ventas (Hoy)';
                $this->modalHeaders = ['Cliente', 'Total Venta', 'Hora'];
                $this->modalData = $this->getIngresosVentasHoyData($sucursalId, $today);
                break;

             case 'ingresosVentasTotalHoy':
                $this->modalTitle = 'Ingresos  Totales (Hoy)';
                $this->modalHeaders = ['Cliente', 'Monto', 'Hora'];
                $this->modalData = $this->getIngresosVentasHoyData($sucursalId, $today);
                $this->modalData =$this->modalData+ $this->getIngresosCuotasHoyData($sucursalId, $today);
                break;


            case 'asistenciasHoy':
                $this->modalTitle = 'Asistencias de Hoy';
                $this->modalHeaders = ['Miembro', 'Hora de Entrada'];
                $this->modalData = $this->getAsistenciasHoyData($sucursalId, $today);
                break;

            case 'nuevosMiembrosHoy':
                $this->modalTitle = 'Nuevos Miembros de Hoy';
                $this->modalHeaders = ['Nombre', 'Email', 'Teléfono'];
                $this->modalData = $this->getNuevosMiembrosHoyData($sucursalId, $today);
                break;

            case 'vencimientosHoy':
                $this->modalTitle = 'Membresías que Vencen Hoy';
                $this->modalHeaders = ['Miembro', 'Tipo de Membresía', 'Fecha Fin'];
                $this->modalData = $this->getVencimientosHoyData($sucursalId, $today);
                break;

            case 'membresiasPorVencer':
                $this->modalTitle = 'Membresías por Vencer (Próximos 7 días)';
                $this->modalHeaders = ['Miembro', 'Tipo de Membresía', 'Fecha Fin'];
                $this->modalData = $this->getMembresiasPorVencerData($sucursalId, $today, $nextWeek);
                break;
        }

        $this->modalVisible = true;
    }
     private function getIngresosCuotasHoyData($sucursalId, $today)
    {
        return Pago::with('membresia.miembro')
            ->whereDate('created_at', $today)
            ->whereHas('membresia', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->get()
            ->map(fn($pago) => [
                $pago->membresia->miembro->nombres . ' ' . $pago->membresia->miembro->apellidos,
                ($GLOBALS['appSettings']['currency_symbol'] ?? '$') . number_format($pago->monto, 2),
                $pago->created_at->format('h:i A'),
            ])->toArray();
    }

    private function getIngresosVentasHoyData($sucursalId, $today)
    {
        return Venta::with('miembro')
            ->whereDate('created_at', $today)
            ->whereHas('caja', fn($q) => $q->where('sucursal_id', $sucursalId))
            ->get()
            ->map(fn($venta) => [
                $venta->miembro ? $venta->miembro->nombres . ' ' . $venta->miembro->apellidos : 'Cliente General',
                ($GLOBALS['appSettings']['currency_symbol'] ?? '$') . number_format($venta->total, 2),
                $venta->created_at->format('h:i A'),
            ])->toArray();
    }

    private function getAsistenciasHoyData($sucursalId, $today)
    {
        return Asistencia::with('miembro')
            ->where('sucursal_id', $sucursalId)
            ->whereDate('created_at', $today)
            ->get()
            ->map(fn($asistencia) => [
                $asistencia->miembro->nombres . ' ' . $asistencia->miembro->apellidos,
                $asistencia->created_at->format('h:i A'),
            ])->toArray();
    }

    private function getNuevosMiembrosHoyData($sucursalId, $today)
    {
        return Miembro::where('sucursal_id', $sucursalId)
            ->whereDate('created_at', $today)
            ->get()
            ->map(fn($miembro) => [
                $miembro->nombres . ' ' . $miembro->apellidos,
                $miembro->email,
                $miembro->telefono,
            ])->toArray();
    }

    private function getVencimientosHoyData($sucursalId, $today)
    {
        return Membresia::with('miembro', 'tipo')
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 'activa')
            ->whereDate('fecha_fin', $today)
            ->get()
            ->map(fn($membresia) => [
                $membresia->miembro->nombres . ' ' . $membresia->miembro->apellidos,
                $membresia->tipo->nombre,
                Carbon::parse($membresia->fecha_fin)->format('d/m/Y'),
            ])->toArray();
    }

    private function getMembresiasPorVencerData($sucursalId, $today, $nextWeek)
    {
        return Membresia::with('miembro', 'tipo')
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 'activa')
            ->whereBetween('fecha_fin', [$today->copy()->addDay(), $nextWeek])
            ->get()
            ->map(fn($membresia) => [
                $membresia->miembro->nombres . ' ' . $membresia->miembro->apellidos,
                $membresia->tipo->nombre,
                Carbon::parse($membresia->fecha_fin)->format('d/m/Y'),
            ])->toArray();
    }


}
