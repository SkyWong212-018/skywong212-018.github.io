<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/webdev/online_store/home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/webdev/online_store/product_create.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/webdev/online_store/product_read.php">Read Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/webdev/online_store/create_customer.php">Create Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/webdev/online_store/read_customer.php">Read Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="http://localhost/webdev/online_store/contact_us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="ps-5">
        <div class="page-header pt-4">
            <h1>Contact Us</h1>
        </div>

        <form>
            <div class="col-5">
                <div class="mb-3">
                    <label for="Name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="Name" placeholder="John">
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="Email" placeholder="abcde@gmail.com">
                </div>
                <div class="mb-3">
                    <label for="Message">Message</label>
                    <input type="text" class="form-control" id="Message" placeholder="Type your message here">
                    <br>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
        </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>