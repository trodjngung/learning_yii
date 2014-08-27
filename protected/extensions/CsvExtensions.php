<?php
class CsvExtensions extends CComponent {

	var $delimiter = ',';
	var $enclosure = '"';
	var $filename = 'Export.csv';
	var $zipFileName = 'Export.zip';
	var $line = array();
	var $buffer;
	var $zip;
	function CsvExtensions() {
		$this->clear();
	}

	function clear() {
		$this->line = array();
		$this->buffer = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');
	}

	function addField($value) {
		$this->line[] = $value;
	}

	function endRow() {
		$this->addRow($this->line);
		$this->line = array();
	}

	function addRow($row) {
		$this->_fputcsv($this->buffer, $row);
	}

	function renderHeaders() {
		header("Content-type:application/vnd.ms-excel");
		header("Content-disposition:attachment;filename=".$this->filename);
	}
	function renderZipHeaders() {
		header("Content-type:application/zip");
		header("Content-disposition:attachment;filename=".$this->zipFileName);
	}
	function setFilename($filename) {
		$this->filename = $filename;
		if (strtolower(substr($this->filename, -4)) != '.csv') {
			$this->filename .= '.csv';
		}
	}
	function setZipFilename($filename) {
		$this->zipFileName = $filename;
		if (strtolower(substr($this->zipFileName, -4)) != '.zip') {
			$this->zipFileName .= '.zip';
		}
	}
	function createZip($outputHeaders = true) {
		if ($outputHeaders) {
			if (is_string($outputHeaders)) {
				$this->setZipFilename($outputHeaders);
			}
		}
		$this->zip = new ZipArchive();
		$result = $this->zip->open($this->zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
		if ($result !== true) {  
			return false;
		}
		return true;
	}
	function addToZip($name = null, $to_encoding = null, $from_encoding = "auto") {
		rewind($this->buffer);
		$output = stream_get_contents($this->buffer);
		if ($to_encoding) {
			$output = mb_convert_encoding($output, $to_encoding, $from_encoding);
		}
		$this->zip->addFromString($name , $output);
	}
	function renderZip($to_encoding = null, $from_encoding = "auto") {
		$this->zip->close();
		$output = file_get_contents($this->zipFileName);
		$this->renderZipHeaders();
		unlink($this->zipFileName);
		return $output;
	}
	function render($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") {
		if ($outputHeaders) {
			if (is_string($outputHeaders)) {
				$this->setFilename($outputHeaders);
			}
			$this->renderHeaders();
		}
		rewind($this->buffer);
		$output = stream_get_contents($this->buffer);

		if ($to_encoding) {
			$output = mb_convert_encoding($output, $to_encoding, $from_encoding);
		}

		return $output;
	}
	
	function render1($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") {
		if ($outputHeaders) {
			if (is_string($outputHeaders)) {
				$this->setZipFilename($outputHeaders);
			}
		}
		$zip = new ZipArchive();
		$result = $zip->open($this->zipFileName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);  

		if ($result !== true) {  
			return false;
		}
		rewind($this->buffer);
		$output = stream_get_contents($this->buffer);
		if ($to_encoding) {
			$output = mb_convert_encoding($output, $to_encoding, $from_encoding);
		}
		$zip->addFromString("123.csv" , '3');
		$zip->addFromString("124.csv" , '4');
		$zip->close(); 
		
		$this->renderZipHeaders();
		
		$output = file_get_contents($this->zipFileName);
		
		return $output;
	}
	function _fputcsv($fp, $data) { 
		$csv = ''; 
		$i=0;
		foreach ($data as $col) {
			if ($i == 0) {
				if (strchr($col,',')) {
					$csv .= '"'.$col.'"';
				} else {
					$csv .= $col;
				}
			} else {
				$csv .= ',';
				if (strchr($col,',')) {
					$csv .= '"'.$col.'"';
				} else {
					$csv .= $col;
				}
			}
			$i = $i + 1;
		}
		fwrite($fp, $csv);
		fwrite($fp, "\r\n"); 
	}
}

