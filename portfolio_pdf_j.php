<?
require_once('../common.php');
$g5['title'] = "현장체험학습보고서";

include_once(G5_THEME_MOBILE_PATH.'/head.renewal.pop.php');

?>

<script type="text/javascript">
//<![CDATA[
function calcHeight() {
  //find the height of the internal page

  var the_height =
    document.getElementById('the_iframe').contentWindow.
  document.body.scrollHeight;

  //change the height of the iframe
  document.getElementById('the_iframe').height =
    the_height;

  //document.getElementById('the_iframe').scrolling = "no";
  document.getElementById('the_iframe').style.overflow = "hidden";
}
//
</script>

<div class="layer-popup-area page">
  <!--header-->
  <?php include_once G5_THEME_MOBILE_PATH . '/head.title.pop.02.php'; ?>
  <div id="content">


    <?		
$view = get_view($write, $board, $board_skin_path);

$file_name = "eportfolio_".date('YmdHis').".pdf";
extract($view);

$decode_test = base64_decode($is_id);
$epilogue =  sql_fetch("select * from g5_shop_item_use where is_id = '".$decode_test."'");
$item =  sql_fetch("select * from g5_shop_item where it_id = '".$epilogue['it_id']."'");
$order = sql_fetch("select * from g5_shop_order where it_id = '".$epilogue['it_id']."' and mb_id ='".$epilogue['mb_id']."'");
$default_img="../theme/renewal/img/result_img.png";
if(!$item['it_img1']){
	$main_img = "../theme/renewal/img/result_img.png";
}
else{
	$main_img = "../data/item/{$item['it_img1']}";
}

if(!$epilogue['is_img1']){
	$epot_img1 = "../data/item/{$item['it_img1']}";

	if(!$item['it_img1']){
		$epot_img1 = "../theme/renewal/img/result_img.png";
	}
	else{
		$epot_img1 = "../data/item/{$item['it_img1']}";
	}
}
else{
	$epot_img1 = "../use_img/{$epilogue['is_img1']}";
}


if(!$epilogue['is_img2']){
	$epot_img2 = "../data/item/{$item['it_img2']}";

	if(!$item['it_img2']){
		$epot_img2 = "../theme/renewal/img/result_img.png";
	}
	else{
		$epot_img2 = "../data/item/{$item['it_img2']}";
	}
}
else{
	$epot_img2 = "../use_img/{$epilogue['is_img2']}";
}

if(!$epilogue['is_img3']){
	$epot_img3 = "../data/item/{$item['it_img3']}";
	if(!$item['it_img3']){
		$epot_img3 = "../theme/renewal/img/result_img.png";
	}
	else{
		$epot_img3 = "../data/item/{$item['it_img3']}";
	}
}
else{
	$epot_img3 = "../use_img/{$epilogue['is_img3']}";
}

$test_date = explode(' ',$epilogue['is_time']);
$test_year = explode('-',$test_date[0]);

