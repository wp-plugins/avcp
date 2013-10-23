<?php

$XML_ente_proponente = "Comune di San Pellegrino Terme";
$XML_data_aggiornamento =  date("Y-m-d");
$XML_anno_riferimento =  "2013";

$XML_FILE .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
$XML_FILE .= '
<legge190:pubblicazione xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:legge190="legge190_1_0" xsi:schemaLocation="legge190_1_0 datasetAppaltiL190.xsd">
<metadata>
<titolo>Pubblicazione 1 legge 190</titolo>
<abstract>Pubblicazione 1 legge 190 anno 1 rif. 2013</abstract>
<dataPubbicazioneDataset>2013-06-12</dataPubbicazioneDataset>
<entePubblicatore>' . $XML_ente_proponente . '</entePubblicatore>
<dataUltimoAggiornamentoDataset>' . $XML_data_ultimo_aggiornamento . '</dataUltimoAggiornamentoDataset>
<annoRiferimento>' . $XML_anno_riferimento . '</annoRiferimento>
<urlFile>' . get_site_url() . '/avcp.xml' . '</urlFile>
<licenza>IODL</licenza>
</metadata>
<data>
<lotto>
<cig>XXXXXXXXXX</cig>
<strutturaProponente>
<codiceFiscaleProp>XXXXXXXX</codiceFiscaleProp>
<denominazione>Comune di XXXXXXX</denominazione>
</strutturaProponente>
<oggetto>Stiamo lavorando per VOI</oggetto>
<sceltaContraente>
17-AFFIDAMENTO DIRETTO EX ART. 5 DELLA LEGGE N.381/91
</sceltaContraente>
<partecipanti>
<partecipante>
<codiceFiscale>XXXXXXXXXXX</codiceFiscale>
<ragioneSociale>XXXXXXXXX</ragioneSociale>
</partecipante>
</partecipanti>
<aggiudicatari>
<aggiudicatario>
<codiceFiscale>XXXXXX</codiceFiscale>
<ragioneSociale>XXXXXXXXX</ragioneSociale>
</aggiudicatario>
</aggiudicatari>
<importoAggiudicazione>XX.XX</importoAggiudicazione>
<tempiCompletamento>
<dataInizio>2013-01-01</dataInizio>
<dataUltimazione>2013-12-31</dataUltimazione>
</tempiCompletamento>
<importoSommeLiquidate>XX.XX</importoSommeLiquidate>
</lotto>
</data>
</legge190:pubblicazione>';

// Open or create a file (this does it in the same dir as the script)
$my_file = fopen("avcp.xml", "w");

// Write the string's contents into that file
fwrite($my_file, $XML_FILE);

// Close 'er up
fclose($my_file);

?>