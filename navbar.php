<!DOCTYPE html>
<html lang="en">

<head>
    <title>RoomSewa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .navbar {
            background-color: #f0f0f0;

        }

        .navbar-header img {
            width: 100px;
            /* height: 150px; */
            margin-top: 5px;
            height: 70px;
            /* Set a fixed height for the logo */
        }

        .navbar-nav {
            margin: 10px 0;
            color: black;
        }

        .navbar-nav li {
            margin-left: 15px;
            box-sizing: auto;
            margin-right: 15px;
            /* Adjust the margin as needed */
            color: black;
            background-color: skyblue;
            border-color: red;
            border-radius: 10px;



        }

        li a {
            color: black;
            font-size: 1.5rem;
            /* font-weight: bold; */
            font-family: Georgia, 'Times New Roman', Times, serif;
        }


        .navbar-nav li:hover {
            /* box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); */
            /* opacity: 1; */
            /* transform: scale(1.05); */
            color: black;
            background-color: gray;
            /* transition: background-color 1.05s ease; */
            border-radius: 20px;
        }

        /* Responsive styles for smaller screens */
        @media (max-width: 767px) {
            .navbar-nav {
                margin: 0;
                text-align: center;
            }

            .navbar-nav li {
                margin-right: 0;
                margin-bottom: 5px;
                color: black;
                background-color: orange;
                border-color: 1px solid black;
                border-radius: 15px;
            }



            .navbar-header img {
                height: 150px;
                /* Allow the logo to resize based on screen width */
            }

        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light justify-content-between">
        <div class="container-fluid">
            <a class="navbar-header" href="index.php">
                <img src="./images/mainlogo.png" alt="logo">
            </a>


            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./aboutus.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contactus.php">Contact Us</a>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li><a href="how-to-register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                <li><a href="how-to-login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

            </ul>


        </div>

    </nav>
</body>

</html>