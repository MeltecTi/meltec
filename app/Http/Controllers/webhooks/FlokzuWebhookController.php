<?php

namespace App\Http\Controllers\webhooks;

use App\Http\Controllers\Controller;
use App\Models\KpiFlokzu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Queue\NullQueue;

class FlokzuWebhookController extends Controller
{
    public function testWebhook(Request $request)
    {
        $data = $request->all();
        $Payload = $data['Payload'];

        return response()->json($data);
    }

    public function testtwo(Request $request)
    {
        $data = $request->all();

        return response()->json($data);
    }

    public function apiPostTest(Request $request)
    {
        try {
            $data = $request->all();

            if (empty($data) || $data == null) {
                throw new Exception('No se encuentran datos');
            }
            /*
             * Obtener todos los datos de la instancia
            */

            $instance = $data['instancia'];

            /**  
             * Referencia del formulario y creador
             */

            $idForm = $instance['reference'];
            $dateCreated = $instance['dateCreated'];
            // $emailCreator = $instance['documentCreator'];

            // Data del formulario
            $nameResponsability = $data['name'];
            $directorResponsability = $data['director'];
            $comments = $data['observaciones'];
            $kpis = $data['kpi'];

            /**
             * Insercion de todos los KPI 
             */

            foreach ($kpis as $kpi) {
                $create = KpiFlokzu::create([
                    'form_reference_id' => $idForm,
                    'date_created' => $dateCreated,
                    'name' => $nameResponsability,
                    'director_email' => $directorResponsability,
                    'observations' => $comments,
                    'kpi_name' => $kpi['NOMBRE INDICADOR'],
                    'period' => $kpi['PERIODICIDAD'],
                    'percent' => $kpi['PORCENTAJE'],
                ]);
            }

            if (!$create) {
                throw new Exception('Error al almacenar los datos');
            }

            return response()->json([
                'success' => true,
                'code' => 201
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
