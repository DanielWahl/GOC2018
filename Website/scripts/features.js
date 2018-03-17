function checkInputs() {

    let autocomplete    = $('#autocomplete').attr('value');
    let autocomplete2   = $('#autocomplete2').attr('value');

    return ((autocomplete === undefined || autocomplete === null || autocomplete === "") ||
    (autocomplete2 === undefined || autocomplete2 === null || autocomplete2 === ""));

}

function loadValues() {


    if(document.getElementById("start_lat").value === "") return false;
    if(document.getElementById("start_lng").value === "") return false;
    if(document.getElementById("dest_lat").value === "") return false;
    if(document.getElementById("dest_lng").value === "") return false;

    changeTemplate();

    let xml = new XMLHttpRequest();

    xml.open("POST", "../API/getTransports.php");

    xml.onload = (e) => {
        let response = JSON.parse(e.target.response);


        httpRequestLoaded();

        console.log(response);

        /*console.log("Walk");
        console.log(response.walk[1].duration + "s");
        console.log(response.walk[1].distance + "m");
        console.log("Car");
        console.log(response.car[1].duration + "s");
        console.log(response.car[1].distance + "m");
        console.log("Veloh");
        console.log("Distance to nearest bikestation");
        console.log(response.veloh[1].duration + "s");
        console.log(response.veloh[1].distance + "m");
        console.log("way by bike");
        console.log(response.veloh[2].duration + "s");
        console.log(response.veloh[2].distance + "m");
        console.log("Distance to destination");
        console.log(response.veloh[3].duration + "s");
        console.log(response.veloh[3].distance + "m");*/

        let busdist     = +((response.bus.distance).toFixed(2));
        let bustime     = Math.round(response.bus.time);
        let busprice    = 2;
        let velohdist   = +(((response.veloh[1].distance + response.veloh[2].distance + response.veloh[3].distance)/1000).toFixed(2));
        let velohtime   = Math.round((response.veloh[1].duration + response.veloh[2].duration + response.veloh[3].duration)/60);
        let velohprice  = 0;
        let cardist     = +((response.car[1].distance/1000).toFixed(2));
        let cartime     = Math.round(response.car[1].duration/60);
        let carprice    = +(((8*cardist/100)*1.1).toFixed(2)); //8 is the average fuel used by a car for every 100 km, 1.1 is the average fuel price per liter
        let persondist  = +((response.walk[1].distance/1000).toFixed(2));
        let persontime  = Math.round(response.walk[1].duration/60);
        let personprice = 0;

        if(velohtime>30 && velohtime<=90)        velohprice = 1;
        else if(velohtime>90 && velohtime<=150)  velohprice = 2;
        else if(velohtime>150 && velohtime<=210) velohprice = 3;
        else if(velohtime>210 && velohtime<=270) velohprice = 4;
        else if(velohtime>270)                   velohprice = 5;

        let content = "<span id='testresult'></span>"+
        "<p>"+
        "Dier braucht mam:<br></p>"+
        "<table>"+
        "   <tr>"+
        "       <th><img src='images/bus.svg' style='height:auto;width:60px'></th>"+
        "       <td><span id='bus_zeit'></span>" + bustime + " min</td>"+
        "       <td><span id='bus_distance'></span>" + busdist + " km</td>"+
        "       <td><span id='bus_price'></span>" + busprice + " €</td>"+
        "   </tr>"+
        "   <tr>"+
        "       <th><img src='images/bicycle.svg' style='height:auto;width:60px'></th>"+
        "       <td><span id='veloh_zeit'></span>" + velohtime + " min</td>"+
        "       <td><span id='veloh_distance'></span>" + velohdist + " km</td>"+
        "       <td><span id='veloh_price'></span>" + velohprice + " €</td>"+
        "   </tr>"+
        "   <tr>"+
        "       <th><img src='images/auto.svg' style='height:auto;width:60px'></th>"+
        "       <td><span id='auto_zeit'></span>" + cartime + " min</td>"+
        "       <td><span id='auto_distance'></span>" + cardist + " km</td>"+
        "       <td><span id='auto_price'></span> ~" + carprice + " €</td>"+
        "   </tr>"+
        "   <tr>"+
        "       <th><img src='images/person.svg' style='height:70px;~width:auto'></th>"+
        "       <td><span id='person_zeit'></span>" + persontime + " min</td>"+
        "       <td><span id='person_distance'></span>" + persondist + " km</td>"+
        "       <td><span id='person_price'></span>" + personprice + " €</td>"+
        "   </tr>"+
        "</table>";

        $('#result').html(content);

    };

    let data = new FormData();

    data.append("start_lat", document.getElementById("start_lat").value);
    data.append("start_lng", document.getElementById("start_lng").value);
    data.append("dest_lat", document.getElementById("dest_lat").value);
    data.append("dest_lng", document.getElementById("dest_lng").value);
    xml.send(data);

    return false;

}