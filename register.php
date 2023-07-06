<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">

    <title>Employee Management system</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Employee task</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact_us.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- login -->

    <div class="container">
        <?php
                    $status = $_GET['status'] ?? '';
                    if ($status === 'success') {
                    echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">';
                    echo '<strong>Congratulations</strong> Your data has been submitted <a href="login.php" class="alert-link">Login</a>';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }   elseif ($status === 'error') {
                    echo '<div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">';
                    echo '<strong>Sorry</strong> Your data has not been submitted due to technical errors';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            ?>
        <?php
        // <!-- error message if email is already registered -->
                $errorMessageforEmail = $_GET['errorMessageforEmail'] ?? '';
                if (!empty($errorMessageforEmail)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforEmail;
                    echo '</div>';
                }
                // ends email message here
            ?>
        <form action="registrationdata.php" method="post" >
            <div class="form-group">
                <label>Email address</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="far fa-envelope"></i></span>
                    </div>
                    <input type="email" placeholder="Email Address" class="form-control" name="email" id="email"
                        required value="<?php echo $email; ?>" oninput="updateButton()">
                </div>
                <small class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <?php
                    // error message of email field empty and invalid email
                    $errorMessageforEmailempty = $_GET['errorMessageforEmailempty']?? '';
                    $errormessageforInvalidEmail = $_GET['errormessageforInvalidEmail'] ?? '';
                    $errorMessageformissingsign = $_GET['errorMessageformissingsign'] ?? '';
                    $errorMessageformissingdotsign = $_GET['errorMessageformissingdotsign'] ?? '';
                    if(!empty($errorMessageforEmailempty)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforEmailempty;
                    echo '</div>';
                    }elseif(!empty($errormessageforInvalidEmail)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errormessageforInvalidEmail;
                    echo '</div>';
                    }elseif(!empty($errorMessageformissingsign)){
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo $errorMessageformissingsign;
                        echo '</div>'; 
                    }elseif(!empty($errorMessageformissingdotsign)){
                        echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo $errorMessageformissingdotsign;
                        echo '</div>';
                    }
                    // ends here
                ?>
            <div class="form-group">
                <label>Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                    </div>
                    <input type="text" placeholder="Name" class="form-control" name="name" required id="name">
                </div>
            </div>
            <?php
            // error message for empty name field
                    $errorMessageforNameempty = $_GET['errorMessageforNameempty'] ?? '';
                    if(!empty($errorMessageforNameempty)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforNameempty;
                    echo '</div>';
                    }
                    // ends here
                    ?>
            <div class="form-group">
                <label>Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input type="number" placeholder="Number" class="form-control" name="number" required id="number"
                        oninput="updateButton()">
                </div>
            </div>
            <?php
            // error message for number being same and number field leaving emoty
                $errorMessageforNumber = $_GET['errorMessageforNumber'] ?? '';
                $errorMessageforNumberempty = $_GET['errorMessageforNumberempty'] ?? '';
                $errormessageforInvalidNumber = $_GET['errormessageforInvalidNumber'] ?? '';
                if (!empty($errorMessageforNumber)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforNumber;
                    echo '</div>';
                }elseif(!empty($errorMessageforNumberempty)){
                    var_dump($errormessageforNumberempty);
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errorMessageforNumberempty;
                    echo '</div>';
                }elseif(!empty($errormessageforInvalidNumber)){
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo $errormessageforInvalidNumber;
                    echo '</div>';
                }
                // ends here
            ?>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="password" placeholder="Password" class="form-control" name="password" required
                        id="id_password" oninput="updateButton()">
                </div>
                <i class="far fa-eye" id="togglePassword" title="Show Password"
                    style="margin-left: 1076px; cursor: pointer; position: relative; top: -29px;"></i>
            </div>
            <?php
            $errorMessageforPasswordempty = $_GET['errorMessageforPasswordempty'] ?? '';
            $errorMessageforshortpass = $_GET['errorMessageforshortpass'] ?? '';
            if(!empty($errorMessageforPasswordempty)){
                echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo $errorMessageforPasswordempty;
                echo '</div>';
            }elseif(!empty($errorMessageforshortpass)){
                echo '<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">';
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="crossButton">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo $errorMessageforshortpass;
                echo '</div>';
            }
            ?>
            <div class="form-group">
                <label for="">Select a role</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-caret-down fa-lg"></i></span>
                    </div>
                        <select class="custom-select mb-2" name="role" required id="role">
                            <option  value="admin">Admin</option>
                            <option  value="manager">Manager</option>
                            <option  value ="user">User</option>
                        </select>
                </div>
            </div>
            <div class="form-group" id="departmentDiv">
                <label for="" >Select a department:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" ><i class="fa fa-caret-down fa-lg" ></i></span>
                    </div>
                        <select class="custom-select mb-2" name="department" required >
                            <option value="it_dept">Information and Technology</option>
                            <option value="hr_dept">Human Resource</option>
                            <option value="finance_dept">Finance</option>
                        </select>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="checkbox" name="checkboxT&C"
                    oninput="updateButton()">
                <label class="form-check-label" for="exampleCheck1"> <a href="terms_conditions.php" target="_blank"
                        style="color:black; ">Terms and Conditions</a> </label>
            </div>
            <button type="submit" class="btn btn-primary" title="Submit" id="submitBtn" disabled>Submit</button>
        </form>
    </div>








    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <!-- script for showing department option when manager or user is selected -->
    <script>
        
        $(document).ready (function(){
            $('#departmentDiv').hide();
        
        $('#role'). on('change', function(){
            var selectedRole = $(this).val();
            if(selectedRole === 'manager' || selectedRole ==='user'){
                $('#departmentDiv').show();
            }else{
                $('#departmentDiv').hide();
            };
        });
    });

    </script>
    <!-- script ends here -->









    <!-- script for refreshing the page after an error -->
    <script>
    var crossButton = document.getElementById('crossButton')
    crossButton.addEventListener('click', function() {
        window.location.href = 'register.php';
    })
    </script>
    <!-- script for showing password by eye icon -->
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('id_password');
    togglePassword.addEventListener('click', function(e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    })
    </script>




    <!-- script for making the submit button disabled until every field is filled and checkbox is checked -->
    <script>
    function updateButton() {
        var email = document.getElementById('email').value;
        var name = document.getElementById('name').value;
        var number = document.getElementById('number').value;
        var password = document.getElementById('id_password').value;
        var checkbox = document.getElementById('checkbox');
        var ischecked = checkbox.checked;
        var button = document.getElementById('submitBtn');

        if (email != '' && name != '' && number != '' && password != '' && ischecked) {
            button.disabled = false;
        } else {
            button.disabled = true;
        }
    }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>


</body>

</html>