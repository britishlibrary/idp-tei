<!DOCTYPE html>
<html>

<!-- run with http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/Scripts/PHP/extract_and_save_tei_xml.php -->
 
<body>
 <?php
 
	$this_script = "http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/Scripts/PHP/extract_and_save_tei_xml.php";
	
	echo "<h4>Use ODBC to query 4D database with SQL</h4><p><em>Assumes 4D Server running with SQL server - for now that means has to be IDP Development setup).</em></p>";
	


//  $server = "localhost:19812"; // not used
//  $port = "19812"; // not used
//  $database = "IDP_DB_Development"; // not used (and not even mentioned in the DSN!)
  
	$dsn="IDP_DB_Development"; // using a simple DSN that has been configured running 64 bit ODBC Data Source (without a specific db!) works (but this does not specify a Database - it seems that is somehow implied by having started the SQL Server within the 4D application from a named project (which has its own db)
	$dsn="IDP_DB_Development_Eynsham"; // renamed to this
#	$dsn="IDP_DB_Development_at_BL_IDP_UG"; // OVERWRITE WHEN ON SITE AT BL (or anywhere - it uses localhost rather than a specific IP address)
	$dsn="IDP_DB_Development_on_localhost"; // renamed to this since works anywhere using localhost
	
#	$dsn="IDP_DB_Dev_Eynsham_v19";
	
	
#	$dsn="IDP_DB_Dev_on_localhost_v18"; // a v.18 version of same;
  # this version logs in as Administrator/Mansell since some versions of the code do not know about Julian Cook
  
  # $dsn="IDP 4D Test running SQL Server no"; # at http://193.60.214.52:19810 (no SQL connections allowed on current license in Test and Live, evne if start SQL Server there!!)
  
  
  # attempt with string specifying server/port/database
//  $dsn = "Driver={4D v19 ODBC Driver 64-bit};Server=$server;Database=$database;"; // this is almost correct
//	$dsn = "Driver={4D v19 ODBC Driver 64-bit};Server=$server";

//  $user="Julian Cook"; // I am not in all versions of the code so best to use Adminstrator
 // $password="JC";
	$user="Administrator";
	$password="Mansell";  
  
	echo "<p>Uses a DSN named <b>$dsn</b> which was probably set up by running ODBC Data Source Adminstrator (64-bit) and configuring the DSN with 4D v 18 ODBC Driver 64-bit with user <b>$user</b> and password <b>$password</b> on port <b>19812</b> (?) on <b>localhost</b></p><p>(Note: with named DSN configured there is no need to use 192.168.98.19:809 unlike REST access to IDP_DB_Development from script). WARNING: if receive error about On SQL Authentication failed in 4D Design > Explore > Methods > Database Methods > ON SQL Authentication - might need to delete (with minus icon) a blank authentication script!</p>";
	
   //storing connection id in $conn
	$conn=odbc_connect($dsn, $user, $password);
 
  //Checking connection id or reference
	if (!$conn)
	{
		echo "<p>Failed running odbc_connect to connect to DSN <b>$dsn</b>... </p>";
		echo (die(odbc_error()));
	}
	else
	{
		echo "<p>Connection to DSN <b>$dsn</b>... Successful!</p>";
	}
  
  
	$run_details_array = array();
  
	#### RUN 1 ####
	$run_details_array[1]['title'] = '[Catalogue] records';
	$run_details_array[1]['description'] = '[Catalogue] records';
	$run_report_filename = 'report_catalogue_blobs.html';
	$run_details_array[1]['report_file'] = 'D:/British Library/bl github group/bl_github_clones/idp-tei/reports/' . $run_report_filename ;
	$run_details_array[1]['report_url_localhost'] = 'http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/reports/' . $run_report_filename;	
	$run_details_array[1]['report_url_github'] = 'https://britishlibrary.github.io/idp-tei/reports/' . $run_report_filename ;	
	$run_details_array[1]['sql_string'] = "SELECT  A.`CatalogueID`, A.`Shortref`, A.`Type`, A.`UUID` FROM Catalogue AS A  ORDER BY A.`Shortref` ASC LIMIT 5000";
	$run_details_array[1]['subtotal_count_sw'] = "N";	# set to Y to have subtotals for change in all but final col value (assumed sorting on those first)	
	$run_details_array[1]['uuid_table'] = "";	# set to "Images" if want hyerlink for UUID value; otherwise leave blank
	$run_details_array[1]['report_cols'] = array();
	$run_details_array[1]['report_cols'][1] = "CatalogueID"; # 1st col should be unique
	$run_details_array[1]['report_cols'][2] = "Shortref";
	$run_details_array[1]['report_cols'][3] = "Type";
	$run_details_array[1]['report_cols'][4] = "UUID";

	#### RUN 2 ####
	$run_details_array[2]['title'] = '[Bibliography] records';
	$run_details_array[2]['description'] = '[Bibliography] records';
	$run_report_filename = 'report_bibliography_blobs.html';
	$run_details_array[2]['report_file'] = 'D:/British Library/bl github group/bl_github_clones/idp-tei/reports/' . $run_report_filename ;
	$run_details_array[2]['report_url_localhost'] = 'http://localhost/D_DRIVE_BRITISH_LIBRARY/bl github group/bl_github_clones/idp-tei/reports/' . $run_report_filename;	
	$run_details_array[2]['report_url_github'] = 'https://britishlibrary.github.io/idp-tei/reports/' . $run_report_filename ;	
	$run_details_array[2]['sql_string'] = "SELECT  A.`Short ref`, A.`Title`, A.`Author`, A.`UUID` FROM Bibliography AS A ORDER BY A.`Short ref` ASC LIMIT 5000";
	$run_details_array[2]['subtotal_count_sw'] = "N";	# set to Y to have subtotals for change in all but final col value (assumed sorting on those first)	
	$run_details_array[2]['uuid_table'] = "";	# set to "Images" if want hyerlink for UUID value; otherwise leave blank
	$run_details_array[2]['report_cols'] = array();
	$run_details_array[2]['report_cols'][1] = "Short ref"; # 1st col should be unique
	$run_details_array[2]['report_cols'][2] = "Title";
	$run_details_array[2]['report_cols'][3] = "Author";
	$run_details_array[2]['report_cols'][4] = "UUID";	

	
	# not used
	$form_value_mapping_array = array();
	$form_english_array = array();
	$catalogue_shortref_array = array();
	$image_text_title_array = array();
	$items_pressmark_array = array();
	
	# run report 1
	create_report_files_for_run_number(1, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array, $items_pressmark_array);


	# run report 2
	create_report_files_for_run_number(2, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array, $items_pressmark_array);	
	
	
	
	
	
  


  
  //Resource releasing
  odbc_close($conn);

  echo "<p>Closed the ODBC resource</p>";
  	
	
	
