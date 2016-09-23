<?php 
error_reporting(E_ALL);
function fileExtension(){
	$extension = pathinfo($_POST['file_name'], PATHINFO_EXTENSION);
	return $extension;
}

function customFileExtension(){
	$array = explode('.',$_POST['file_name']);	
	return end($array);
}

function convertToTimezone($timezone)
{
	$newTimeZone = new DateTimeZone($timezone);
	$date = new DateTime($_POST['datetime']);
	$date->setTimezone($newTimeZone);
	return $date->format('l F j Y g:i a')."\n<br/>";
}

function customConvertToTimezone($timezone)
{
	$dateAndTimeArr = explode('T',$_POST['datetime']);
	$time=explode(":", $dateAndTimeArr[1]);

	if(!strcmp($timezone,'America/Los_Angeles'))
	{
		echo "los angeles<br/>";
		
		$newMins = (int)$time[1]-30;
		$newHours = (int)$time[0]-12;
	}
	elseif(!strcmp($timezone,'Europe/London')) 
	{
		echo "london";
		$newMins = (int)$time[1]-30;
		$newHours = (int)$time[0]-4;	
	}
	if($newMins < 0)
	{
		$newHours=($newHours-1);
		$newMins=60+$newMins;
	}
	$date = new DateTime("$dateAndTimeArr[0]$newHours:$newMins");
	return $date->format('l F j Y g:i a')."\n<br/>";
}

function getDateFromDatetime($dateAndTime)
{
	$dateAndTimeArr=explode('T',$dateAndTime);
	$dateFromTimestamp = new DateTime($dateAndTimeArr[0]);
	return $dateFromTimestamp;
}

function dateDifference()
{
	$dateOne=getDateFromDatetime($_POST['datetime1']);
	$dateTwo=getDateFromDatetime($_POST['datetime2']);
	$interval = $dateOne->diff($dateTwo);
	return $interval;
}

function reverseString()
{
	$reversedString=strrev($_POST['reverse_string']);
	$string = str_split($reversedString,1);
	$string = array_unique($string);
	$string = implode("", $string);
	return $string."<br/>";
}

function customReverseString()
{
	$reverseString = array();
	for($negativeLooper = strlen($_POST['reverse_string']),$positiveLooper=0;$negativeLooper>=0;$negativeLooper--,$positiveLooper++)
	{
		$reverseString[$positiveLooper] = $_POST['reverse_string'][$negativeLooper];
	}
	$reverseString = array_unique($reverseString);
	return implode("", $reverseString)."<br/>";
}