// Include the main TCPDF library (search for installation path).
require_once('../plugin/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('ajaschool.com');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// IMPORTANT: disable font subsetting to allow users editing the document
$pdf->setFontSubsetting(false);

// set font
$pdf->SetFont('nanumbarungothicyethangul', '', 10);
//remove header footer line
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// add a page
$pdf->AddPage();

// -- set new background ---
if ($background_imgae != '') {
	// get the current page break margin
	$bMargin = $pdf->getBreakMargin();
	// get current auto-page-break mode
	$auto_page_break = $pdf->getAutoPageBreak();
	// disable auto-page-break
	$pdf->SetAutoPageBreak(false, 0);
	// set bacground image
	$img_file = K_PATH_IMAGES.'/image/'.$background_imgae;
	$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
	// restore auto-page-break status
	$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
	// set the starting point for the page content
	$pdf->setPageMark();
}
// create some HTML content
if($epilogue['epot_type'] == 1) {
$html = '
<table cellspacing="0" cellpadding="0" >

	<tr>
		<td style="width:43%;">
			<span style="font-size:25px;font-style:B;">아자스쿨 체험학습 보고서</span>
		</td>
		<td style="width:57%; border-bottom:3px solid #d2d2d2;"></td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr align="right">
		<td style="width:100%; font-size:12px; color:#747474;">www.ajaschool.com</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:23%;">
			<img src="'.$main_img.'" style="width:145px; height:145px;object-fit:fill">
		</td>
		<td style="width:5%; height:100%;"></td>
		<td style="width:72%; height:100%;">
			<div>
				<span style="font-size:18px;">'.$item['it_name2'].'</span>
			</div>
			<div style="">
				<span style="font-size:27px;color:#fa871c">'.$item['it_name'].'</span>
			</div>
			<div>
				<span style="font-size:14px; color:#747474;">보고서 작성일 : '.$test_year[0].'년 '.$test_year[1].'월 '.$test_year[2].'일</span>
			</div>
			<div>
				<span style="font-size:14px; color:#747474;">'.$order['od_b_name'].' 학생</span>
			</div>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:13%;">
			<img src="../img/ico_epot_date.png"style="width:10px;height:10px;">
			<span  style="font-size:13px;">체험일</span>
		</td>
		<td style="width:37%;">
			<span  style="font-size:12px;color:#747474;">'.$order['od_ajatime'].'</span>
		</td>
		<td style="width:13%;">
			<img src="../img/ico_epot_date.png"style="width:10px;height:10px;">
			<span  style="font-size:13px;">체험장소</span>
		</td>
		<td style="width:37%;">
			<span style="font-size:12px;color:#747474;">'.$item['it_basic'].'</span>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:60%;">
			<table cellspacing="0" cellpadding="0"> 
				<tr>
					<td>
						<img style="width:350px;height:250px; object-fit:fill;"src="'.$epot_img1.'">
					</td>
				</tr>
				<tr>
					<td style="width:49%;margin-right:10px;">
						<img style="width:162px;height:160px;object-fit:cover; "src="'.$epot_img2.'">
					</td>
					<td style="width:49%;">
						<img style="width:162px;height:160px; object-fit:cover;"src="'.$epot_img3.'">
					</td>
				</tr>
			</table>
		</td>

		<td style="width:35%; margin-left:2vw;">
			<div>
				<img src="../img/ico_epot_goal.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">교육 목표</span>
			</div>
			<div>
				<span style="font-size:12px;color:#747474;">'.nl2br($item['it_tail3_html']).'</span>
			</div>
			<div>
				<img src="../img/ico_epot_goal.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">교육 내용</span>
			</div>
			<div>
				<span style="font-size:12px;color:#747474;">'.nl2br($item['it_tail4_html']).'</span>
			</div>
			<div>
				<img src="../img/ico_epot_teacher.png"style="width:10px;height:10px;">
				<span style="font-size:13px;">교사 코멘트</span>
			</div>
			<div>
				<span style="font-size:12px;color:#747474;">'.nl2br($item['it_teacher_comment']).'</span>
			</div>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:100%;">
			<div>
				<img src="../img/ico_epot_student.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">학습자 코멘트</span>
			</div>
			<div>
				<span  style="font-size:12px;color:#747474;">'.nl2br($epilogue['is_content']).'</span>
			</div>
		</td>
	</tr>

</table>
';
} else {
$html = '
<table cellspacing="0" cellpadding="0" >

	<tr>
		<td style="width:43%;">
			<span style="font-size:25px;font-style:B;">아자스쿨 체험학습 보고서</span>
		</td>
		<td style="width:57%; border-bottom:3px solid #d2d2d2;"></td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr align="right">
		<td style="width:100%; font-size:12px; color:#747474;">www.ajaschool.com</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:23%;">
			<img src="'.$main_img.'" style="width:145px; height:145px;object-fit:fill">
		</td>
		<td style="width:5%; height:100%;"></td>
		<td style="width:72%; height:100%;">
			<div>
				<span style="font-size:18px;">'.$item['it_name2'].'</span>
			</div>
			<div style="">
				<span style="font-size:27px;color:#fa871c">'.$item['it_name'].'</span>
			</div>
			<div>
				<span style="font-size:14px; color:#747474;">보고서 작성일 : '.$test_year[0].'년 '.$test_year[1].'월 '.$test_year[2].'일</span>
			</div>
			<div>
				<span style="font-size:14px; color:#747474;">'.$order['od_b_name'].' 학생</span>
			</div>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:13%;">
			<img src="../img/ico_epot_date.png"style="width:10px;height:10px;">
			<span  style="font-size:13px;">체험일</span>
		</td>
		<td style="width:37%;">
			<span  style="font-size:12px;color:#747474;">'.$order['od_ajatime'].'</span>
		</td>
		<td style="width:13%;">
			<img src="../img/ico_epot_date.png"style="width:10px;height:10px;">
			<span  style="font-size:13px;">체험장소</span>
		</td>
		<td style="width:37%;">
			<span style="font-size:12px;color:#747474;">'.$item['it_basic'].'</span>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:50%;">
			<div>
				<img src="../img/ico_epot_goal.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">교육 목표</span>
			</div>
			<div>
				<span style="font-size:12px;color:#747474;">'.nl2br($item['it_tail3_html']).'</span>
			</div>
		</td>
		<td style="width:50%;">
			<div>
				<img src="../img/ico_epot_goal.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">교육 내용</span>
			</div>
			<div>
				<span  style="font-size:12px;color:#747474;">'.nl2br($item['it_tail4_html']).'</span>
			</div>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:31%;height:100%;backgrou">
			<img src="'.$epot_img1.'"style="width:300px; height:300px;object-fit:contain;">
		</td>
		<td style="width:3%;height:100%;"></td>
		<td style="width:31%;height:100%;">
			<img src="'.$epot_img2.'"style="width:300px; height:300px;object-fit:contain;">
		</td>
		<td style="width:3%;height:100%;"></td>
		<td style="width:31%;height:100%;">
			<img src="'.$epot_img3.'"style="width:300px; height:300px;object-fit:contain;">
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:100%;">
			<div>
				<img src="../img/ico_epot_teacher.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">교사 코멘트</span>
			</div>
			<div>
				<span  style="font-size:12px;color:#747474;">'.nl2br($item['it_teacher_comment']).'</span>
			</div>
		</td>
	</tr>

	<tr>
		<td style="width:100%; font-size:15px;border-bottom:1px solid #747474;"> </td>
	</tr>
	<tr>
		<td style="width:100%; font-size:15px;"> </td>
	</tr>

	<tr>
		<td style="width:100%;">
			<div>
				<img src="../img/ico_epot_student.png"style="width:10px;height:10px;">
				<span  style="font-size:13px;">학습자 코멘트</span>
			</div>
			<div>
				<span  style="font-size:12px;color:#747474;">'.nl2br($epilogue['is_content']).'</span>
			</div>
		</td>
	</tr>

</table>
';
}


// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
//echo $_SERVER['DOCUMENT_ROOT']."portfolio_pdf_file/".$file_name;
//Close and output PDF document
	
$pdf->Output($_SERVER['DOCUMENT_ROOT']."portfolio_view/portfolio_pdf_file/".$file_name, 'F');
//$pdf->Output($file_name, 'I');
//$pdf->Output($file_name, 'D');

//$pdf->Output('example_054.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
?>
    <iframe src="/portfolio_view/web/viewer.html?file=/portfolio_view/portfolio_pdf_file/<?= $file_name ?>"
      id="the_iframe" onload="calcHeight();" name="WrittenPublic" title="" frameborder="0" scrolling="no"
      style="overflow-x:hidden; overflow:auto; width:100%; min-height:900px;"></iframe>







  </div>
</div>

<?php include_once G5_THEME_MOBILE_PATH . '/tail.pop.php';
?>