#--------------------------
#
function remove_cf_lf($text)
{
	$text =  preg_replace('/[\n\r\f]/', '', $text); 
		
	return $text;
	
}

#--------------------------
#
function replace_new_lines($text)
{
	$text =  preg_replace('/[\n\r\f]/', ' ', $text); 
		
	return $text;
	
}

#--------------------------
#
function encode_for_csv($text)
{
	$text =  preg_replace('/,/', '__COMMA__', $text); 
	$text =  preg_replace('/"/', '__QUOTE__', $text); 
		
	return $text;
	
}

#--------------------------
#
function encode_for_tsv($text)
{
	$text =  preg_replace('/\t/', '__TAB__', $text); 
	$text =  preg_replace('/"/', '__QUOTE__', $text); 
	$text =  preg_replace('/[\n\r\f]/', '__NL__', $text);
		
	return $text;
	
}

#--------------------------
#
function encode_for_html($text)
{
	$text =  preg_replace('/</', '&lt;', $text); 
	$text =  preg_replace('/>/', '&gt;', $text); 
	$text =  preg_replace('/[\n\r\f]/', ' ', $text);
		
	return $text;
	
}

#--------------------------
#
function encode_for_4d_update($text)
{
	$text =  preg_replace('/"/', '', $text); 
	$text =  preg_replace('/__QUOTE__/', '"', $text); 
	$text =  preg_replace('/__TAB__/', ' ', $text); 
	$text =  preg_replace('/__NL__/', ' ', $text); 

		
	return $text;
	
}


