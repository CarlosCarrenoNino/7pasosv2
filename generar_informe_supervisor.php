<?php

require('Conexion.php');
require ('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



$FECHA1 =  date('Y/m/d',strtotime($_POST['fecha-inicio-supervisor'])) ;
$FECHA2 = date('Y/m/d',strtotime($_POST['fecha-fin-supervisor'])) ;

if(isset($_POST['buttom-supervisor'])){

$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

$myparams['fecha_inicio'] = $FECHA1;
$myparams['fecha_fin'] = $FECHA2; 

 $procedure_params = array(
 array(&$myparams['fecha_inicio'], SQLSRV_PARAM_IN),
 array(&$myparams['fecha_fin'], SQLSRV_PARAM_IN)
);  
 

$sqlserver ="SELECT 
[CON_NID_CONBOT]
,[CON_CESTADO_BOT]
,[CON_CIPPC_BOT]
,[CON_CNOMPC_BOT]
,[CON_CSECPC_BOT]
,[REG_CNOMBRE_ASESOR]
,[REG_CJEFE_INMEDIATO]
,[CON_DFECREG_BOT]
,[CON_CHORREG_BOT]
,[CON_DFECACT_BOT]
,[CON_CHORACT_BOT]
,[REG_DETALLE_2]
,[CON_CDETALLES]
,[CON_CDETALLE0]
,[CON_CDETALLE1]
,[CON_CDETALLE2]
,[CON_CDETALLE3]
,[CON_CDETALLE4]
FROM TBL_ACONTROLLOG_BOT_VTR 
join TBL_AREG_ASESOR_VTR on REPLACE(REPLACE(TBL_ACONTROLLOG_BOT_VTR.CON_CDETALLE1, char(13), ''), char(10), '') = REPLACE(REPLACE(TBL_AREG_ASESOR_VTR.REG_CCEDULA_ASESOR, char(13), ''), char(10), '')
where REG_DETALLE_2='VOZ' AND CON_DFECREG_BOT
between '$FECHA1' and '$FECHA2' order by CON_DFECREG_BOT"; 

$stmt = sqlsrv_query($conn, $sqlserver);

  $fila = 2;

  	$spread = new Spreadsheet();
	$spread->getProperties ()->setCreator("Descargue_X_SUPERVISOR_Voz")->setDescription("Descargue_X_SUPERVISOR_Voz");
	$spread->setActiveSheetIndex (0);

			$spread->getActiveSheet ()->setTitle ("Descargue_X_SUPERVISOR_Voz");  

     		$spread->getActiveSheet () -> setCellValue ('A1', 'CEDULA');
            $spread->getActiveSheet () -> setCellValue ('B1', 'NOMBRE');
            $spread->getActiveSheet () -> setCellValue ('C1', 'USUARIO');
            $spread->getActiveSheet () -> setCellValue ('D1', 'IP');
            $spread->getActiveSheet () -> setCellValue ('E1', 'POSICION');
            $spread->getActiveSheet () -> setCellValue ('F1', 'SUPERVISOR');
            $spread->getActiveSheet () -> setCellValue ('G1', 'FECHA');
            $spread->getActiveSheet () -> setCellValue ('H1', 'HORA LOGIN');
            $spread->getActiveSheet () -> setCellValue ('I1', 'HORA LOGOUT');
            $spread->getActiveSheet () -> setCellValue ('J1', 'SEGMENTO');
            $spread->getActiveSheet () -> setCellValue ('A2', print_r(sqlsrv_errors(),true));
		
		
		
			
			

		while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

			$spread->getActiveSheet () -> setCellValue ('A'.$fila, $row['CON_CDETALLE1']);
			$spread->getActiveSheet () -> setCellValue ('B'.$fila, $row['CON_CDETALLE2']);
			$spread->getActiveSheet () -> setCellValue ('C'.$fila, $row['CON_CSECPC_BOT']);
			$spread->getActiveSheet () -> setCellValue ('D'.$fila, $row['CON_CIPPC_BOT']);
			$spread->getActiveSheet () -> setCellValue ('E'.$fila, $row['CON_CNOMPC_BOT']);
			$spread->getActiveSheet () -> setCellValue ('F'.$fila, $row['REG_CJEFE_INMEDIATO']);
			$spread->getActiveSheet () -> setCellValue ('G'.$fila, $row['CON_DFECREG_BOT']);
			$spread->getActiveSheet () -> setCellValue ('H'.$fila, $row['CON_CHORACT_BOT']);
			$spread->getActiveSheet () -> setCellValue ('I'.$fila, $row['CON_CHORREG_BOT']);
			$spread->getActiveSheet () -> setCellValue ('J'.$fila, $row['REG_DETALLE_2']);		
					
            

			$fila++;

		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Informe_X_SUPERVISOR_Voz.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = IOFactory::createWriter($spread, 'Xlsx');
		$writer->save('php://output');


		




}?>