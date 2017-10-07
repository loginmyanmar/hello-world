<?php include 'database.php' ?>
<?php
	
if (count($_POST)>0 && isset($_POST['depart']) && isset($_POST['depart'])) {
	
	$d_from = mysqli_real_escape_string($con,$_POST['depart']);
	$d_to = mysqli_real_escape_string($con, $_POST['desti']);
	if ($d_from == NULL && $d_to == NULL) {
		echo "Please select depart & destination city.<br><br>";
	}else if ($d_from != NULL && $d_to == NULL) {
		echo "Please select destination city.<br><br>";
	}else if ($d_from == NULL && $d_to != NULL) { 
		echo "Please select depart city.<br><br>";
	}else if ($d_from ===  $d_to) {
		echo "Please select depart city & destination not same.";
	}else{
		$query1="SELECT stop_name, stop_id FROM stop WHERE stop_id = ?
				UNION
				SELECT  stop_name, stop_id FROM stop WHERE stop_id = ?";
			 $stm1 = $con->prepare($query1);
			 $stm1 -> bind_param("ii",$depart, $desti);
			 $depart = $d_from; $desti=$d_to;
			 $stm1->execute();
			 $result=$stm1->get_result();
			 if ($result->num_rows> 0){
				 $sqlData=array(); $showData="";
				 $depart=""; $desti="";
				for ($set = array();$row = $result->fetch_assoc();$set[] = $row);
				
				$depart = $set[0]['stop_name'];
				$desti = $set[1]['stop_name'];
				echo "Your searching route from ".$depart." to " .$desti." is as follows:<br>";
			$sql="SELECT * FROM ticket WHERE stop_section = 1";
			$result = $con->query($sql);
			if ($result -> num_rows >0)
			{	$data=""; $free_seat="";
				echo "<table id='tableId'>
					<tr>
					<td>Route Section</td>
					<td>Depart Date</td>
					<td>Route Code</td>
					<td>Bus Line</td>
					<td>Sale Ticket</td>
					<td>Booked Ticket</td>
					<td>Free Seat</td>
					<td>Booking</td>
					</tr>";
				while ($row = $result->fetch_assoc()){
					$free_seat=$row['avl_seat'] - $row['book_seat'];
					if ($free_seat > 0) {
					$dDay = $row['dDay'];
					$dBus = $row['bus'];
					$tCode = $row['tk_code'];
					$data.= "<tr>
					<td>".$row['stop_section']."</td>
					<td>".$row['tk_date']."</td>
					<td>".$row['tk_code']."</td>
					<td>".$row['bus']."</td>
					<td>".$row['avl_seat']."</td>
					<td>".$row['book_seat']."</td>
					<td>".$free_seat."</td>
					<td><input type='submit' name='button' class='pointercursor' id='".$row['tk_id']."' value='Booking' onclick='booking(\"$dBus\",\"$dDay\",\"$tCode\")'/></td>
					</tr>";}
				}echo $data."
					</table>";
			}
/*========================*/					
			$sql="SELECT * FROM ticket WHERE bus = '1' AND tk_date LIKE '2017-09-29 %'";
			$result = $con->query($sql);
			if ($result -> num_rows >0)
			{	$data=""; $free_seat="";
				echo "<br><br><table id='tableId'>
					<tr>
					<td>Route Section</td>
					<td>Depart Date</td>
					<td>Route Code</td>
					<td>dDay Code</td>
					<td>Bus Line</td>
					<td>Sale Ticket</td>
					<td>Booked Ticket</td>
					<td>Free Seat</td>
					<td>Booking</td>
					</tr>";
				while ($row = $result->fetch_assoc()){
					$free_seat=$row['avl_seat'] - $row['book_seat'];
					if ($free_seat > 0) {
					$data.= "<tr>
					<td>".$row['stop_section']."</td>
					<td>".$row['tk_date']."</td>
					<td>".$row['tk_code']."</td>
					<td>".$row['dDay']."</td>
					<td>".$row['bus']."</td>
					<td>".$row['avl_seat']."</td>
					<td>".$row['book_seat']."</td>
					<td>".$free_seat."</td>
					<td><input type='submit' name='button' class='pointercursor' id='".$row['tk_id']."' value='Booking' onclick='addRowHandlers()'/></td>
					</tr>";}
				}echo $data."
					</table>";
			}
		 }else{
			 echo "Result Not Found.";
			 }
	}
}

?>
	 
			
		 
			 
		 