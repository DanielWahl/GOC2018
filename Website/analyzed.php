<html>
<head>
    <meta charset="utf-8"/>
    <title>Game of Code 2018</title>
    <link rel="stylesheet" type="text/css" href="style/style.css" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="content">

    <header id="analyzed">
        <div id="h_overlay">
            <div id="resize_content">
                <nav>
                    <div id="nav_desktop">

                        <ul>
                            <li><a class="logo">LetMeArrive</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="api.html">API</a></li>
                            <li><a href="index.html">Start</a></li>
                        </ul>

                    </div>

                    <div id="nav_scroll">

                        <ul>
                            <li><a href="" class="logo">LetMeArrive</a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a href="api.html">API</a></li>
                            <li><a href="index.html">Start</a></li>
                        </ul>

                    </div>

                    <div id="nav_mobile">

                        <div class="logo"><span style="color: white;">LetMeArrive</span></div>

                        <div id="open_nav" onclick="open_navigation();">lll</div>

                        <div id="close_nav" onclick="close_navigation();">&times;</div>

                        <div id="nav_mobile_container">
                            <ul>
                                <li><a href="index.html">Start</a></li>
                                <li><a href="contact.html">API</a></li>
                                <li><a href="api.html">Contact</a></li>
                            </ul>
                        </div>

                    </div>
                </nav>

                <div class="clear"> </div>

                <div id="fields">

                    <form method="post" action="start">

                        <input type="text" name="departure" class="departure" placeholder="Departure"/><br>
                        <input type="text" name="destination" class="destination" placeholder="Destination"><br>
                        <input type="submit" name="submit" value="Start" />

                    </form>


                </div>
            </div>
        </div>
    </header>


    <div class="clear"></div>


    <section id="evaluation">

        <script>

            function getTransports(start_lat, start_lng, dest_lat, dest_lng) {
                let xml = new XMLHttpRequest();
                xml.open("POST", "API/getTransports.php");

                xml.addEventListener("load", (e) => {
                    console.log(JSON.parse(e.target.response));

                });

                let data = new FormData();

                data.append("start_lng", start_lat);
                data.append("start_lat", start_lng);
                data.append("dest_lng", dest_lng);
                data.append("dest_lat", dest_lat);

                xml.send(data);


            }

            const START_LAT = "" + <?php echo $_POST['start_lat']; ?>;
            const START_LNG = "" + <?php echo $_POST['start_lng']; ?>;
            const DEST_LAT  = "" + <?php echo $_POST['dest_lat'];  ?>;
            const DEST_LNG  = "" + <?php echo $_POST['dest_lng'];  ?>;

            addEventListener("load", ()=> {
                getTransports(START_LAT, START_LNG, DEST_LAT, DEST_LNG);
            });



        </script>

        <div class="content">
            <span id="testresult"></span>
            <p>
                Dier braucht mam:<br>
                <table>
                <tr>
                    <th>Bus</th>
                    <td>x min</td>
                    <td>x km</td>
                </tr>
                <tr>
                    <th>Véloh</th>
                    <td>x min</td>
                    <td>x km</td>
                </tr>
                <tr>
                    <th>Auto</th>
                    <td>x min</td>
                    <td>x km</td>
                </tr>
                </table>
            </p>
        </div>

    </section>


    <div class="clear"></div>


    <section id="mapeval">

        <div class="content">

            <div class="overlay" onClick="style.pointerEvents='none';"></div>
            <div id="map"></div>
            <div class="clear"></div>

        </div>

    </section>

</div>

<!-- SCRIPTS -->
<script src="scripts/navigation.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0klnwhWakNF6e3pkI2hkYGvu-By8CZ7I&callback=initMapindex" async defer></script>
</body>
</html>
