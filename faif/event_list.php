<!doctype html>
<html lang="en">

<head>
    <!--
    /   Multipurpose: Free Template by FreeHTML5.co
    /   Author: https://freehtml5.co
    /   Facebook: https://facebook.com/fh5co
    /   Twitter: https://twitter.com/fh5co
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Document title -->
    <title>List of Events</title>
    <!-- Stylesheets & Fonts -->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i%7CRajdhani:400,600,700"
        rel="stylesheet">
    <!-- Plugins Stylesheets -->
    <link rel="stylesheet" href="assets/css/loader/loaders.css">
    <link rel="stylesheet" href="assets/css/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/aos/aos.css">
    <link rel="stylesheet" href="assets/css/swiper/swiper.css">
    <link rel="stylesheet" href="assets/css/lightgallery.min.css">
    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>

    <?php
    require "config/database.php";
    $db = new Database();
    $con = $db->connect();

    $table = "events";

    $query = 'SELECT * FROM '.$table.' ORDER BY date_from DESC';

    $res = $con->query($query);

    ?>

    <!-- Pricing Start -->
    <section class="pricing-table">
        <div class="container">
            <div class="title text-center">
                <h6 class="title-primary">Register for Events</h6>
                <h1 class="title-blue">Event List</h1>
                <h3><a href="add_event.php">Click here to add events</a></h3>
            </div>
            <div class="row gutters">

            <?php while($row = $res->fetch_assoc()): ?>

                <div class="col-md-4">
                    <div class="single-pricing text-center" data-aos="fade-up" data-aos-delay="0"
                        data-aos-duration="600">
                        <h2><?php echo $row['title']; ?></h2>
                        <p class="desc"><?php echo $row['date_from'];echo "<br>to<br>";echo $row['date_to']; ?></p>
                        <p class="price"><?php echo $row['venue']; ?></p>
                        <p><?php echo $row['description']; ?></p>
                        <p><?php 
							if (date("Y-m-d") <= $row['date_to']){

                        		echo "<a href='registration_link.php?event_id=".$row['event_id']."' class='btn btn-primary'>Get Registeration Link</a>";
                    		}
                    		else{

                    			$q = 'SELECT count(*) FROM registrations WHERE event_id='.$row['event_id'];
                    			$r = $con->query($q);
                    			$r1 = $r->fetch_assoc();
                    			echo "<p class='title text-center'><br>Total Number of Participants : ".$r1['count(*)']."<br></p>";
                    		}
                    		?></p>
                    </div>
                </div>

            <?php endwhile?>
                
            </div>
        </div>
    </section>
    <!-- Pricing End -->
    </footer>
    <!-- Footer Endt -->
    <!--jQuery-->
    <script src="assets/js/jquery-3.3.1.js"></script>
    <!--Plugins-->
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/loaders.css.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/lightgallery-all.min.js"></script>
    <!--Template Script-->
    <script src="assets/js/main.js"></script>
</body>

</html>
