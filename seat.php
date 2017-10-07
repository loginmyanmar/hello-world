<?php include 'database.php' ?>
<?php

if (count($_POST)>0 && isset($_POST['dCode']) && isset($_POST['bLine']) && isset($_POST['tCode'])) {
$d = mysqli_real_escape_string($con, $_POST['dCode']);
$b = mysqli_real_escape_string($con, $_POST['bLine']);
$t = mysqli_real_escape_string($con, $_POST['tCode']);

//UP1, 1 
$sql = "SELECT * FROM ticket WHERE bus = ? AND dDay = ?";

		$stmt = $con->prepare($sql);
		$stmt -> bind_param("is", $bus, $dDay);
		$dDay = $d; $bus = $b;
		$stmt -> execute();
		$result = $stmt -> get_result();
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
				echo "<tr>
					<td>Edit Section</td>
					<td>Depart Date</td>
					<td>Route Code</td>
					<td>".$dDay."</td>
					<td>".$bus."</td>
					<td>Sale Ticket</td>
					<td>Booked Ticket</td>
					<td>Free Seat</td>
					<td>Booking</td>
					</tr>";
				while ($row = $result->fetch_assoc()){
					$tCode = $row['tk_code'];
					$C_Select_Seat = 5;
					$free_seat=$row['avl_seat'] - $row['book_seat'];
					if (similar_text($t,$tCode)>=3 && $free_seat >0){
						$rowNo = $row['tk_id'];
						$C_Select_Seat += $row['book_seat'];
						$sql = "UPDATE ticket SET book_seat= $C_Select_Seat WHERE tk_id = $rowNo";
						if ($con->query($sql) === TRUE){
							echo "YOUR SEAT HAVE ALREADY BOOKED.";
						}else {
							echo "ERROR BOOKING".$con->error;
						}
						
					}else {echo "not found";}
					
					$data.= "<tr>
					<td>".$row['stop_section']."</td>
					<td>".$row['tk_date']."</td>
					<td>".$row['tk_code']."</td>
					<td>".$row['dDay']."</td>
					<td>".$row['bus']."</td>
					<td>".$row['avl_seat']."</td>
					<td>".$row['book_seat']."</td>
					<td>".$free_seat."</td>
					<td></td>
					</tr>";
				}echo $data."
					</table>";echo "Your Booking is successful";
			}

}




?>