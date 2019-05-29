<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf_recibo_sueldo extends FPDF {
        var $cotizacion = null;
        
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
            $this->Image('assets/sistema/imagenes/plantillas/recibo.jpeg',0,0,210,297);
            
       }
       // El pie del pdf
       public function Footer(){
           
           
           //Posición: a 1,5 cm del final
            $this->SetY(-15);
            //Arial italic 8
            $this->SetFont('Courier','B',10);
            //Número de página
            //$this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
            
            
       }
       
       public function Pie($cot) {
           $this->cotizacion = $cot;
       }
    }
?>