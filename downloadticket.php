
<?php
if(isset($_POST['clk'])){
  echo "clk clicked";
	downloadpdf();
}
function downloadpdf(){

$orderid =1001;
$quantity = $_COOKIE['qty'];
$papertype= $_COOKIE['paper'];
$printside = $_COOKIE['sides'];
// $prdetails = $_POST['txta'];



$pdf = new FPDF('P', 'mm', array(100,150));
$pdf -> AddPage();
$pdf -> SetFont('Arial','B',16);
$pdf -> Cell(40,10,'Online Web2Print');
$pdf -> SetFont('Arial','',10);
$pdf ->Ln();
$pdf -> Cell(40,40,'Order id:  '.$orderid);

$pdf -> Ln();
$pdf -> Cell(10,-5,'Quantity:  '.$quantity);
$pdf -> Ln();
$pdf -> Cell(10,-10,'Papertype:  '.$papertype);
$pdf -> Ln();
$pdf -> Cell(10,45,'Printsides:  '.$printside);
$pdf -> Ln();
// $pdf -> Cell(10,-30,'ProductDetails: '.$prdetails);

$pdf -> Output('F','C:/xampp/htdocs/OW2P/tickets/jobticket_'.$orderid.'.pdf',true)

//you can specify the pdf file output to a a file by giving additional parameters to the output functions; d for download
//and also the filename which you could give the file path to the where the pdf file is to be stored
// $pdf -> Output('F','ticket');
}
ob_end_flush();

?>
