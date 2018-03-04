//•	Problem 2: Implement a basic spin results end point 
//o	Description 
//		Slot Machine Spin Results is our server end point that updates all player data and features when a spin is completed on the client. 
//		We do hundreds of millions of these requests per day, and we would like to see you make a very basic MySQL driven version.
//		This can be just a normal PHP file that gets called, or you can implement more modern routing if you would like
//o	Data Storage 
//		Create a MySQL database that contains a player table with the following fields: 
//		Player ID
//		Name
//		Credits
//		Lifetime Spins
//		Salt Value	
//o	Code 
//		Your code should validate the following request data: hash, coins won, coins bet, player ID
//		Update the player data in MySQL if the data is valid
//		Generate a JSON response with the following data: 
//		Player ID
//		Name
//		Credits
//		Lifetime Spins
//		Lifetime Average Return
//	
//		You can assume that the client making the request has the salt value to make the hash.

// Solution

//	I am creating a hash using salt value along underscore, coins_won, coins_bet and player_id
//	Salt_value = SG.is.Sciencific.Games
//	hash = Salt_value + _ + coins_won + coins_bet + player_id

		<?php
			$response_data = array();
			$response_data['success'] = false;
			
			$hash = $_REQUEST['hash'];
			$coins_won = $_REQUEST['coins_won'];
			$coins_bet = $_REQUEST['coins_bet'];
			$player_id = $_REQUEST['player_id'];
			
			$host = "localhost";
			$uName = "root";
			$pPhrase = "usbw";
			$databaseName = "test";

			$mysqli = new mysqli($host, $uName, $pPhrase, $databaseName);

			if ($mysqli->errno) {
				$response_data['message'] = "Failed to connect MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect.error;
			} else {
				$sql = "SELECT * FROM player WHERE Player_ID=" . $player_id;
				$result = $mysqli->query($sql);

				if ($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						if ($hash != md5($row['Salt_value'] . '_' . $coins_won . $coins_bet . $player_id )) {
							$response_data['message'] = "Hash not valid. Send the proper hash for this transaction to be consumed.";
						} else {
							$lifetime_spins = $row['Lifetime_spins']+1;
							$coins_balance = $coins_won - $coins_bet;
							
							$new_coins_balance = $row['Credits'] + $coins_balance;
							$update_sql = "UPDATE player SET Credits = '" . $new_coins_balance . "', Lifetime_spins = '" . $lifetime_spins. "' WHERE Player_ID=" . $player_id;
							if ($mysqli->query($update_sql) === TRUE) {
								$response_data['success'] = true;
								$response_data['message'] = "Successfully updated user credits data.";
							} else {
								$response_data['message'] = "Unable to update the user coin credits data. Please try again.";
							}
						}
					}
				} else {
					$response_data['message'] = "User not found in database.";
				}
				
				$mysqli->close();
			}
			
			echo json_encode($response_data);		
		?>
