<?php

namespace Classes;


class Paginacion{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;


    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0)
    {
        $this->pagina_actual= (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    public function offset(){
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    public function total_paginas(){
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function pagina_ant(){
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function pagina_sig(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_ant(){
        $html = '';
        if($this->pagina_ant()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_ant()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function enlace_sig(){
        $html = '';
        if($this->pagina_sig()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_sig()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    public function numeros_pagina(){
        $html = '';

        for($i = 1; $i <= $this->total_paginas(); $i++){
            if($i === $this->pagina_actual){
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            }else {
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numeros\" href=\"?page={$i}\">{$i}</a>";
            }
        }
        return $html;
    }
    public function paginacion(){
        $html= '';

        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_ant();
            $html .= $this->numeros_pagina();
            $html .= $this->enlace_sig();
            $html .= '</div>';
        }
        return $html;
    }
}