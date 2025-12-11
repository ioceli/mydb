<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminSidebar extends Component
{
    // 1. PROPIEDADES PÚBLICAS
    public $title;
    public $userRole;
    public $showUserSection;
    public $menus;
    
    // 2. CONSTRUCTOR - Recibe parámetros
    public function __construct(
        $title = null, 
        $userRole = null, 
        $showUserSection = true,
        $menus = null
    ) {
        $this->title = $title ?? 'Panel de Administración';
        $this->userRole = $userRole ?? 'Administrador del Sistema';
        $this->showUserSection = $showUserSection;
        
        // 3. LÓGICA DEL COMPONENTE
        $this->menus = $menus ?? $this->defaultMenus();
    }
    
    // 4. MÉTODOS PRIVADOS (lógica interna)
    private function defaultMenus()
    {
        return [
            [
                'label' => 'Gestión de Usuarios',
                'route' => 'persona.index',
                'icon' => 'users',
                'active' => request()->routeIs('persona.*'),
            ],
            [
                'label' => 'Gestión de Entidades',
                'route' => 'entidad.index',
                'icon' => 'building',
                'active' => request()->routeIs('entidad.*'),
            ],
        ];
    }
    
    // 5. MÉTODO RENDER (obligatorio)
    public function render()
    {
        return view('components.admin-sidebar');
    }
}