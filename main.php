
<?php
class Dhandling
{
public $host;
public $dbusername;
public $dbpassword;
public $dbname;
public $charset;
//Funtion to make the connection when the button is clicked in other files
public function connect()
{

$this->host = "localhost";
$this->dbusername = "root";
$this->dbpassword = "";
$this->dbname = "php_project";
$this->charset = "utf8mb4";

try {
$dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=".$this->charset;
$pdo = new PDO($dsn,$this->dbusername, $this->dbpassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

return $pdo;
echo "Connection Established".$e->getMessage();
}
catch (PDOException $e){
echo "Connection failed: ".$e->getMessage();
}
}
}
class Record extends Dhandling{

//Function to Update instructor type
public function Instructor_update(){
$InstructorID = filter_input(INPUT_POST,'InstructorID');
$_Type = filter_input(INPUT_POST,'_Type');

$query = "UPDATE Instructor SET _Type = '$_Type' WHERE InstructorID = '$InstructorID'";
if($this->connect()->query($query)){
header("Location: ../doct_index.php?ProfUpdate=success");
}
else{
echo "Error: ";
}
}
//Function to Delete Student Record
public function student_delete(){
$StudentID = filter_input(INPUT_POST,'StudentID');
$query1 = "DELETE FROM selfsupport WHERE StudentID = '$StudentID'";
$query = "DELETE FROM phdstudent WHERE StudentID = '$StudentID'";

if($this->connect()->query($query1)){
$this->connect()->query($query);
header("Location: ../doct_index.php?StudentDelte=success");
}
else{
echo "Error: ".$del."".$connect->error;
}

}

//Function to Add a Student Record
public function student_insert(){
$StudentID = filter_input(INPUT_POST,'StudentID');
$FName = filter_input(INPUT_POST,'FName');
$LName = filter_input(INPUT_POST,'LName');
$StSem = filter_input(INPUT_POST,'StSem');
$StYear = filter_input(INPUT_POST,'StYear');
$Supervisor = filter_input(INPUT_POST,'Supervisor');

$sql = "INSERT INTO phdstudent(StudentID, FName, LName, StSem, StYear,Supervisor) Values (?,?,?,?,?,?);";
$stmt = $this->connect()->prepare($sql);
$stmt->execute([$StudentID,$FName,$LName,$StSem,$StYear,$Supervisor]);
$sql2 = "INSERT INTO selfsupport(StudentID) Value(?);";
$stmt2 = $this->connect()->prepare($sql2);
$stmt2->execute([$StudentID]);
header("Location: ../doct_index.php?newstudent=success");}
//Function to display all the student records with milestones
public function display_record(){
$Sid = filter_input(INPUT_POST,'StudentID');
$stmt = $this->connect()->prepare("SELECT * FROM phdstudent WHERE StudentID=?");
$stmt->execute([$Sid]);
$rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
echo '<table>
<tr bgcolor="blue">
<th>Student ID    </th>
<th>First Name    </th>
<th>Last Name     </th>
<th>Start Year    </th>
<th>Start Semester</th>
th>Supervisor    </th>
</tr>';
foreach ($rows as $row){
echo'
<tr>
<td>'.$row["StudentID"].'</td>
<td>'.$row["FName"].'</td>
<td>'.$row["LName"].'</td>
<td>'.$row["StSem"].'</td>
<td>'.$row["StYear"].'</td>
<td>'.$row["Supervisor"].'</td>
</tr>';
}
echo '</table>';
$stmt2 = $this->connect()->prepare("SELECT * FROM milestonespassed WHERE StudentID=?");
$stmt2->execute([$Sid]);
$all_rows = $stmt2->fetchALL(PDO::FETCH_ASSOC);
echo '</br>Mile Stones Passed</br>';
foreach ($all_rows as $all_row){
echo $all_row["MId"].' ';
echo $all_row["PassDate"].'</br>';
}
}
}
?>
