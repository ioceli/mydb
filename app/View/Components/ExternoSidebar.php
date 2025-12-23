<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
class ExternoSidebar extends Component
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
        $this->title = $title ?? 'Panel de Usuario Externo';
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
                'label' => 'Registro de Planes',
                'route' => 'plan.index',
                'icon' => 'file-alt',
                'active' => request()->routeIs('plan.*'),
            ],
                        [
                'label' => 'Registro de Programas',
                'route' => 'programa.index',
                'icon' => 'folder-open',
                'active' => request()->routeIs('programa.*'),
            ],
                                    [
                'label' => 'Registro de Proyectos',
                'route' => 'proyecto.index',
                'icon' => 'project-diagram',
                'active' => request()->routeIs('proyecto.*'),
            ],
        ];
    }
    
    // 5. MÉTODO RENDER (obligatorio)
    public function render()
    {
        return view('components.externo-sidebar');
    }
}