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

 // $user="Julian Cook"; // I am not in all versions of the code so best to use Adminstrator
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
  
	$global_file_stub_to_shortref_array = array();
  
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
	$run_details_array[1]['uuid_table'] = "Catalogue";	# set to "Images" if want hyerlink for UUID value; otherwise leave blank
	$run_details_array[1]['uuid_table_blobname'] = 'XMLBlob';
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
	$run_details_array[2]['uuid_table'] = "Bibliography";	# set to "Images" if want hyerlink for UUID value; otherwise leave blank
	$run_details_array[2]['uuid_table_blobname'] = 'XMLRecord';
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
#	create_report_files_for_run_number(1, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array, $items_pressmark_array, $global_file_stub_to_shortref_array);


	# run report 2
	create_report_files_for_run_number(2, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array, $items_pressmark_array, $global_file_stub_to_shortref_array);	
	
	
	
	# create index of TEI files - Catalogue
	$index_table = "Catalogue";
	$index_file = "index_tei_catalogue.html";
	$index_filename = "D:/British Library/bl github group/bl_github_clones/idp-tei/Pages/" . $index_file;
	$index_repo_tei_url = "https://britishlibrary.github.io/idp-tei/Pages/" . $index_file;
	$index_tei_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/" . $index_table;
	$index_repo_tei_url_stub = "https://britishlibrary.github.io/idp-tei/TEI/" . $index_table;
	$index_repo_html_url_stub = "https://britishlibrary.github.io/idp-tei/TEI_to_html/" . $index_table;
	
#	create_index_page_for_tei_files($index_table, $index_tei_folder, $index_repo_tei_url_stub, $index_filename, $index_repo_tei_url, $index_repo_html_url_stub, $global_file_stub_to_shortref_array, $this_script);
	
	# create index of TEI files - Bibliography
	$index_table = "Bibliography";
	$index_file = "index_tei_bibliography.html";
	$index_filename = "D:/British Library/bl github group/bl_github_clones/idp-tei/Pages/" . $index_file;
	$index_repo_tei_url = "https://britishlibrary.github.io/idp-tei/Pages/" . $index_file;
	$index_tei_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/" . $index_table;
	$index_repo_tei_url_stub = "https://britishlibrary.github.io/idp-tei/TEI/" . $index_table;
	$index_repo_html_url_stub = "https://britishlibrary.github.io/idp-tei/TEI_to_html/" . $index_table;
	
	create_index_page_for_tei_files($index_table, $index_tei_folder, $index_repo_tei_url_stub, $index_filename, $index_repo_tei_url, $index_repo_html_url_stub, $global_file_stub_to_shortref_array,$this_script);
	
  


  
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
function create_report_files_for_run_number($run_number, $run_details_array, $conn, $this_script, $form_value_mapping_array, $form_english_array, $catalogue_shortref_array, $image_text_title_array,  $items_pressmark_array, $global_file_stub_to_shortref_array)
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
	$run_uuid_table_blobname =			$run_details_array[$run_number]['uuid_table_blobname'];
	
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
	<tr><td>UUID table blobname:</td><td><span style='color:black;'>$run_uuid_table_blobname</span></td></tr>	
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
					
					# use REST to extract blob and save to file
					# zzz
					
					if ($run_uuid_table == 'Catalogue')
					{
						$rest_table = $run_uuid_table;
						$rest_uuid = $field_value;
						$rest_blobname = $run_uuid_table_blobname;
						$rest_save_filename = convert_shortref_to_filename($rest_table, odbc_result($RecordSet, 'Shortref'), $global_file_stub_to_shortref_array);
						call_rest_to_expand_xml_blob_and_save($rest_table, $rest_uuid, $rest_blobname, $rest_save_filename);
					}
					
					if ($run_uuid_table == 'Bibliography')
					{
						$rest_table = $run_uuid_table;
						$rest_uuid = $field_value;
						$rest_blobname = $run_uuid_table_blobname;
						$rest_save_filename = convert_shortref_to_filename($rest_table, odbc_result($RecordSet, 'Short ref'), $global_file_stub_to_shortref_array);
						call_rest_to_expand_xml_blob_and_save($rest_table, $rest_uuid, $rest_blobname, $rest_save_filename);
					}					
					
					
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
function convert_shortref_to_filename($table, $shortref, $global_file_stub_to_shortref_array)
{
	$filename = $shortref . ".xml";
	$filename_raw = $filename;
	
	$filename = preg_replace('/\s/', "_", $filename);
	$filename = preg_replace("/'/", "_", $filename);
	
	if ($filename_raw != $filename)
	{
		echo "<p>convert_shortref_to_filename() INFO: name from shortref <b>$filename_raw</b> has been modified to <b>$filename</b></p>\n";
	}
	
	$remove_xml = preg_replace('/\.xml/s','',$filename);
	$global_file_stub_to_shortref_array[$shortref] = $remove_xml;
	
	$filename  = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/$table/$filename";
	

	
	return $filename;
}

