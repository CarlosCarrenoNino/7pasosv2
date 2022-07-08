<?php

require('Conexion.php');
require ('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



$FECHA1 =  date('Y/m/d',strtotime($_POST['fecha-inicio-llamadas'])) ;
$FECHA2 = date('Y/m/d',strtotime($_POST['fecha-fin-llamadas'])) ;


if(isset($_POST['buttom-llamadas'])){

$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

$myparams['fecha_inicio'] = $FECHA1;
$myparams['fecha_fin'] = $FECHA2; 

 $procedure_params = array(
 array(&$myparams['fecha_inicio'], SQLSRV_PARAM_IN),
 array(&$myparams['fecha_fin'], SQLSRV_PARAM_IN)
);  
 

$sqlserver ="SELECT * from TBL_AREGACTIVIDAD_BOT_VTR WHERE (REG_DFEC_PASO0_BOT between '".$FECHA1."' AND '".$FECHA2."')";

$stmt = sqlsrv_query($conn, $sqlserver);

  $fila = 2;

  	$spread = new Spreadsheet();
	$spread->getProperties ()->setCreator("Descargue_Rut_Consultados")->setDescription("Descargue_Rut_Consultados");
	$spread->setActiveSheetIndex (0);

        $spread->getActiveSheet ()->setTitle ("Descargue_Rut_Consultados");  
		      
		$spread->getActiveSheet () -> setCellValue ('A1', 'USUARIO ANDES');
		$spread->getActiveSheet () -> setCellValue ('B1', 'SUPERVISOR');
		$spread->getActiveSheet () -> setCellValue ('C1', 'RUT');
		$spread->getActiveSheet () -> setCellValue ('D1', 'FECHA');
		$spread->getActiveSheet () -> setCellValue ('E1', 'HORA');
		$spread->getActiveSheet () -> setCellValue ('F1', 'RESULTADO PASO 0');
		$spread->getActiveSheet () -> setCellValue ('G1', 'RESULTADO PASO 1');
		$spread->getActiveSheet () -> setCellValue ('H1', 'RESULTADO PASO 2');
		$spread->getActiveSheet () -> setCellValue ('I1', 'RESULTADO PASO 3');
		$spread->getActiveSheet () -> setCellValue ('J1', 'RESULTADO PASO 4');
		$spread->getActiveSheet () -> setCellValue ('K1', 'RESULTADO PASO 5');
		$spread->getActiveSheet () -> setCellValue ('L1', 'RESULTADO PASO 6');
		$spread->getActiveSheet () -> setCellValue ('M1', 'RESULTADO PASO 7');
		$spread->getActiveSheet () -> setCellValue ('N1', 'PASO');
		$spread->getActiveSheet () -> setCellValue ('O1', 'SEGMENTO'); 
		
		
		$spread->getActiveSheet () -> setCellValue ('A2', print_r(sqlsrv_errors(),true));
			
			

		while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

			$REG_CJEFE_INMEDIATO = "";
			$REG_CUSUARIO_LABOR = $row['REG_CUSUARIO_LABOR'];
			$sqlserver_2 = "SELECT * FROM TBL_AREG_ASESOR_VTR WHERE REPLACE(REPLACE(REG_DETALLE_1, char(13), ''), char(10), '') = REPLACE(REPLACE('$REG_CUSUARIO_LABOR', char(13), ''), char(10), '')";
			$stmt_2 = sqlsrv_query($conn, $sqlserver_2);
			while($row_2=sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)){
				$REG_CJEFE_INMEDIATO = $row_2['REG_CJEFE_INMEDIATO'];
			}

			$spread->getActiveSheet () -> setCellValue ('A'.$fila, $REG_CUSUARIO_LABOR);
			$spread->getActiveSheet () -> setCellValue ('B'.$fila, $REG_CJEFE_INMEDIATO);
			$spread->getActiveSheet () -> setCellValue ('C'.$fila, $row['REG_CRUT_LABOR']);
			$spread->getActiveSheet () -> setCellValue ('D'.$fila, $row['REG_DFEC_PASO0_BOT']);
			$spread->getActiveSheet () -> setCellValue ('E'.$fila, $row['REG_CHOR_PASO0_BOT']);
			$spread->getActiveSheet () -> setCellValue ('F'.$fila, $row['REG_COBSERVACION_PASO0']);
			$spread->getActiveSheet () -> setCellValue ('G'.$fila, $row['REG_COBSERVACION_PASO1']);
			$spread->getActiveSheet () -> setCellValue ('H'.$fila, $row['REG_COBSERVACION_PASO2']);
			$spread->getActiveSheet () -> setCellValue ('I'.$fila, $row['REG_COBSERVACION_PASO3']);
			$spread->getActiveSheet () -> setCellValue ('J'.$fila, $row['REG_COBSERVACION_PASO4']);
			$spread->getActiveSheet () -> setCellValue ('K'.$fila, $row['REG_COBSERVACION_PASO5']);
			$spread->getActiveSheet () -> setCellValue ('L'.$fila, $row['REG_COBSERVACION_PASO6']);
			$spread->getActiveSheet () -> setCellValue ('M'.$fila, $row['REG_COBSERVACION_PASO7']);
			$spread->getActiveSheet () -> setCellValue ('N'.$fila, $row['REG_CDETALLE0']);
		 	$spread->getActiveSheet () -> setCellValue ('O'.$fila, $row['REG_CDETALLE1']); 		
					
            

			$fila++;

		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Informe_Rut_Consultados.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = IOFactory::createWriter($spread, 'Xlsx');
		$writer->save('php://output');


		




}?>