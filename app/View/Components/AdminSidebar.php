<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

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
        $showUserSection = true,
        $menus = null
    ) {
        $this->title = $title ?? 'Panel de Administración';
        $this->userRole = Auth::check()
            ? Auth::user()->rol:null;
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
                        // Gestión de Planificación (submenu que muestra las opciones del Técnico de Planificación)
            [
                'label' => 'Gestión de Planificación',
                'route' => '',
                'icon' => 'layers',
                'active' => 
                    request()->routeIs('objetivoDesarrolloSostenible.*') ||
                    request()->routeIs('objetivoPlanNacional.*') ||
                    request()->routeIs('objetivoEstrategico.*') ||
                    request()->routeIs('metaEstrategica.*') ||
                    request()->routeIs('metaPlanNacional.*') ||
                    request()->routeIs('indicador.*'),
                'children' => [
                    [
                        'label' => 'Gestión de ODS',
                        'route' => 'objetivoDesarrolloSostenible.index',
                        'icon' => 'earth-americas',
                        'active' => request()->routeIs('objetivoDesarrolloSostenible.*'),
                    ],
                    [
                        'label' => 'Gestión de OPND',
                        'route' => 'objetivoPlanNacional.index',
                        'icon' => 'flag',
                        'active' => request()->routeIs('objetivoPlanNacional.*'),
                    ],
                    [
                        'label' => 'Gestión de Objetivos Estratégicos',
                        'route' => 'objetivoEstrategico.index',
                        'icon' => 'bullseye',
                        'active' => request()->routeIs('objetivoEstrategico.*'),
                    ],
                    [
                        'label' => 'Gestión de Metas Estratégicas',
                        'route' => 'metaEstrategica.index',
                        'icon' => 'chart-line',
                        'active' => request()->routeIs('metaEstrategica.*'),
                    ],
                    [
                        'label' => 'Gestión de Metas PND',
                        'route' => 'metaPlanNacional.index',
                        'icon' => 'chart-bar',
                        'active' => request()->routeIs('metaPlanNacional.*'),
                    ],
                    [
                        'label' => 'Gestión de Indicadores',
                        'route' => 'indicador.index',
                        'icon' => 'chart-pie',
                        'active' => request()->routeIs('indicador.*'),
                    ],
                ],
            ],
               [
                'label' => 'Gestión de Planes, Programas y Proyectos',
                'route' => '',
                'icon' => 'layers',
                'active' => 
                    request()->routeIs('plan.*') ||
                    request()->routeIs('programa.*') ||
                    request()->routeIs('proyecto.*'),
                'children' => [
                    [
                        'label' => 'Gestión de Planes',
                        'route' => 'plan.index',
                        'icon' => 'file-alt',
                        'active' => request()->routeIs('plan.*'),
                    ],
                    [
                        'label' => 'Gestión de Programas',
                        'route' => 'programa.index',
                        'icon' => 'folder-open',
                        'active' => request()->routeIs('programa.*'),
                    ],
                    [
                        'label' => 'Gestión de Proyectos',
                        'route' => 'proyecto.index',
                        'icon' => 'project-diagram',
                        'active' => request()->routeIs('proyecto.*'),
                    ],
                ],
            ],
            [
                'label' => 'Revisión – Primer Instancia',
                'route' => 'revision.index',
                'icon' => 'userss',
                'active' => request()->routeIs('revision.*'),
            ],
            [
                'label' => 'Aprobación – Última Instancia',
                'route' => 'autoridad.index',
                'icon' => 'usersss',
                'active' => request()->routeIs('autoridad.*'),
            ],
            [
                'label' => 'Auditoria',
                'route' => 'auditoria.index',
                'icon' => 'audit',
                'active' => request()->routeIs('auditoria.*'),
            ]
        ];
    }

    // 5. MÉTODO RENDER (obligatorio)
    public function render()
    {
        return view('components.admin-sidebar');
    }
}