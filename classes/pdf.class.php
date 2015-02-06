<?php
	namespace AF;
	
	class PDF extends \TCPDF {
		public function __construct() {
			parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$this->SetCreator('Adi Framework 1.0.0');
			$this->SetAuthor('Adrian Preuß');
			$this->setPrintHeader(false);
			$this->SetFooterMargin(PDF_MARGIN_FOOTER);
			$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$this->SetFont('helvetica', '', 10);
			$this->setBarcode(time());
			$this->AddPage();
		}
		
		public function display() {
			$this->Output('example_001.pdf', 'I');
		}
	}