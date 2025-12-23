<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
class AutoridadSidebar extends Component
{
    // 1. PROPIEDADES PÚBLICAS
    public $title;
    public $userRole;
    public $showUserSection;
    public $menus;
    
    // 2. CONSTRUCTOR - Recibe parámetros
    public function __construct(
        $title = null, 
        $showUserSection = true,
        $menus = null
    ) {
        $this->title = $title ?? 'Panel de Autoridad';
        $this->userRole = Auth::check() ? Auth::user()->rol : null;
        $this->showUserSection = $showUserSection;
        
        // 3. LÓGICA DEL COMPONENTE
        $this->menus = $menus ?? $this->defaultMenus();
    }
    
    // 4. MÉTODOS PRIVADOS (lógica interna)
    private function defaultMenus()
    {
        return [
            [
                'label' => 'Gestión de Autoridad',
                'route' => 'autoridad.index',
                'icon' => 'users',
                'active' => request()->routeIs('autoridad.*'),
            ],
        ];
    }
    
    // 5. MÉTODO RENDER (obligatorio)
    public function render()
    {
        return view('components.autoridad-sidebar');
    }
}