#--------------------------
#
function create_report_files_for_run_number($run_number, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array,  $items_pressmark_array)
{	
  
  
  
	$run_title = 						$run_details_array[$run_number]['title'];
	$run_description = 					$run_details_array[$run_number]['description'];
	$run_sql_string = 					$run_details_array[$run_number]['sql_string'];
	$run_report_file = 					$run_details_array[$run_number]['report_file'];
	$run_report_url_localhost = 		$run_details_array[$run_number]['report_url_localhost'];
	$run_report_url_github =	 		$run_details_array[$run_number]['report_url_github'];
	$fields_array = 					$run_details_array[$run_number]['report_cols'];
	$run_subtotal_count_sw =			$run_details_array[$run_number]['subtotal_count_sw'];
	$run_uuid_table =					$run_details_array[$run_number]['uuid_table'];
	
	$batch_update_twoway_file = "";
	$batch_update_twoway_forwards_file = "";
	$batch_update_twoway_reverse_file = "";
	$batch_update_twoway_url = "";
	$batch_update_twoway_forwards_url = "";
	$batch_update_twoway_reverse_url = "";	
	
	
	

		

	$date_and_time = date("Y-m-d h:i a");
	
	# get last modified datte for the IDP 4D .4DD file (we assume v.19)
	$IDP_4D_data_file =  "D:/British Library/IDP/4D/File Transfer from 4D/Data_v19/IDP_DB_Data.4DD";
	$date_and_time_4D_data = date ("Y-m-d h:i a", filemtime($IDP_4D_data_file));
	
  
	echo "<hr/>";
	
	$options_table = "
	<h4>Report run info</h4>
	<table border='1'>
	<tr><td>Current hard-coded run number:</td><td><span style='color:red;'><b>$run_number</b></span></td></tr>
	<tr><td>Title:</td><td><span style='color:red;'>$run_title</span></td></tr>
	<tr><td>Description:</td><td><span style='color:red;'>$run_description</span></td></tr>
	<tr><td>Script creating report:</td><td><b>$this_script</b></td></tr>
	<tr><td>Run date and time:</td><td><b>$date_and_time</b></td></tr>
	<tr><td>4D data (on Dev) last modified:</td><td><b>$date_and_time_4D_data</b> (WARNING: might have been copied over from Production long before that)</td></tr>
	<tr><td>4D data (on Dev) filename:</td><td><b>$IDP_4D_data_file</b> (WARNING: is possible we are in fact running SQL against a different dataset - e.g. if currently have 4D db open pointing at v.18 data rather than v.19 data</td></tr>
	
	<tr><td>SQL:</td><td><span style='color:red;'>$run_sql_string</span></td></tr>
	<tr><td>Subtotaling?:</td><td><span style='color:black;'>$run_subtotal_count_sw</span></td></tr>	
	<tr><td>UUID table:</td><td><span style='color:black;'>$run_uuid_table</span></td></tr>	
	<tr><td>Report file:</td><td><b>$run_report_file</b></td></tr>
	<tr><td>Report on locahost:</td><td><a target='REP_WIN' href='$run_report_url_localhost'>$run_report_url_localhost</a></td></tr>
	<tr><td>Report on Github:</td><td><a target='REP_WIN' href='$run_report_url_github'>$run_report_url_github</a></td></tr>
	</table>
	<hr/>";
	
	echo $options_table;
	

	
	
	
	// now data values for HTML report
	
	
	
	$output_html = "<html>\n<head>\n<title>$run_title</title></head>\n<body><h1>$run_title</h1><p>Report created: <b>$date_and_time</b> by script <b>$this_script</b>\n<p><em>WARNING: SQL for this report is run against 4D database on Dev machine - potentially this is out of date with Live</em></p><hr/>$options_table";
	

	
	
	// TWO DIFFERENT TYPES OR REPORT: 
	// standard (all cols, all rows)
	// counts summary (group by all but final col; only show count value not detailed rows)
	
	$output_html_table = "";

	if ($run_subtotal_count_sw == 'N') // standard report
	{
		
		
		$output_html_table  .= "<table border = '1' width='100%'>\n";
		

		
		$output_html_table  .= "<thead>\n<tr>\n";
		
		$output_html_table .= "<th>[seq]</th>\n";
		
		foreach ($fields_array as $key => $value)
			
		{
			
			$field_name = $value; // use this 2-step approach to specify col name with space
			$output_html_table .= "<th>$field_name</th>\n";
				
		}

		

		
		$output_html_table .= "</tr>\n</thead>\n<tbody>\n";
		
		
		$RecordSet = odbc_exec($conn, $run_sql_string);
		
		$seq = 0;
		
		while (odbc_fetch_row($RecordSet)) 
		{
			$output_html_row = "<tr>";
			$seq ++;
			
			$skip_output_sw = 'N';
			# for some reports we only write oout row if NOT in some other place

		
			
			$output_html_row .= "<td>[$seq]</td>";
			

			

			
			foreach ($fields_array as $key => $value)
			
			{
			
				$field_name = $value; // use this 2-step approach to specify col name with space
				
					
				
				$field_value = encode_for_html(odbc_result($RecordSet, $field_name));
				

				
				if (($field_name == 'Pressmark') or ($field_name == 'PressMark'))
				{
					
					# show corrupt data in ShortRef (see VS Code output for indication of bogus characters rather than truncation)
#					if ($field_value == "IOL Tib J 104")
#					{
#						$ShortRef_value_encoded = encode_for_html(odbc_result($RecordSet, 'ShortRef'));
#						$ShortRef_value_raw = odbc_result($RecordSet, 'ShortRef');
#						echo "<p>SPECIAL CASE: Pressmark $field_value has ShortRef $ShortRef_value_raw encoded as $ShortRef_value_encoded</p>";
#				
#					}


						$pressmark_url = "http://idp.bl.uk/database/oo_loader.a4d?pm=$field_value";
						$field_value = "<a target='OTH_WIN' href = '$pressmark_url'>$field_value</a>";

					

				}
				
				# 	http://idp.bl.uk/api/Images/getImageByUUID?UUID=16264E77E8514B33B961D5A11138FA58&imageType=_L
				
				if ($field_name == 'UUID') # 
				{
					if ($run_uuid_table == 'Images')
					{
						$uuid_url = "http://idp.bl.uk/api/Images/getImageByUUID?UUID=$field_value&imageType=_L";
						$field_value = "<a target='OTH_WIN' href = '$uuid_url'>$field_value</a>";
					}
				}
				
				
				$output_html_row .= "<td>$field_value</td>";
				
				
			
				
				
			}
			

			
			

				
			
			$output_html_row .= "</tr>\n";
			
			
			if ($skip_output_sw == 'N')
			{

				$output_html_table .= $output_html_row;
			}

		}

		

		$output_html_table .= "</tbody>\n</table>\n";
	
	}
	
	
	
	
	else // counts summary (group by all but final col; only show count value not detailed rows)
	{
		// find final col (the one we do NOT group upon)
		$num_cols = count($fields_array);
		$cnt = 0;
		$final_col_key = '??';
		$final_col_value = '??';
		foreach ($fields_array as $key => $value)
		{
			$cnt ++;
			if ($cnt == $num_cols)
			{
				$final_col_key = $key;
				$final_col_value = $value;
				
			}
			
		}
		

		echo "<p>Count style report. Final col (NOT grouped upon): key <b>$final_col_key</b> value <b>$final_col_value</b> </p>";
		
		$output_html_table  .= "<table border = '1'>\n<tr>\n";
		
		
		foreach ($fields_array as $key => $value)
			
		{
			
			$field_name = $value; // use this 2-step approach to specify col name with space
			
			if ($key == $final_col_key)
			{
				if ($run_number == 5) # report intended map
				{
					$output_html_table .= "<th>Intended Mapped English</th><th>Intended Mapped Form Value</th>\n";
				}
				
				$output_html_table .= "<th>COUNT ($final_col_value)</th>\n";
			}
			else
			{
				$output_html_table .= "<th>$field_name</th>\n";
			}
				
		}
		

		
		$output_html_table .= "</tr>\n";
		
		
		$RecordSet = odbc_exec($conn, $run_sql_string);
		
		$count = 0;
		
		$first_run_sw = 'Y';
		$group_change_sw = '';
		$prev_value_array = array();
		$curr_value_array = array();
		foreach ($fields_array as $key => $value)		
		{
	
			if ($key == $final_col_key)
			{		
			}
			else
			{
				$prev_value_array[$key] = '?';
				$curr_value_array[$key] = '?';
			}
				
		}		
		
		
		while (odbc_fetch_row($RecordSet)) 
		{
			
			

			# check for changes in any col rel to prev
			$group_change_sw = 'N';
			
			foreach ($fields_array as $key => $value)
			
			{
			
				$field_name = $value; // use this 2-step approach to specify col name with space
				$field_value = encode_for_html(odbc_result($RecordSet, $field_name));
				$curr_value_array[$key] = $field_value;
				
				if ($key == $final_col_key)
				{
				}
				else
				{
					if ($curr_value_array[$key] == $prev_value_array[$key])
					{
					}
					else
					{
						$group_change_sw = 'Y';
					}
				}
				
				
// NEED TO HANDLE CHANGES IN VALUE AND PRINTING OUT ONLY SUBTOTALS ON CHANGE 
				
				
//				$output_html_row .= "<td>$field_value</td>";
				
				
			}
			
			# if anything changed then write out prev, reinitialized prev values to current
			if ($first_run_sw == 'Y')
			{
				$first_run_sw = 'N';
				$count = 1;
				foreach ($curr_value_array as $key => $value)		
				{
					$prev_value_array[$key] = $value;
					
				}
			}
			else
			{
				if ($group_change_sw == 'Y')
				{

					
					$output_html_row = "<tr>";
					foreach ($prev_value_array as $key => $value)		
					{
						if ($key == $final_col_key)
						{}
						else
						{
							$output_html_row .= "<td>$value</td>";
						}
						
					}
					

					
					# add count
					$output_html_row .= "<td>$count</td>";
					
					$output_html_row .= "</tr>\n";
					
					$output_html_table .= $output_html_row;
		
					$count = 1;
					foreach ($curr_value_array as $key => $value)		
					{
						$prev_value_array[$key] = $value;
						
					}

				}				
					
				else
				{
					$count ++;
				}
			}
				

		}
		

		
		# finally print out last total
		$output_html_row = "<tr>";
		foreach ($prev_value_array as $key => $value)		
		{
			if ($key == $final_col_key)
			{}
			else
			{
				$output_html_row .= "<td>$value</td>";
			}
			
		}
		
	
		
		
		# add count
		$output_html_row .= "<td>$count</td>";
		
		
		
		$output_html_row .= "</tr>\n";
		
		$output_html_table .= $output_html_row;
		
	}
	

	
	
	
	
	
	# echo $output_html_table;
	
	$output_html .= $output_html_table . "</body>\n</html>\n";
	


	# https://stackoverflow.com/questions/4839402/how-can-i-write-a-file-in-utf-8-format#:~:text=php%20function%20writeUTF8File(%24filename%2C,(%24f)%3B%20%7D%20%3F%3E
	file_put_contents($run_report_file, "\xEF\xBB\xBF" . $output_html); # prepending this BOM code seems to force recognition as UTF8
#	file_put_contents($run_report_file, "" . $output_html); # prepending this BOM code seems to force recognition as UTF8
	
	echo "<p>HTML report file written to <b>$run_report_file</b></p>";
	echo "<p>View on localhost: <a target='REP_WIN' href='$run_report_url_localhost'>$run_report_url_localhost</a></p>";
	echo "<p>View on Github: <a target='REP_WIN' href='$run_report_url_github'>$run_report_url_github</a></p>";
	
	
}

#-------------------
#
function map_form_value($form_value_mapping_array, $old_form_value)
{
	$new_form_value = $old_form_value;
	
	if (array_key_exists($old_form_value, $form_value_mapping_array))
	{
		$new_form_value = $form_value_mapping_array[$old_form_value];
	}
	return $new_form_value;
}


#-------------------
# We find large number of chars are replaced by � NUL in at least this one SQL statement against Catalogue Entry
# this means we can not convert to true UTF since have lost info
function fix_bogus_shortref_chars($value)
{
	$fixed_value = $value;
	
#	$fixed_value = utf8_decode($fixed_value); // in theory the DSN is configured to return UTF8 but how come we have bogus chars?	
#	iconv("UTF-8", "UTF-8", $fixed_value);
#	ini_set('mbstring.substitute_character', "none"); # convert invalid to space
#	$fixed_value= mb_convert_encoding($fixed_value, 'UTF-8', 'UTF-8');

$fixed_value = preg_replace('/^TibetanChanTransli.*$/', 'TibetanChanTransliterations_2014', $fixed_value); # this seems to be the only one we still need to fix now we are skipping blank ShortRef records in SQL access of [Catalogue Records]

	return $fixed_value; # return WITHOUT fix
	
# the following were required before we skipped blank ShortRef records	
	$fixed_value = preg_replace('/^Matko_vanSchaik_20.*$/', 'Matko_vanSchaik_2013', $fixed_value); 
	$fixed_value = preg_replace('/^Dalton_vanSchaik_2.*$/', 'Dalton_vanSchaik_2005', $fixed_value);
	$fixed_value = preg_replace('/^Hartmann_Tudkeao_2.*$/', 'Hartmann_Tudkeao_2009', $fixed_value);
	$fixed_value = preg_replace('/^Karashima_Wille_20.*$/', 'Karashima_Wille_2006', $fixed_value);
	$fixed_value = preg_replace('/^PelliotTibetain_II.$/', 'PelliotTibetain_III', $fixed_value);
	$fixed_value = preg_replace('/^TibetanChanTransli.*$/', 'TibetanChanTransliterations_2014', $fixed_value);
	$fixed_value = preg_replace('/^vanSchaik_Doney_20.*$/', 'vanSchaik_Doney_2007', $fixed_value);	
	$fixed_value = preg_replace('/^vanSchaik_Galambos.*$/', 'vanSchaik_Galambos_2012', $fixed_value);	
	$fixed_value = preg_replace('/^McKillop_Burton_19.*$/', 'McKillop_Burton_1988', $fixed_value);	
#	$fixed_value = preg_replace('/^Needham_NRI2_5_12_.*$/', 'Needham_NRI2_5_12_1', $fixed_value); # warning some should be Needham_NRI2_5_12_4 so we comment out
	$fixed_value = preg_replace('/^Needham_NRI2_Libra.*$/', 'Needham_NRI2_Library_JNC1', $fixed_value);	
	$fixed_value = preg_replace('/^Skjaerv._2009$/', 'Skjaervø_2009', $fixed_value);	
	

	
	
	
	
	return $fixed_value;
}


#-------------------
#
function load_up_form_english_array($conn, $form_value_mapping_array)
{
	// return $form_english_array 
	// $form_english_array["FORM002100"] = "-Fotografi-";
	
	$form_english_array = array();
	
	$run_sql_string = "SELECT A.`Unique Identifier`, A.`English` FROM Concordance AS A WHERE A.`Field Type` = 'Form'";
	
	$RecordSet = odbc_exec($conn, $run_sql_string);
		
		
	while (odbc_fetch_row($RecordSet)) 
	{
		
		$form_value = odbc_result($RecordSet, 'Unique Identifier');
		$english = odbc_result($RecordSet, 'English');
		
		$form_english_array[$form_value] = $english;
		
#		echo "<p>Setting \$form_english_array[$form_value] = $english;</p>";
	}
	
	return $form_english_array;
	
}


#-------------------
#
function load_up_catalogue_shortref_array($conn)
{

	
	$catalogue_shortref_array = array();
	
	$run_sql_string = "SELECT A.`Shortref` FROM Catalogue AS A ";
	
	$RecordSet = odbc_exec($conn, $run_sql_string);
		
		
	while (odbc_fetch_row($RecordSet)) 
	{
		
		$Shortref_value = odbc_result($RecordSet, 'Shortref');
		
		$catalogue_shortref_array[$Shortref_value] = "Y";
		
		echo "<p>Loading [Catalogue]Shortref <b>$Shortref_value</b></p>\n";
		
	}
	
	return $catalogue_shortref_array;
	
}


#-------------------
# [Title Authority]English where [Texts]Pressmark and section = [Images]Pressmark and section and [Title Authority]Title Value = [Texts]Title Value
function load_up_image_text_title_array($conn)
{

	
	$image_text_title_array = array();
	
	$run_sql_string = "SELECT A.`UUID`, C.`English` FROM Images AS A, Texts AS B, `Title Authority` AS C WHERE A.`Pressmark and section` = B.`Pressmark and section` AND B.`Title Value` = C.`Title Value`";
	
	$RecordSet = odbc_exec($conn, $run_sql_string);
		
	$seq = 0;
		
	while (odbc_fetch_row($RecordSet)) 
	{
		$seq ++;
		
		$UUID_value = odbc_result($RecordSet, 'UUID');
		$English_value = odbc_result($RecordSet, 'English');
		
		$image_text_title_array[$UUID_value] = $English_value;
		
#		echo "<p>[$seq] Loading [Images] UUID <b>$UUID_value</b> with English title <b>$English_value</b></p>\n";
		
	}
	
	return $image_text_title_array;
	
}

#-------------------
# 
function load_up_items_pressmark_array($conn)
{

	
	$items_pressmark_array = array();
	
	$run_sql_string = "SELECT A.`Pressmark` FROM Items AS A";
	
	$RecordSet = odbc_exec($conn, $run_sql_string);
		
	$seq = 0;
		
	while (odbc_fetch_row($RecordSet)) 
	{
		$seq ++;
		
		$Pressmark_value = strtoupper(odbc_result($RecordSet, 'Pressmark'));
		
		$items_pressmark_array[$Pressmark_value] = "Y";
		

		
	}
	
	return $items_pressmark_array;
	
}
  
  
  
  ?>
 
</body>
</html>