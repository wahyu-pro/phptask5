<?php

require_once 'simple_html_dom.php';

class Kompas{
	function get(){
		$html = file_get_contents('https://www.kompas.com/'); //get the html returned from the following url

		$kompas_doc = new DOMDocument();

		libxml_use_internal_errors(TRUE); //disable libxml errors

		if(!empty($html)){ //if any html is actually returned

			$kompas_doc->loadHTML($html);
			libxml_clear_errors(); //remove errors for yucky html

			$kompas_xpath = new DOMXPath($kompas_doc);

			//get all the h3's with an class article__title article__title--medium
			$kompas_row = $kompas_xpath->query('//h3[contains(@class, "article__title article__title--medium")]');

			if($kompas_row->length > 0){
				foreach($kompas_row as $row){
					echo "Title : ".$row->nodeValue . "\n";
					foreach ($row->firstChild->attributes as $url)
							{
								if ($url->name == 'href')
								{
									echo "Url : ".$url->value."\n \n";
								}
							}
				}
			}
		}
	}
}

$kompas = new Kompas();
$kompas->get();

?>