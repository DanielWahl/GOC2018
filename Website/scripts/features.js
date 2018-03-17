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

        console.log(response);

        console.log("Walk");
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
        console.log(response.veloh[3].distance + "m");



    };

    let data = new FormData();

    data.append("start_lat", document.getElementById("start_lat").value);
    data.append("start_lng", document.getElementById("start_lng").value);
    data.append("dest_lat", document.getElementById("dest_lat").value);
    data.append("dest_lng", document.getElementById("dest_lng").value);
    xml.send(data);

    return false;

}