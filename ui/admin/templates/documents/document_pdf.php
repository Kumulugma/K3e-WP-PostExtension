<?php

//namespace k3e\ui\templates\growlist;

use TCPDF;

$filename = !empty(htmlentities($_POST['PostExtension']['document_pdf_name'])) ? htmlentities($_POST['PostExtension']['document_pdf_name']) : 'dokument_' . date('Y-m-d_H:i:s');
global $current_user;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($current_user->display_name);
$pdf->SetTitle($filename);
$pdf->SetSubject(__('Lista wpisów', 'k3e'));
$pdf->SetKeywords(__('lista, posty, wpisy', 'k3e'));

// set default header data
$pdf->SetHeaderData(null, null, $filename, null, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array('dejavusans', '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array('dejavusans', '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 7, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

$content = '<table border="1" style="width:100%;">';

$content .= '<thead>';
$content .= '<tr>';
$content .= '<td style="width: 10%"><b>Lp.</b></td>';
$content .= '<td style="width: 70%"><b>Wpis</b></td>';
$content .= '<td style="width: 10%"><b>Miniatura</b></td>';
$content .= '<td style="width: 10%"><b>Zdjęcia</b></td>';
$content .= '</tr>';
$content .= '</thead>';

$document = get_option(UIClassPostExtension::OPTION_POSTEXTENSION_DOCUMENT_CONTENT);

foreach ($document as $k => $item) {
    $content .= '<tr>';
    $content .= '<td style="width: 10%">' . $item['i'] . '</td>';
    $content .= '<td style="width: 70%">' . $item['name'] . '</td>';
    $content .= '<td style="width: 10%">' . ($item['thumbnail'] == '1' ? 'Tak' : '---') . '</td>';
    $content .= '<td style="width: 10%">' . $item['images'] . '</td>';
    $content .= '</tr>';
}

$content .= '</table>';
// Set some content to print
$html = <<<EOD
$content
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.

$file_path = wp_upload_dir()['path'] . '/' . sanitize_title($filename) . '.pdf';
$file_url = wp_upload_dir()['url'] . '/' . sanitize_title($filename) . '.pdf';
$pdf->Output($file_path, 'F');

$attr = [
    'post_type' => 'attachment',
    'post_mime_type' => 'application/pdf',
    'guid' => $file_url,
    'post_name' => $filename,
    'post_status' => 'inherit',
    'post_title' => $filename,
    'post_content' => $filename,
    'post_excerpt' => $filename,
];
$attach_id = wp_insert_post($attr);

add_post_meta($attach_id, '_wp_attached_file', substr(wp_upload_dir()['subdir'], 1) . '/' . sanitize_title($filename) . '.pdf');
add_post_meta($attach_id, UIClassPostExtension::OPTION_POSTEXTENSION_DOCUMENT, $filename);
//print_r($attach_id); /* ID is successfuly given, but DOES not show up in Media. Even tried omoitting the $post_id, even though it is totallay valid */
//============================================================+
// END OF FILE
//============================================================+




    