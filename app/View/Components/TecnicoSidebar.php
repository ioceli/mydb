<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TecnicoSidebar extends Component
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
        $this->title = $title ?? 'Panel de Tecnico de Planificación';
        $this->userRole = $userRole ?? 'Técnico de Planificación';
        $this->showUserSection = $showUserSection;
        
        // 3. LÓGICA DEL COMPONENTE
        $this->menus = $menus ?? $this->defaultMenus();
    }
    
    // 4. MÉTODOS PRIVADOS (lógica interna)
    private function defaultMenus()
    {
        return [
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
        ];
    }
    
    // 5. MÉTODO RENDER (obligatorio)
    public function render()
    {
        return view('components.tecnico-sidebar');
    }
}