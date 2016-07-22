<?php
	require_once('./asset/html2pdf/html2pdf.class.php');
	
	ob_start();
	
         $content = ob_get_contents();
        try
        {
    $html2pdf = new HTML2PDF('P', 'A4', 'en', false, 'ISO-8859-1'); 
    $html2pdf->setTestTdInOnePage(false);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $Filename = "../folder/".$name.".pdf";
    $html2pdf->Output($Filename, 'F');
        }
        catch(HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
 $content_print .= ob_get_clean(); // add the content for the next document and now delete the output buffer 

   echo "<br> $name ...done!";
    echo str_pad('',4096)."\n";    //display some results so the page won't stay blank for too long
    ob_flush();
    flush();
  //  }
echo "all done!";