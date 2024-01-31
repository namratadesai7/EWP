<?php
session_start();
// Include the PDF class
require_once "../package/TCPDF-main/tcpdf.php";
date_default_timezone_set('Asia/Kolkata');
  
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
    	$this->SetFont('times', 'B', 18);
    	$this->SetY(1);
        $this->SetX(2);
    	$this->Cell(0,5,'Internal Delivery Challan',0,0,'C');

    	$this->SetFont('times', 'B', 15);
        $this->SetX(2);
        $this->Cell(0, 14, '______________________________________________________________________________');	
        
          // Third line
        $this->SetY(10); // Adjust the Y position for the third line
        $this->SetX(2);
        $this->Cell(0, 10, 'SUYOG ELECTRICALS LTD.', 0, 0, 'C');

        $this->SetFont('times', 'B', 9);
        $this->SetY(17); // Adjust the Y position for the third line
        $this->SetX(2);
        $this->Cell(0, 10, '2204,2205,1701/2,G.I.D.C ESTATE,HALOL-389 350.', 0, 0, 'C');
      
        $this->SetFont('times', 'B', 15);
        $this->SetX(2);
        // $this->Cell(0, 14, '______________________________________________________________________________');	

     
        // // Add more lines as needed

        // // Set Y position for the next content (main body)
        // $this->SetY(40); // Adjust the Y position based on your needs
    }

    //Page footer
    public function Footer() {
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica','b', 8);
        $this->SetTextColor(153, 0, 0);
        /*$this->Cell(0, 10, '**This Is Computer Generated Report Signature Is Required**', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/
        // Page number
       $this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Gate Pass');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(1, 1, 5);//L T R
$pdf->SetHeaderMargin(3);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 2);
$pdf->AddPage();
// Logo

		//Set font
		$pdf->SetFont('helvetica', 'A', 10);
		include('../includes/dbcon.php');
        $id= $_GET['pdf'];
      
		$sql="SELECT From_Plant,To_Plant,Challanno,Date,No_of_core,corepair,ConductorType,Drum_No,Qnty,Stage,Name_of_contractor,Name FROM DShift where challanno='$id'";
        $run=sqlsrv_query($conn,$sql);
        $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

       
        $output = '<table style="width:100%; padding:4px;" border="1">
        <tr>
            <th><b>FROM:</b>' . $row['From_Plant'] . '</th>
            <th><b>TO:</b>' . $row['To_Plant'] . '</th>
        </tr>
        <tr>
            <th><b>SR. NO.</b>' . $row['Challanno'] . '</th>
            <th><b>Date:</b>' . $row['Date']->format('d-m-Y') . '</th>
        </tr>
        </table>';
        
        // Store initial $row data
        $initialRowData = $row;

        $output .= '<table style="width:100%; padding:4px;" border="1">
                <tr>
                    <th><b>Type of Drums:</b>' . $initialRowData['Stage'] . '</th>
                </tr>
                </table>
                <table style="padding:4px;" border="1">
                    <tr>
                        <th><b>DESCRIPTION OF MATERIALS</b></th>
                        <th><b>Drum No.</b></th>
                        <th><b>Quantity</b></th>
                    </tr>';

        // Assuming $run is the result of your SQL query
        while ($row = sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC)) {
        $output .= '<tr>
                        <th>' . $row['No_of_core'] . $row['corepair'] . ' X ' . $row['Sqmm'] . $row['ConductorType'] . '</th>
                        <td>' . $row['Drum_No'] . '</td>
                        <td>' . $row['Qnty'] . '</td>
                    </tr>';
        }

        $output .= '</table>';
        $output .= '<table style="padding:4px;"  border="1">
                    <tr>
                        <th><b>C.W./Vehicle:</b>' . $initialRowData['Name_of_contractor'] . '</th>
                        <th><b>Sign/Name:</b>' . $initialRowData['Name'] . '</th>
                    </tr>
        </table>';

            // <tr>
            // <th><b>C.W./Vehicle:</b>'. $row['Name_of_contractor'] .'</th>
            // <th><b>Sign/Name:</b>' .$row['Name']. '</th>
            // </tr>
		$pdf->SetFont("helvetica", "A", 10.5);						
		$pdf->SetY(27);
		$pdf->SetX(5);
		$pdf->writeHTML($output, true, false, false, false, 'C');


// Clean any content of the output buffer
ob_end_clean();

//Close and output PDF document
$pdf->Output('gatepass.pdf', 'I');

?>