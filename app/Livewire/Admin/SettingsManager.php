<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use WithFileUploads;

    public $gym_name;
    public $currency_symbol;
    public $logo;
    public $existing_logo_path;

    public function mount()
    {
        $this->gym_name = Setting::where('key', 'gym_name')->first()->value ?? config('app.name');
        $this->currency_symbol = Setting::where('key', 'currency_symbol')->first()->value ?? '$';
        $this->existing_logo_path = Setting::where('key', 'gym_logo')->first()->value ?? null;
    }

    public function render()
    {
        return view('livewire.admin.settings-manager')->layout('layouts.app');
    }

    public function save()
    {
        $this->validate([
            'gym_name' => 'required|string|max:255',
            'currency_symbol' => 'required|string|max:5',
            'logo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        Setting::updateOrCreate(['key' => 'gym_name'], ['value' => $this->gym_name]);
        Setting::updateOrCreate(['key' => 'currency_symbol'], ['value' => $this->currency_symbol]);

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            Setting::updateOrCreate(['key' => 'gym_logo'], ['value' => $path]);
            $this->existing_logo_path = $path;
            $this->logo = null; // Reset the file input
        }

        session()->flash('message', 'Configuración guardada con éxito.');

        // Forzar un refresco de la página para que el nuevo nombre/logo se vea en el layout
        $this->dispatch('settings-updated');
    }
}
