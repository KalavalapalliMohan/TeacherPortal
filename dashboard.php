<?php
  require_once('config/config.php');
  // current login user information
  session_start();

  if (isset($_SESSION['security_id']) && isset($_SESSION['name'])) {
      $mainId = $_SESSION['security_id'];
      $mainName = $_SESSION['name'];
  } 
  
  // Add Students Data
  if (isset($_POST['add'])) {
    
    $studentName = isset($_POST['studentName']) ? trim($_POST['studentName']) : '';
    $studentSubject = isset($_POST['studentSubject']) ? trim($_POST['studentSubject']) : '';
    $studentMark = isset($_POST['studentMark']) ? trim($_POST['studentMark']) : '';

    if (!empty($studentName) && !empty($studentSubject) && !empty($studentMark)) {
      // check student exist or not with given details
        $FetchId = mysqli_query($conn, "SELECT * FROM students WHERE status = '1' AND name='$studentName' AND subject='$studentSubject'");
        $GetId= mysqli_fetch_Object($FetchId);
        $GetIds = $GetId->s_id;

          if ($GetId->s_id && $GetId->marks) {

            $AllMarks = $GetId->marks + $studentMark;
            // updating existing student marks
            $UpadteMarks = mysqli_query($conn, "UPDATE students SET marks='$AllMarks' WHERE s_id='$GetIds' AND status='1'") or die(mysqli_error($conn));
            if ($UpadteMarks) {
              echo "<script>alert('Marks updated successfully.');
              window.location.href = '" . $_SERVER['PHP_SELF'] . "';
              </script>";
            } else {
              echo "<script>alert('Failed to update data.');</script>";
            }

          } else{
            // inserting new student data
            $InsertQry = mysqli_query($conn, "INSERT INTO students(name,subject,marks,status) VALUES('$studentName','$studentSubject','$studentMark','1')") or die(mysqli_error($conn));
            if ($InsertQry) {
                echo "<script>alert('New student added successfully');
                window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                </script>";
            } else {
                echo "<script>alert('Failed to insert data.');</script>";
            }
          }
    } else{
      echo "<script>alert('Please fill in all the fields.');</script>";
    }
  }
    

  // Update Students Data
  if (isset($_POST['submitBtnUp'])) {
      $id = isset($_POST['h_id']) ? $_POST['h_id'] : '';  
      $s_name = isset($_POST['s_name']) ? trim($_POST['s_name']) : '';
      $s_subject = isset($_POST['s_subject']) ? trim($_POST['s_subject']) : '';
      $s_marks = isset($_POST['s_marks']) ? trim($_POST['s_marks']) : '';
      if (!empty($s_name) && !empty($s_subject) && !empty($s_marks)) {
          if ($id != '') {
            // updating student details
              $UpdateQry = mysqli_query($conn, "UPDATE students SET name='$s_name', subject='$s_subject', marks='$s_marks' WHERE s_id='$id' AND status='1'") or die(mysqli_error($conn));
              if ($UpdateQry) {
                  echo "<script>
                  alert('Data updated successfully.');
                  window.location.href = '" . $_SERVER['PHP_SELF'] . "';
                </script>";
              } else {
                  echo "<script>alert('Failed to update data.');</script>";
              }
          } else {
              echo "<script>alert('ID is missing.');</script>";
          }
      } else {
          echo "<script>alert('Please fill in all the fields.');</script>";
      }
  }

  // Delete Students Data
  if (isset($_POST['deleteData'])) {
      $id = isset($_POST['d_id']) ? $_POST['d_id'] : ''; 
      if ($id != '') {
        // de-activing student data
          $DeleteQry = mysqli_query($conn, "UPDATE students SET status='0' WHERE s_id='$id'") or die(mysqli_error($conn));
          // $DeleteQry = mysqli_query($conn, "DELETE * FROM students WHERE s_id='$id'") or die(mysqli_error($conn));
          if ($DeleteQry) {
              echo "<script>alert('Student Data Deleted successfully.');
              window.location.href = '" . $_SERVER['PHP_SELF'] . "';
              </script>";
          } else {
              echo "<script>alert('Failed to Delete data.');</script>";
          }
      } else {
          echo "<script>alert('ID is missing.');</script>";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
         <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
    <!-- DataTables CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">

    <!-- CSS for styling -->
    <link rel="stylesheet" href="css/style.css">
     <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            background-color: #444;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            background-color: #f4f4f4;
            height: 100vh;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .header .profile {
            display: flex;
            align-items: center;
        }

        .header .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .dashboard-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            flex: 1;
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
        }

        .main-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard-cards {
                flex-direction: column;
            }
        }

     </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Dashboard</h2>
    <ul>
        <li class=""><a href="dashboard.php">Students List</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1>Students List</h1>
        <div class="profile">
            <img src="images/Default_pfp.svg" alt="Profile Picture">
            <span><?php echo $mainName ; ?></span>
        </div>
    </div>
      <!-- table data -->
    <div class="table-container">
      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Subject</th>
            <th>Marks</th>
            <th class="action">Action</th>
          </tr>
        </thead>
        <tbody id="studentTableBody">
          
          <?php
            $qry = mysqli_query($conn, "SELECT * FROM students WHERE status = '1'");
            while ($row = mysqli_fetch_Object($qry)) {
            ?>
            <tr>
              <td><span class="round"><?php echo substr($row->name, 0, 1); ?></span>
              <?php echo $row->name; ?></td>
              <td><?php echo $row->subject; ?></td>
              <td><?php echo $row->marks; ?></td>
              <td class="icon">
                <div class="dropdown">
                  <i class="fas fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                  <div class="dropdown-content">
                    <a href="#" class="edit-action" onclick="openUpdatePopup(),UpdateData('<?php echo $row->s_id; ?>','<?php echo $row->name; ?>','<?php echo $row->subject; ?>','<?php echo $row->marks; ?>')"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
                    <a href="#" class="delete-action"onclick="openDeletePopup(<?php echo $row->s_id; ?>)"><i class="fa-solid fa-trash"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <?php
              }
            ?>
        </tbody>
      </table>
      <button class="AddButton" id="addStudentBtn">Add</button>
    </div>
  </div>


  <!-- Add Data -->
  <div class="overlay" id="overlay"></div>
  <div class="popup" id="popup">
    <span class="popup-close" id="popupClose">&times;</span>
    <center><h2 id="popupTitle">Add New Student</h2></center>
    <form id="addStudentForm" method="POST">
      <label for="Name">Name <span class="mandatory">*</span></label>
      <div class="input-container">
        <input
          type="text"
          id="studentName"
          name="studentName"
          class="input-field"
          placeholder="Name"
          required
        />
      </div>
      <label for="Subject">Subject <span class="mandatory">*</span></label>
      <div class="input-container">
        <input
          type="text"
          id="studentSubject"
          name="studentSubject"
          class="input-field"
          placeholder="Subject"
          required
        />
      </div>
      <label for="Marks">Marks <span class="mandatory">*</span></label>
      <div class="input-container">
        <input
          type="number"
          id="studentMark"
          name="studentMark"
          class="input-field"
          placeholder="Mark"
          required
        />
      </div>
      <button class="AddButton" name="add" type="submit" id="submitBtn">Submit</button>
    </form>
  </div>

  <!-- Update Data -->
  <div class="update-overlay" id="updateOverlay"></div>
  <div class="update-popup" id="updatePopup">
    <span class="update-popup-close" id="updatePopupClose">&times;</span>
    <center><h2>Update Student Data</h2></center>
    <form id="updateStudentForm" method="POST">
      <label for="UpName">Name <span class="mandatory">*</span></label>
      <div class="input-container">
          <input type="hidden" name="h_id" id="h_id" value="">
        <input
          type="text"
          id="s_name"
          name="s_name"
          class="input-field"
          placeholder="Name"
          required
        />
      </div>
      <label for="UpSubject">Subject <span class="mandatory">*</span></label>
      <div class="input-container">
        <input
          type="text"
          id="s_subject"
          name="s_subject"
          class="input-field"
          placeholder="Subject"
          required
        />
      </div>
      <label for="UpMarks">Marks <span class="mandatory">*</span></label>
      <div class="input-container">
        <input
          type="number"
          id="s_marks"
          name="s_marks"
          class="input-field"
          placeholder="Mark"
          required
        />
      </div>
      <button class="AddButton" name="submitBtnUp" type="submit" id="submitBtnUp">Update</button>
    </form>
  </div>

  <!-- Delete Data -->
  <div class="Delete-overlay" id="DeleteOverlay"></div>
  <div class="Delete-popup" id="DeletePopup">
    <span class="Delete-popup-close" id="DeletePopupClose">&times;</span>
    <form method="POST">
      <input type="hidden" name="d_id" id="d_id" value="">
      <p class="msg">Are you sure you want to delete this record?</p>
      <button class="AddButton" name="deleteData" type="submit" id="deleteData">Delete</button>
      <button class="cancelButton Delete-popup-close" id="DeletePopupClose" style="color: white;">Cancel</button>
    </form>
  </div>

<!-- jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

<!-- DataTable initialization -->
<script>
    new DataTable('#example');
</script>

<!-- Popup and overlay functions -->
<script src="js/student.js"></script>
</body>
</html>

