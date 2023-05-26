<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<!-- run with http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/Scripts/PHP/test_xslt.php -->

<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
 <link rel=stylesheet type="text/css" href="http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/CSS/idp.css" media="screen">
 
 </head>
 
 
<body>
 <?php
 
 





	$this_script = "http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/Scripts/PHP/test_xslt.php";
	
	echo "<h4>Testing XSLT in PHP</h4>";
	
	$xml_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/Catalogue/Dalton_vanSchaik_2005.xml";
	$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/header_cat.xsl";
	
	echo "<p>Loading XML: <b>$xml_doc</b></p>";
	$xmldoc = new DOMDocument();
	$xmldoc->load($xml_doc);
	
	echo "<p>Loading XSL: <b>$xsl_doc</b></p>";
	$xsldoc = new DOMDocument();
	$xsldoc->load($xsl_doc);

	
	
	
	$result = get_xslt_result($xmldoc, $xsldoc);
	
	echo "<hr/>";
#	echo "<div style ='background-color:#D0D5BF;'>";
	echo "<div id='cattitle'>";
#	echo encode_html_chars($result);
	echo $result;
	echo "</div>";
	echo "<hr/>";	
	
	
	
	$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/intro_cat.xsl";
	
	echo "<p>Loading XSL: <b>$xsl_doc</b></p>";
	$xsldoc = new DOMDocument();
	$xsldoc->load($xsl_doc);

	$result = get_xslt_result($xmldoc, $xsldoc);
	
	echo "<hr/>";
	echo "<div style ='background-color:#D0D5BF;'>";
#
			
#	echo encode_html_chars($result);
	echo $result;
	echo "</div>";
	echo "<hr/>";	


	$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/list_cat.xsl";
	
	echo "<p>Loading XSL: <b>$xsl_doc</b></p>";
	$xsldoc = new DOMDocument();
	$xsldoc->load($xsl_doc);

	$result = get_xslt_result($xmldoc, $xsldoc);
	
	# fix links
	$result = fix_links_in_result($result);
	
	echo "<hr/>";
	echo "<div style ='background-color:#D0D5BF;'>";

#	echo encode_html_chars($result);
	echo $result;
	echo "</div>";
	echo "<hr/>";		
	
	
	$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/select_cat.xsl";
	
	# for this need to specify a parm: catalogueNumber
	
	echo "<p>Loading XSL: <b>$xsl_doc</b></p>";
	$xsldoc = new DOMDocument();
	$xsldoc->load($xsl_doc);

#	$result = get_xslt_result($xmldoc, $xsldoc);
	$parm_name = "catalogueNumber";
	$parm_value = "1";
	echo "<p>XSLT parm <b>$parm_name</b> set to value <b>$parm_value</b></p>";
	$result = get_xslt_result_with_parameter($xmldoc, $xsldoc, $parm_name, $parm_value);
	
	# fix links
	$result = fix_links_in_result($result);
	
	echo "<hr/>";
	echo "<div style ='background-color:#D0D5BF;'>";

#	echo encode_html_chars($result);
	echo $result;
	echo "</div>";
	echo "<hr/>";	
	


function get_xslt_result($xmldoc, $xsldoc)
{
	$xslt = new XSLTProcessor();

	libxml_use_internal_errors(true);
	$result = $xslt->importStyleSheet($xsldoc);
	if (!$result) {
		foreach (libxml_get_errors() as $error) {
			echo "Libxml error: {$error->message}\n";
		}
	}
	libxml_use_internal_errors(false);

	if ($result)
	{
		return ($xslt->transformToXML($xmldoc));

	}
	else
	{
		return "<p>something went wrong in XSTL - no result</p>";
	}
}

function get_xslt_result_with_parameter($xmldoc, $xsldoc, $parm_name, $parm_value)
{
	$xslt = new XSLTProcessor();

	libxml_use_internal_errors(true);
	$result = $xslt->importStyleSheet($xsldoc);
	if (!$result) {
		foreach (libxml_get_errors() as $error) {
			echo "Libxml error: {$error->message}\n";
		}
	}
	libxml_use_internal_errors(false);

	if ($result)
	{
		$xslt->setParameter('', $parm_name, $parm_value);
		return ($xslt->transformToXML($xmldoc));

	}
	else
	{
		return "<p>something went wrong in XSTL - no result</p>";
	}
}


function  fix_links_in_result($result)
{
	$idp_url = "http://idp.bl.uk";
	$result = preg_replace('/(oo_loader\.a4d)/', "$idp_url/database/$1", $result);
	$result = preg_replace('/(\/database\/bibliography)/', "$idp_url$1", $result);
	return $result;
}
	
function encode_html_chars($str)
{
	return htmlentities($str);
}

?>