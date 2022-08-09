<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNotes - Makes notes taking easy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/project1/crud.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" rows="3" name="descriptionEdit"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES ( 'My Pet', 'My pet is a dog. Its name is Bonny.', current_timestamp());
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";

    $insert = false;
    $update = false;
    $delete = false;

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Sorry we failed to connect : " . mysqli_connect_error());
    }
    if (isset($_GET['delete'])){
        $sno = $_GET['delete'];
        
        $sql = "DELETE FROM `notes` WHERE `sno` = '$sno'";
        $result = mysqli_query($conn , $sql);
        if($result){
            $delete = true;
        }   
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset( $_POST['snoEdit'])){
            // Update the record
              $sno = $_POST["snoEdit"];
              $title = $_POST["titleEdit"];
              $description = $_POST["descriptionEdit"];
          
            // Sql query to be executed
            $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = '$sno'";
            $result = mysqli_query($conn, $sql);
            if($result){
                $update = true;
            }
            else{
                echo "We could not update the record successfully";
            }
        }
        else{
            $title = $_POST['title'];
            $description = $_POST['description'];

            $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ( '$title', '$description')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $insert = true;
            }
            else {
                echo "Unsuccessful !";
            }
    
        }
    }

    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/crud.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
    <?php
    if ($insert == true) {
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your note has been inserted successfully.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <?php
    if($update == true){
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>
    <?php
    if($delete == true){
        echo " <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>
    <div class="container my-5">
        <h2 class="mb-4">Add a Note</h2>
        <form action="/project1/crud.php" method="post" class="mb-5">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>


        <table class="table my-5" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><button type='button' class='edit btn btn-sm btn-primary' id=". $row['sno']." data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ", );
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("delete ", );
                sno = e.target.id.substr(1);

                if(confirm("Are you sure?")){
                    console.log("Yes");
                    window.location = `/project1/crud.php?delete=${sno}`;
                    // TODO: Create a form and use post request to submit a form
                }
                else{
                    console.log("No");
                }
            })
        })
    </script>
</body>

</html>