#------------------
#
function flip_filename_back_to_shortref($file_stub, $global_file_stub_to_shortref_array)
{
	$shortref = $file_stub;
	
	if (array_key_exists($file_stub, $global_file_stub_to_shortref_array))
	{
		$shortref = $global_file_stub_to_shortref_array[$file_stub];
	}
	
#	$shortref = preg_replace('/Afanas_ev_1975/','Afanas\'ev_1975',$shortref);
#	$shortref = preg_replace('/Berurin_Torufan_korekushon_1997/','Berurin Torufan korekushon_1997',$shortref);
#	$shortref = preg_replace('/Da_gu_guang_rui_1998/','Da gu guang rui 1998',$shortref);
#	$shortref = preg_replace('/Da_gu_guang_rui_1998/','Da gu guang rui 1998',$shortref);
	
	return $shortref;
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


#--------------------
#	
function use_curl_to_login_to_create_session_if_required($cookie_name, $cookie_file_path, $ip_and_port_REST, $global_dev_or_test_or_live_sw, $verbose)
{

	echo "<hr/>";
		
	# check existence and creation time of 4D cookie and only login if more than 2 hours old
#	$cookie_name = "4DSID_third_test.4dbase";
#	$cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/Test 4D application localhost/third_test.4dbase/demo_cookies/" . $cookie_name;
	$max_age_minutes_can_reuse_cookie = 60.0;
	
	
	if (file_exists($cookie_file_path))
	{
		$cookie_value = file_get_contents($cookie_file_path);
		$last_mod_date_time = date("F d Y H:i:s", filemtime($cookie_file_path));
		if ($verbose) echo "<p>4D session cookie <b>$cookie_file_path</b> was last modified: <b>$last_mod_date_time</b></p>";
		
	
		$current_date_time = date("F d Y H:i:s");
		if ($verbose) echo "<p>Current date and time: <b>$current_date_time</b></p>";
		
		$from_time = strtotime($last_mod_date_time); 
		$to_time = strtotime($current_date_time); 
		$cookie_age_minutes = round(abs($from_time - $to_time) / 60,1);
		if ($verbose) echo "<p>Difference in minutes (age of cookie): <b>$cookie_age_minutes</b> minutes</p>";
		
		if ( ($cookie_age_minutes - $max_age_minutes_can_reuse_cookie) < 0.0)
		{
			if ($verbose) echo "<p>Since cookie age <b>$cookie_age_minutes</b> (minutes) is less than maximum age </b>$max_age_minutes_can_reuse_cookie</b> (minutes) will NOT relogin - subsequent REST requests can reuse the current cookie (WARNING: if subsequent REST requests seem to fail (due to login failure) a good idea is to temporarily comment out the <b>return false;</b> statement in the PHP script, rerun current script - forcing a (re)login - then comment in that line once more so as avoid running out of licenses by logging in too many times - if that happens must stop and start the Web server in 4D)</p>";
			# HINT: comment this return false line out to force continuation so perform login attempt regardless of expiry (warning: will use up needless licenses and cause max sessions)
			# I find I sometimes need to do this when returning to this demo otherwise subsequent REST requests fail
			return false;  # HARD-CODED SWITCH (comment out temporarily?)
			
		}
		else
		{
			if ($verbose) echo "<p>4D session cookie <b>$cookie_file_path</b> has expired (older than <b>$max_age_minutes_can_reuse_cookie</b> minutes) so must login again</p>";
		}
	}
	else
	{
		if ($verbose) echo "<p>4D session cookie <b>$cookie_file_path</b> does not exist</p>";
	}
	
	if ($verbose) echo "<p>Will now perform login...</p>";
	
	
//	$rest_url = "http://127.0.0.1:809/rest/\$directory/login"; // see https://doc4d.github.io/docs/next/REST/authUsers suspect must provide email and password for a user in the POST
//	$rest_url = "http://192.168.98.19:809/rest/\$directory/login";  // IPv4 address from console ipconfig/all 
	$rest_url = "http://$ip_and_port_REST/rest/\$directory/login"; 
	// creates a coookie called 4DSID_third_test.4dbase in Edge > Settings > Cookies and site permissions > (first item)
	if ($verbose) echo "<p>Will use REST URL <b>$rest_url</b> (POSTed with login credentials) to login and so start a session. We must trap the returned cookie (in response header) and save it for use in later requests in order to maintain the same session.</p>";	
//	$json_ret = use_file_get_contents_for_rest_url($rest_url);	





	
	$url = $rest_url;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	
	
	# IMPORTANT: 4D credentials must be sent in the headers and NOT in the post data!
	# use the version for IDP_DB_Development
	$headers_idp_dev = array(
		"Accept: application/json",
		"Content-Type: application/json",
		"username-4D: Julian Cook",
		"password-4D: JC",
		"session-4D-length: 60"
	);
	
	# use the version for IDP Test
	$headers_idp_test = array(
		"Accept: application/json",
		"Content-Type: application/json",
		"username-4D: JulianCook",
		"password-4D: julian#123",
		"session-4D-length: 60"
	);
	
	# use the version for IDP Live
	$headers_idp_live = array(
		"Accept: application/json",
		"Content-Type: application/json",
		"username-4D: Julian Cook",
		"password-4D: JC",
		"session-4D-length: 60"
	);
	
	$headers = $headers_idp_dev;  # HARD-CODED SWITCH
	if ($global_dev_or_test_or_live_sw == 'T')
	{
		$headers = $headers_idp_test;
	}
	if ($global_dev_or_test_or_live_sw == 'L')
	{
		$headers = $headers_idp_live;
	}	
	
	echo "<p>Headers data (var_dump):</p>";
	var_dump($headers);
	
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // all important use of login details in HTTP request headers
	
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);

	// login data for POST - see form equivalent at https://doc4d.github.io/docs/next/REST/authUsers 
	// am not convinced this is working - the On REST Authentication method does not seem to be fed username-4D and password-4D as would expect
	
	# IMPORTANT: 4D credentials must be sent in the headers and NOT in the post data!
	
	$data = <<<DATA
	{
	  "username-4D": "Julian Cook",
	  "password-4D": "JC",
	  "session-4D-length": "60"
	}
	DATA;
	
	# version for IDP_DB_Development
	$data_json_idp_dev = <<<DATA
	{
	  "username-4D": "Julian Cook",
	  "password-4D": "JC"
	}
	DATA;
	
	# use the version for IDP Test
	$data_json_idp_test = <<<DATA
	{
	  "username-4D": "JulianCook",
	  "password-4D": "julian#123"
	}
	DATA;	
	
	# use the version for IDP Live
	$data_json_idp_live = <<<DATA
	{
	  "username-4D": "Julian Cook",
	  "password-4D": "JC"
	}
	DATA;	
	
	$data_json= $data_json_idp_dev; # HARD-CODED SWITCH
	if ($global_dev_or_test_or_live_sw == 'T')
	{
		$data_json= $data_json_idp_test;
	}
	if ($global_dev_or_test_or_live_sw == 'L')
	{
		$data_json= $data_json_idp_live;
	}		
	
	# $data_string = "username-4D=Julian%20Cook%password-4D=JC";
	
	echo "<p>POST data (but login details must be sent in headers NOT as post data) (var_dump):</p>";
	var_dump($data_json);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json); // not sure this achieves anything since must send login details in headers not as post data
