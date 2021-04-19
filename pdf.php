<?php
require_once('assets/pdf/vendor/autoload.php');
ob_start();
include("ws/getCurriculumVitae.php");
$html=ob_get_clean();
$style = file_get_contents("assets/css/stylePDF.css");
$mpdf = new \Mpdf\Mpdf([
'mode' => 'utf-8',
'orientation' => 0,
'margin_left' => -5,
'margin_right' => -5,
'margin_top' => 10,
'margin_bottom' => 10,
'margin_header' => 0,
'margin_footer' => 0,
]);
$mpdf->WriteHTML($style,1);
$mpdf->WriteHTML($html,2);
$mpdf->Output();
?>