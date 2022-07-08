<?php

require('Conexion.php');
require ('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



$FECHA1 =  date('Y/m/d',strtotime($_POST['fecha-inicio-conectados'])) ;
$FECHA2 = date('Y/m/d',strtotime($_POST['fecha-fin-conectados'])) ;


if(isset($_POST['buttom-conectados'])){

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
/* ,[REG_CJEFE_INMEDIATO] */
,[CON_CSECPC_BOT]
,[CON_DFECREG_BOT]
,[CON_CHORREG_BOT]
,[CON_DFECACT_BOT]
,[CON_CHORACT_BOT]
/* ,[REG_DETALLE_2] */
,[CON_CDETALLES]
,[CON_CDETALLE0]
,[CON_CDETALLE1]
,[CON_CDETALLE2]
,[CON_CDETALLE3]
,[CON_CDETALLE4]
FROM TBL_ACONTROLLOG_BOT_VTR
/* join TBL_AREG_ASESOR_VTR on REPLACE(REPLACE(TBL_ACONTROLLOG_BOT_VTR.CON_CDETALLE1, char(13), ''), char(10), '') = REPLACE(REPLACE(TBL_AREG_ASESOR_VTR.REG_CCEDULA_ASESOR, char(13), ''), char(10), '')
 */ where /* REG_DETALLE_2='VOZ' and  */( CON_DFECACT_BOT
between '$FECHA1' and '$FECHA2') and (CON_CESTADO_BOT = 'Activo' or CON_CESTADO_BOT = 'Inactivo') 
order by CON_DFECREG_BOT asc";


$stmt = sqlsrv_query($conn, $sqlserver);

  $fila = 2;

  	$spread = new Spreadsheet();
	$spread->getProperties ()->setCreator("Descargue_Conectados")->setDescription("Descargue_Conectados");
	$spread->setActiveSheetIndex (0);

		
		$spread->getActiveSheet ()->setTitle ("Descargue_Conectados");       
		$spread->getActiveSheet () -> setCellValue ('A1', 'CEDULA');
		$spread->getActiveSheet () -> setCellValue ('B1', 'NOMBRE');
		$spread->getActiveSheet () -> setCellValue ('C1', 'USUARIO');
		$spread->getActiveSheet () -> setCellValue ('D1', 'SUPERVISOR'); 
		$spread->getActiveSheet () -> setCellValue ('E1', 'IP');
		$spread->getActiveSheet () -> setCellValue ('F1', 'POSICION');
		$spread->getActiveSheet () -> setCellValue ('G1', 'FECHA LOGIN');
		$spread->getActiveSheet () -> setCellValue ('H1', 'HORA LOGIN');
		$spread->getActiveSheet () -> setCellValue ('I1', 'FECHA LOGOUT');
		$spread->getActiveSheet () -> setCellValue ('J1', 'HORA LOGOUT');
		$spread->getActiveSheet () -> setCellValue ('K1', 'SEGMENTO');
		$spread->getActiveSheet () -> setCellValue ('L1', 'VERSION BOT');
		
		
		$spread->getActiveSheet () -> setCellValue ('A2', print_r(sqlsrv_errors(),true));
			
			

		while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){

			$REG_CJEFE_INMEDIATO = "";
			$CON_CDETALLE1 = $row['CON_CDETALLE1'];
			$sqlserver_2 = "SELECT * FROM TBL_AREG_ASESOR_VTR WHERE REPLACE(REPLACE(REG_CCEDULA_ASESOR, char(13), ''), char(10), '') = REPLACE(REPLACE('$CON_CDETALLE1', char(13), ''), char(10), '') /* and REG_DETALLE_2='VOZ' */";
			$stmt_2 = sqlsrv_query($conn, $sqlserver_2);
			while($row_2=sqlsrv_fetch_array($stmt_2, SQLSRV_FETCH_ASSOC)){
				$REG_CJEFE_INMEDIATO = $row_2['REG_CJEFE_INMEDIATO'];
			} 

			$spread->getActiveSheet () -> setCellValue ('A'.$fila, $row['CON_CDETALLE1']);
			$spread->getActiveSheet () -> setCellValue ('B'.$fila, $row['CON_CDETALLE2']);
 			$spread->getActiveSheet () -> setCellValue ('C'.$fila, $row['CON_CSECPC_BOT']);
  			$spread->getActiveSheet () -> setCellValue ('D'.$fila, $REG_CJEFE_INMEDIATO);
 			$spread->getActiveSheet () -> setCellValue ('E'.$fila, $row['CON_CIPPC_BOT']);
			$spread->getActiveSheet () -> setCellValue ('F'.$fila, $row['CON_CNOMPC_BOT']);
			$spread->getActiveSheet () -> setCellValue ('G'.$fila, $row['CON_DFECACT_BOT']);
			$spread->getActiveSheet () -> setCellValue ('H'.$fila, $row['CON_CHORACT_BOT']);
			$spread->getActiveSheet () -> setCellValue ('I'.$fila, $row['CON_DFECREG_BOT']);
			$spread->getActiveSheet () -> setCellValue ('J'.$fila, $row['CON_CHORREG_BOT']);
			$spread->getActiveSheet () -> setCellValue ('K'.$fila, $row['CON_CDETALLE0']);
 			$spread->getActiveSheet () -> setCellValue ('L'.$fila, $row['CON_CDETALLES']);		
					
            

			$fila++;

		}
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Informe_Conectados.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = IOFactory::createWriter($spread, 'Xlsx');
		$writer->save('php://output');


		




}?>