function createCSV(){
	$organisationDetails = array(
      10 => array(
       		 'name' => 'weboniseLab',
        	 'jobRole' => array(
         			 '11' => array(
          					  'name' => 'devloper',
        					  'created' => '2016-02-01',
          						),
         			 '12' => array(
         					   'name' => 'sr. developer',
         					   'created' => '2016-02-10',
         						 ),
        					),
        	 'cfa' => array(
          			 '11' => array(
           					 'name' => 'php',
          				  'created' => '2016-03-10',
         					),
          			 '12' => array(
        				    'name' => 'ruby',
        				    'created' => '2016-04-15',
       					   ),
       				 )
      			),
      11 => array(
      		  'name' => 'Hartley Lab',
      		  'jobRole' => array(
     			     '11' => array(
					       'name' => 'foront end',
	      			      'created' => '2016-03-01',
         					 ),
         			 '12' => array(
				            'name' => 'design',
				            'created' => '2016-03-10',
       						  ),
    				    ),
    	    'cfa' => array(
     			     '11' => array(
				            'name' => 'UI',
				            'created' => '2016-02-01',
         				 ),
        			 '12' => array(
				            'name' => 'UX',
				            'created' => '2016-01-01',
				          ),
     			   )
      ),
      15 => array(
      		  'name' => 'Hartley Lab',
    	      'jobRole' => array(
    			      '11' => array(
    				        'name' => 'foront end',
    				        'created' => '2016-03-01',
   					       ),
   				       '12' => array(
				            'name' => 'design',
				            'created' => '2016-03-10',
     				     ),
     			   )
    		  )
    );   
	$csvFileName = "organisations.csv";
    $csvFilePointer = fopen('php://output', 'w');
    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename='.$csvFileName);
    $csvArray=array();
    if(empty($organisationDetails)){
    	return "array is empty";
    }
    foreach ($organisationDetails as $organisation => $organisationValues) {
    	$csvRow=array();
    	foreach ($organisationValues['jobRole'] as $roleKey => $roleValue){
	    	if(!array_key_exists('cfa', $organisationValues))
	    	{
	    		$csvRow['created']=$roleValue['created'];
	    		$csvRow['organisation_name']=$organisationValues['name'];
	    		$csvRow['organisation_Id']=$organisation;
	    		$csvRow['cfa_name']='-';
	    		$csvRow['cfa_Id']='-';
	    		$csvRow['rfa_name']='-';
	    		$csvRow['jobRole_name']=$roleValue['name'];
	    		$csvRow['jobRole_Id']=$roleKey;  		
    			array_push($csvArray, $csvRow);
	    	}
	    	foreach ($organisationValues['cfa'] as $cfaKey => $cfaValue) {
    			$csvRow['created']=$roleValue['created'];
	    		$csvRow['organisation_name']=$organisationValues['name'];
	    		$csvRow['organisation_Id']=$organisation;
	    		$csvRow['cfa_name']=$cfaValue['name'];
	    		$csvRow['cfa_Id']=$cfaKey;
	    		$csvRow['rfa_name']='-';
	    		$csvRow['jobRole_name']=$roleValue['name'];
	    		$csvRow['jobRole_Id']=$roleKey;
				array_push($csvArray, $csvRow);    				
			}   		
    	}   
    }
    
    function date_compare($createdDateOne, $createdDateTwo)
	{
	    $dateValueOne = strtotime($createdDateOne['created']);
	    $dateValueTwo = strtotime($createdDateTwo['created']);
	    return $dateValueTwo - $dateValueOne;
	}    
	usort($csvArray, 'date_compare');
	$header= array('created',"organisation_name","organisation_Id","cfa_name","cfa_Id","rfa_name","JR_Id","JR_Name");
	fputcsv($csvFilePointer, $header);
	$row=array();
	if(empty($csvArray)){
		return "csv Array is empty";
	}
	foreach ($csvArray as $rowIndex => $rowValue) {
		$row=array();
		foreach ($rowValue as $subrowkey => $subrowvalue) {
			array_push($row, $subrowvalue);
		}
	fputcsv($csvFilePointer, $row);	
	}
    die;
}

if(isset($_POST['file_name']))
{
	echo fileExtension();
	echo customFileExtension();
}
if(isset($_POST['datetime1']) && isset($_POST['datetime2']))
{
	echo dateDifference();
}
if(isset($_POST['convert_to_us']))
{
	echo convertToTimezone('America/Los_Angeles');
	echo customConvertToTimezone('America/Los_Angeles');
}
if(isset($_POST['convert_to_uk']))
{
	echo convertToTimezone('Europe/London');
	echo customConvertToTimezone('Europe/London');
}
if(isset($_POST['reverse_string']))
{
	echo reverseString();
	echo customReverseString();
}
if (isset($_POST['toCSV']))
{
	createCSV();
}
?>
<html>
	<body>
		<form action="index.php" method="post">
	Enter file name: <input type="text" name="file_name"><br/><br/>
		<input type="submit" value="submit" name="submit">
		</form>
		<form action="index.php" method="POST">
		date1:
			<input type="datetime-local" name="datetime" value="<?php echo date('Y-m-d g:i a'); ?>" />
			<input type="submit" value="convert to us" name="convert_to_us">
			<input type="submit" value="convert to uk" name="convert_to_uk">
			</form>
		<form action="index.php" method="POST">
		date1:
			<input type="datetime-local" name="datetime1" value="<?php echo date('Y-m-d'); ?>" />
		date2:
			<input type="datetime-local" name="datetime2" value="<?php echo date('Y-m-d'); ?>" />
			<input type="submit" value="submit" name="submit">
		</form>
		<form action="index.php" method="post">
	Enter string to reverse: <input type="text" name="reverse_string"><br/><br/>
		<input type="submit" value="submit" name="submit">
		</form>

		<form action="index.php" method="post">
	convert organisational data to csv: 
		<input type="submit" value="submit" name="toCSV">
		</form>
	</body>
</html>