#	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // use string NOT JSON
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADERFUNCTION, "HandleHeaderLine"); // to get response header

	$resp = curl_exec($ch);
	
	$headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
#	echo "<p>Curl headers (do they mention cookie?) (WARNING: these are the SENT headers rather than the response! for the response headers including set-cookie see function HandleHeaderLine):</p>";
#	print_r($headers);
	

#	echo "<p>DUMPING LOGIN RESPONSE:</p>";
#	var_dump($resp);

	
	curl_close($ch);

	
	return $resp;
}



#----------
# XML version expects XML from a blob (octet-stream) to be returned not JSON
function use_curl_for_rest_url_xml($rest_url, $cookie_name, $cookie_file_path, $verbose)
{
	$verbose_display = 'false';
	if ($verbose)
	{
		$verbose_display = 'true';
	}
#	echo "<p>TESTING in use_curl_for_rest_url() for \$rest_url <b>$rest_url</b> and \$verbose [<b>$verbose_display</b>] </p>";

	$ch = curl_init();
 
 # QN: do we need to force it to use the cookie 4DSID_third_test.4dbase for 127.0.0.1 ? Or can we in some other way tell the server who we are and it will go to the cookie and NOT begin a new session?

    curl_setopt($ch, CURLOPT_URL, $rest_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
#	$ckfile = "4DSID_third_test.4dbase"; # absolute path to hard-coded location of 4D session cookie
#	curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
#	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);

	# sending manually set cookie
#	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: 4DSID_third_test.4dbase=681973F18F6AF3428CD8A3AF8BEAC642")); # value from Edge cookie (created by browser
# sending cookies from file
#	$cookie_name = "4DSID_third_test.4dbase";
#	$cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/Test 4D application localhost/third_test.4dbase/demo_cookies/" . $cookie_name; # should have been created during initial call to login


# for XML from a blob use application/octet-stream NOT application/json
# we find this out using Postman to post http://192.168.98.19:809/rest/Catalogue[F91DF62E6B93462DB2E538F04B518FD6]/XMLBlob?$binary=true&$version=0&$expand=XMLBlob
#
# for info on cookies in 4D sessions see
# https://blog.4d.com/a-better-understanding-of-4d-rest-sessions/
# use Postman to view the cookie called WASID4D
# e.g. WASID4D=2FA348829C982F49BF96519AE10ABDC0; Path=/; Secure; HttpOnly; Expires=Mon, 15 May 2023 11:33:54 GMT;
	$cookie_value = file_get_contents($cookie_file_path);
	
	if ($verbose)
	{
		echo "<p>[use_curl_for_rest_url_xml] \$cookie_file_path: $cookie_file_path</p>";
		echo "<p>[use_curl_for_rest_url_xml] \$cookie_value from file is: $cookie_value</p>";
		echo "<p>[use_curl_for_rest_url_xml] \$cookie_name is: $cookie_name</p>";
	}

	$headers = array(
	   "Accept: application/octet-stream",
	   "Content-Type: application/octet-stream",
	   "Cookie: $cookie_name=$cookie_value"
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	
	# sending cookies from file
#	$cookie_name = "WASID4D";
#	$cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/demo_cookies/" . $cookie_name;
#	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);
	
#    curl_setopt($ch, CURLOPT_COOKIESESSION, false);	# dont know if has any effect
	
	
#	curl_setopt($ch,  CURLOPT_HEADER,  0); // CURLOPT_HEADER enables curl to include protocol header 
#	curl_setopt($ch,  CURLOPT_SSL_VERIFYPEER,  false); // CURLOPT_SSL_VERIFYPEER enables to fetch SSL encrypted HTTPS request.

	curl_setopt($ch, CURLOPT_HEADERFUNCTION, "HandleHeaderLine"); // to get response header

	$xml_ret = curl_exec($ch);
	
	$headers = curl_getinfo($ch, CURLINFO_HEADER_OUT);
#	echo "<p>Curl headers (do they mention cookie?) (WARNING: these are the SENT headers rather than the response! for the response headers including set-cookie see function HandleHeaderLine):</p>";
#	print_r($headers);


	
    curl_close($ch);
	
	
	# To test XML return we simply grab the results but without a cookie
#	$xml_ret = file_get_contents($rest_url);
	


	
	
	
	if ($verbose) echo "<p>Here is a dump of the (decoded) JSON returned by the URL (assuming max sessions error did not occur):</p>\n";
	
	if ($verbose) var_dump($xml_ret);
	

	
	return $xml_ret;
}

 

#--------------
#
function HandleHeaderLine( $curl, $header_line )
{
#    echo "<br>HandleHeaderLine() response header: ".$header_line; // or do whatever
	
	// check for Set-Cookie and if found write to a cookie file

	if ( preg_match('/Set-Cookie: ([^=]*)=([^;]*);/si', $header_line, $matches) )
	{
		$cookie_name = $matches[1];
		$cookie_value = $matches[2];
#		echo "<p>HandleHeaderLine() Header line in response: found set-cookie name: <b>$cookie_name</b> and set-cookie value: <b>$cookie_value</b></p>\n";

		#-------------
		// site-dependent HARD-CODING : HandleHeaderLine must match what is set in Globals
		// $cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/Test 4D application localhost/third_test.4dbase/demo_cookies/" . $cookie_name;	
		$cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/demo_cookies/" . $cookie_name; 
		#-------------
		
		echo "<p>[HandleHeaderLine] Writing cookie to $cookie_file_path</p>";
		file_put_contents($cookie_file_path, $cookie_value);
		
		$cookie_value = file_get_contents($cookie_file_path);
		echo "<p>[HandleHeaderLine] \$cookie_file_path: $cookie_file_path</p>";
		echo "<p>[HandleHeaderLine] \$cookie_value from file is: $cookie_value</p>";
		echo "<p>[HandleHeaderLine] \$cookie_name is: $cookie_name</p>";
		
	}
					
    return strlen($header_line);
}


#--------------
#
function getHttpCode($http_response_header)
{
    if(is_array($http_response_header))
	{
        $parts=explode(' ',$http_response_header[0]);
        if(count($parts)>1) //HTTP/1.0 <code> <text>
            return intval($parts[1]); //Get code
    }
    return 0;
}
  
  
  

#-------------------
# 
function call_rest_to_expand_xml_blob_and_save($rest_table, $rest_uuid, $rest_blobname, $rest_save_filename)
{
	
	echo "<p>call_rest_to_expand_xml_blob_and_save() called for <b>$rest_table</b>, <b>$rest_uuid</b>, <b>$rest_blobname</b>, <b>$rest_save_filename</b></p>";
		
	$global_dev_or_test_or_live_sw = "D"; # D or T or L or B (Dev while at BL) H (Bath)
	$dev_test_live_explain = "Dev";
	if ($global_dev_or_test_or_live_sw == "T")
	{
		$dev_test_live_explain = "Test";
	}
	if ($global_dev_or_test_or_live_sw == "L")
	{
		$dev_test_live_explain = "Live";
	}
	if ($global_dev_or_test_or_live_sw == "B")
	{
		$dev_test_live_explain = "Dev (at BL)";
	}
	if ($global_dev_or_test_or_live_sw == "H")
	{
		$dev_test_live_explain = "Dev (in Bath)";
	}	
	
 
 #----- IDP_DB_Development ------
	// note it is on D: drive (external SSD)
//	$cookie_name = "4DSID_IDP_DB_Development.4dbase";
	$cookie_name = "WASID4D";
	$cookie_file_path = "C:/BRITISH_LIBRARY/IDP/4D/demo_cookies/" . $cookie_name; // site-dependent HARD-CODING : HandleHeaderLine must match what is set in Globals
	$verbose = false;
	
	# 3 places for IDP_Dev
	$ip_and_port_REST_Localhost = "127.0.0.1:809"; // localhost (if NOT then as set in 4D Design > Settings > Web > Configuration)
	$ip_and_port_REST_IDP_Dev_Eynsham = "192.168.98.19:809"; // Eynsham (if NOT then as set in 4D Design > Settings > Web > Configuration)	
#	$ip_and_port_REST = "10.4.136.61:809"; // BL (AAC)
	$ip_and_port_REST_IDP_Dev_IPhone = "172.20.10.2:809"; // IPhone personal hotspot (>ipconfig/all read off IPv4)
	$ip_and_port_REST_IDP_Dev_BL_UG = "10.4.136.61:809"; // while at BL on UG
	$ip_and_port_REST_IDP_Dev_Bath = "192.168.1.133:809"; // while at BL in Bath
	
	# fixed IDP Test (should correspond to idptest.bl.uk although the latter does not always map - check if site is up using IP address NOT iptest...)
	$ip_and_port_REST_IDP_Test = "193.60.214.52:80";// IDP Test (in theory idptest.bl.uk but seem to need to specify IP address
	$ip_and_port_REST_IDP_Live = "193.60.214.31:80";// IDP Live
	 
	$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_Eynsham; # HARD-CODED SWITCH
	$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_IPhone; # HARD-CODED SWITCH
	$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_Bath; # HARD-CODED SWITCH
	
	if ($global_dev_or_test_or_live_sw == 'T')
	{
		$ip_and_port_REST = $ip_and_port_REST_IDP_Test;
	}	
	if ($global_dev_or_test_or_live_sw == 'L')
	{
		$ip_and_port_REST = $ip_and_port_REST_IDP_Live;
	}
	if ($global_dev_or_test_or_live_sw == 'B')
	{
		$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_BL_UG;
	}	
	if ($global_dev_or_test_or_live_sw == 'H')
	{
		$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_Bath;
	}
	if ($global_dev_or_test_or_live_sw == 'D')
	{
		$ip_and_port_REST = $ip_and_port_REST_IDP_Dev_Eynsham;
	}
	
	$verbose = false;
	
	$resp= use_curl_to_login_to_create_session_if_required($cookie_name, $cookie_file_path, $ip_and_port_REST, $global_dev_or_test_or_live_sw, $verbose);
	
	$rest_url = "http://" . $ip_and_port_REST . "/rest/" . $rest_table . "[" . $rest_uuid . "]/" . $rest_blobname . "?\$binary=true&\$version=0&\$expand=" . $rest_blobname;
	
	$verbose = false;
	$xml_ret = use_curl_for_rest_url_xml($rest_url, $cookie_name, $cookie_file_path, $verbose);	
	$verbose = false;
	
	$dom = new \DOMDocument('1.0');
	$dom->preserveWhiteSpace = true;
	$dom->formatOutput = true;
	$dom->loadXML($xml_ret);
	$xml_pretty = $dom->saveXML();
#	echo "<h4>The following is the XML (echo'd as HTML) - <span style='color:red;'>hint: View Source to see it in pretty XML format</span></h4><hr/>";
#	echo ($xml_pretty);

	file_put_contents($rest_save_filename, $xml_pretty);
	
	echo "<p>Wrote prettified contents of blob from REST call to <b>$rest_url</b> to file: <b>$rest_save_filename</b></p>";


	
}

#---------------
#
function create_index_page_for_tei_files($index_table, $index_tei_folder, $index_repo_tei_url_stub, $index_filename, $index_repo_tei_url, $index_repo_html_url_stub, $global_file_stub_to_shortref_array, $this_script)
{
	$output_html = "";
	$output_html .= "<html>\n<head>\n<title>Index TEI files type: $index_table</title>\n</head>\n<body>\n<h1>Index of TEI files type: $index_table</h1><p>These files contain a prettified version of the TEI XML extracted from the binary blob in table $index_table.</p><p>Index page created on JC PC using script: $this_script</p>\n";
	
	if ($index_table == "Catalogue")
	{
		$output_html .= "<p>The table below contains HTML created from the TEI XML using XSLT. Header is created using <b>header_cat.xsl</b>. Intro is created using <b>intro_cat.xsl</b>. List is created using <b>list_cat.xsl</b>. </p>";
	}
	elseif ($index_table == "Bibliography")
	{
		$output_html .= "<p>The table below contains HTML created from the TEI XML using XSLT, using <b>bibl.xsl</b>.</p>";
	}		


	$output_html .= "<table border = '1'>\n";
	
	if ($index_table == "Catalogue")
	{
		$output_html .= "<tr><th>TEI filename (based on short reference)</th> <th>Header HTML</th> <th>Intro HTML</th> <th>List HTML</th> <th>Subindex for Entry HTML</th> </tr>\n";
	}
	elseif ($index_table == "Bibliography")
	{
		$output_html .= "<tr><th>TEI filename (based on short reference)</th> <th>Bibl HTML</th> </tr>\n";
	}
	
	
	$scan = scandir($index_tei_folder);
	foreach($scan as $file) 
	{
		if (!is_dir("$index_tei_folder/$file")) 
		{
			$url = $index_repo_tei_url_stub . "/" . $file;
			if ($index_table == "Catalogue")
			{
				# create HTML using XSLT for various blocks of content
				
				# HEADER
				$xml_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/Catalogue/" . $file;

				$xmldoc = new DOMDocument();
				$xmldoc->load($xml_doc);
				
				$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/header_cat.xsl";
				$xsldoc = new DOMDocument();
				$xsldoc->load($xsl_doc);

				$result = get_xslt_result($xmldoc, $xsldoc);
				# fix links
				$result = fix_links_in_result($result);
				$result = "<div style ='background-color:#D0D5BF;'>" . $result . "</div>";
				
				$file_strip_xml = preg_replace("/\.xml$/", "", $file);
				$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Catalogue/$file_strip_xml";
				if (!is_dir($part_folder))
				{
					mkdir ($part_folder);
				}
				$header_file = "header.html";
				$html_file = $part_folder . "/" . $header_file;
				file_put_contents($html_file, $result);
				$header_url = $index_repo_html_url_stub . "/" . $file_strip_xml . "/" . $header_file;
				
				# INTRO
				$xml_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/Catalogue/" . $file;

				$xmldoc = new DOMDocument();
				$xmldoc->load($xml_doc);
				
				$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/intro_cat.xsl";
				$xsldoc = new DOMDocument();
				$xsldoc->load($xsl_doc);

				$result = get_xslt_result($xmldoc, $xsldoc);
				# fix links
				$result = fix_links_in_result($result);
				$result = "<div style ='background-color:#D0D5BF;'>" . $result . "</div>";
				
				$file_strip_xml = preg_replace("/\.xml$/", "", $file);
				$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Catalogue/$file_strip_xml";
				if (!is_dir($part_folder))
				{
					mkdir ($part_folder);
				}
				$intro_file = "intro.html";
				$html_file = $part_folder . "/" . $intro_file;
				file_put_contents($html_file, $result);	
				$intro_url = $index_repo_html_url_stub . "/" . $file_strip_xml . "/" . $intro_file;

				# LIST
				$xml_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/Catalogue/" . $file;

				$xmldoc = new DOMDocument();
				$xmldoc->load($xml_doc);
				
				$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/list_cat.xsl";
				$xsldoc = new DOMDocument();
				$xsldoc->load($xsl_doc);

				$result = get_xslt_result($xmldoc, $xsldoc);
				# fix links
				$result = fix_links_in_result($result);
				$result = "<div style ='background-color:#D0D5BF;'>" . $result . "</div>";
				
				$file_strip_xml = preg_replace("/\.xml$/", "", $file);
				$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Catalogue/$file_strip_xml";
				if (!is_dir($part_folder))
				{
					mkdir ($part_folder);
				}
				$list_file = "list.html";
				$html_file = $part_folder . "/" . $list_file;
				file_put_contents($html_file, $result);	
				$list_url = $index_repo_html_url_stub . "/" . $file_strip_xml . "/" . $list_file;
				
				# ENTRIES (sub-level)
				# first generate a list of entries from the list
				# of form loadCatalogueNumber('T366')
				echo "<p>Generating entry HTML files for $file_strip_xml</p>\n";
				$entries_array = array();
				preg_match_all('/loadCatalogueNumber\(\'([^\']+)\'\)/im', $result, $matches, PREG_PATTERN_ORDER);
				for ($i = 0; $i < count($matches[1]); $i++) 
				{
#					echo "<p> Found catalogue entry [$i]: <b>" . $matches[1][$i] . "</b></p>";
					$entries_array[$i] = $matches[1][$i];
				}

#				
				$entry_index_html = "<html><head><title>List of entries for catalogue $file_strip_xml</title></head><body><h4>List of entries for catalogue $file_strip_xml</h4><table border='1'><tr><th>Seq</th><th>Entry</th></tr>";

				foreach ($entries_array as $key => $value)
				{
					$key_plus_one = $key + 1;
					$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/select_cat.xsl";
					$xsldoc = new DOMDocument();
					$xsldoc->load($xsl_doc);
					$parm_name = "catalogueNumber";
					$parm_value = $value;
#					echo "<p>XSLT parm <b>$parm_name</b> set to value <b>$parm_value</b></p>";
					$result = get_xslt_result_with_parameter($xmldoc, $xsldoc, $parm_name, $parm_value);
					
					$result = fix_links_in_result($result);
					$result = "<div style ='background-color:#D0D5BF;'>" . $result . "</div>";
					
					$file_strip_xml = preg_replace("/\.xml$/", "", $file);
					$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Catalogue/$file_strip_xml/entries";
					if (!is_dir($part_folder))
					{
						mkdir ($part_folder);
					}
					$entry_file = "entry_" . encode_value_for_filename($value) . ".html";
					$html_file = $part_folder . "/" . $entry_file;
					file_put_contents($html_file, $result);	
					$entry_url = $index_repo_html_url_stub . "/" . $file_strip_xml . "/entries/" . $entry_file;
					
					$entry_index_html .= "<tr><td>[$key_plus_one]</td><td><a target='ENT_WIN' href='$entry_url'>$value</a></td></tr>\n";
						
				}
 
				$entry_index_html .= "</table></body></html>";
				
				$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Catalogue/$file_strip_xml";
				$entry_index_file = "entry_index.html";
				$html_file = $part_folder . "/" . $entry_index_file;
				file_put_contents($html_file, $entry_index_html);
				$entry_index_url = $index_repo_html_url_stub . "/" . $file_strip_xml . "/" . $entry_index_file;
				
				
#				exit ("<p>(ABORTING)</p>");
				
				$output_html .= "<tr> <td><a target='TEI_WIN' href='$url'>$file</a></td> <td><a target='HTML1_WIN' href='$header_url'>$header_file</a></td> <td><a target='HTML2_WIN' href='$intro_url'>$intro_file</a></td> <td><a target='HTML3_WIN' href='$list_url'>$list_file</a></td> <td><a target='HTML4_WIN' href='$entry_index_url'>$entry_index_file</a></td> </tr>\n";
				
			}
			elseif ($index_table == "Bibliography")
			{
				# create HTML using XSLT for various blocks of content
				
				# BIBL
				$xml_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI/Bibliography/" . $file;

				$xmldoc = new DOMDocument();
				$xmldoc->load($xml_doc);
				
				$xsl_doc = "D:/British Library/bl github group/bl_github_clones/idp-tei/IDP_4D/IDPWeb/xslt/bibl.xsl";
				$xsldoc = new DOMDocument();
				$xsldoc->load($xsl_doc);
				
				$file_strip_xml = preg_replace("/\.xml$/", "", $file);
				
				$parm_name = "shortRef";
				$parm_value = flip_filename_back_to_shortref($file_strip_xml, $global_file_stub_to_shortref_array); # might be slightly different from shortRef in some cases
#				echo "<p>XSLT parm <b>$parm_name</b> set to value <b>$parm_value</b></p>";
				# 
				$result = get_xslt_result_with_parameter($xmldoc, $xsldoc, $parm_name, $parm_value);

				# fix links
				$result = fix_links_in_result($result);
				$result = "<div style ='background-color:#D0D5BF;'>" . $result . "</div>";
				
				
				$part_folder = "D:/British Library/bl github group/bl_github_clones/idp-tei/TEI_to_html/Bibliography";
				if (!is_dir($part_folder))
				{
					mkdir ($part_folder);
				}
				$bibl_file = $file_strip_xml . ".html";
				$html_file = $part_folder . "/" . $bibl_file;
				file_put_contents($html_file, $result);
				$bibl_url = $index_repo_html_url_stub .  "/" . $bibl_file;
				
				
				$output_html .= "<tr> <td><a target='TEI_WIN' href='$url'>$file</a></td> <td><a target='HTML1_WIN' href='$bibl_url'>$bibl_file</a></td> </tr>\n";
			}
		}
	}
	$output_html .= "</table>\n";
	


	$output_html .= "</body>\n</html>\n";
	
	file_put_contents($index_filename, $output_html);
	
	echo "<hr/><p>Wrote index of TEI files for table <b>$index_table</b> to <b>$index_filename</b> which once commit and push to repo is at <a target='IDX_WIN' href='$index_repo_tei_url'>$index_repo_tei_url</a></p><hr/>";


	
}

#-------------
#
function encode_value_for_filename($str)
{
	$str = preg_replace('/[\(\)\.\s\/]/', "_", $str);
	$str = preg_replace('/\*/', "_STAR_", $str);
	return $str;
}

#-------------
#
function  fix_links_in_result($result)
{
	$idp_url = "http://idp.bl.uk";
	$result = preg_replace('/(oo_loader\.a4d)/', "$idp_url/database/$1", $result);
	$result = preg_replace('/(\/database\/bibliography)/', "$idp_url$1", $result);
	return $result;
}

#-------------
#
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

  
  
  
  ?>
 
</body>
</html>