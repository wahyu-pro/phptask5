<?php

require_once 'dompdf/autoload.inc.php';
require_once 'simple_html_dom.php';

use Dompdf\Dompdf;

class ComingSoon
{

	function __construct()
	{
		$this->getInfo();
	}

	function getInfo()
	{
		$html = file_get_html("http://www.cgv.id/en/loader/home_movie_list");
		$mainUrl = "https://www.cgv.id";
		$html = $html->find('a');
		$url = [];
		for ($i = 0; $i < count($html); $i++) {
			$getUrl = str_replace('\\', '', $html[$i]->attr['href']); // untuk mengganti backslash menjadi kosong
			$getUrl = str_replace('"', '', $getUrl); // untuk mengganti "" menajadi kosong
			$newUrl = $mainUrl . $getUrl;
			array_push($url, $newUrl);
		}

		$info = [];
		$groupInfo = [];

		for ($i = 0; $i < count($url); $i++) {
			$first = file_get_html($url[$i]);
			// membuat key dan element yang akan di masukan ke dalam variabel $group
			$info['title'] = $first->find('div.movie-info-title', 0)->plaintext;
			$info['info'] = $first->find('div.movie-add-info', 0)->innertext;
			$info['synopsis'] = $first->find('div.movie-synopsis', 0)->innertext;
			// $info['info'] = $first->find('div.synopsis-section', 0)->innertext;
			array_push($groupInfo, $info);
		}

		// save to pdf
		$this->save_to_pdf($groupInfo);
	}

	function save_to_pdf($info)
	{
		$infoFilm = "<body style='font-family:Arial'>";
		foreach ($info as $value) {
			$infoFilm .= "<hr>";
			$infoFilm .= $value['title'] . "<br>";
			$infoFilm .= "<hr>";
			$infoFilm .= $value['info'] . "<br>";
			$infoFilm .= $value['synopsis'] . "<br>";
			$infoFilm .= "<hr>";
		}
		$infoFilm .= "</body>";
		$pdf = new Dompdf();
		$pdf->load_html($infoFilm);
		$pdf->setPaper('A4', 'portrait');
		$pdf->render();

		$printOutput = $pdf->output();
		if (file_put_contents('infoFilm.pdf', $printOutput)) {
			echo "Data berhasil disimpan ke dalam PDF";
		}
	}
}

new ComingSoon();
