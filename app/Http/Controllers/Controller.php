<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saber_dia($t_day)
    {
        $data = [];
        $data['dia'] = 0;
        $data['nombre_dia']="";
        $day = date("l", strtotime($t_day));
        switch ($day) {
            case "Sunday":
                $data['dia'] = 1;
                $data['nombre_dia'] = "Domingo";
                break;
            case "Monday":
                $data['dia'] = 2;
                $data['nombre_dia'] = "Lunes";
                break;
            case "Tuesday":
                $data['dia'] = 3;
                $data['nombre_dia'] = "Martes";
                break;
            case "Wednesday":
                $data['dia'] = 4;
                $data['nombre_dia'] = "Miercoles";
            break;
            case "Thursday":
                $data['dia'] = 5;
                $data['nombre_dia'] = "Jueves";
                break;
            case "Friday":
                $data['dia'] = 6;
                $data['nombre_dia'] = "Viernes";
                break;
            case "Saturday":
                $data['dia'] = 7;
                $data['nombre_dia'] = "Sabado";
            break;
        }

        return $data;

    }
}
