//Declare constants and variables

weatherAPIKey = "b2ab7ba8839f62d072e8fb6510491325";
clockAPIKey = "4uiCjGnH2nha1lOycCS2LRRjYirxKLUU7JoYcGt6";
const key1  = "4uiCjGnH2nha1lOycCS2LRRjYirxKLUU7JoYcGt6";
const key2 = "CCFMH7s4SxEi70LHvuK6TqEeX5Sf75coHdYMFfA";

let ipAddressText = document.getElementById("ipaddress");
let timeZoneText = document.getElementById("timezone");
let locationText = document.getElementById("location");
let dateTimeText = document.getElementById("dateTime");
let longText = document.getElementById("longitude");
let latText = document.getElementById("latitude");
let weatherText = document.getElementById("weather");


// When the page loads, run these functions
window.onload = getData();
// window.onload = getWeatherData();



//Get data from API

async function getData() {

    const dateUrl = "https://api.ipbase.com/v2/info?apikey=" + clockAPIKey;
    // var oReq = new XMLHttpRequest();
    // oReq.addEventListener("load", function () { console.log(this.responseText); });
    // oReq.open("GET", "https://api.ipbase.com/v2/info?ip=1.1.1.1&apikey=" + clockAPIKey);
    // oReq.send();

    try {
        const response2 = await fetch(dateUrl, {cache: "no-cache"});
        const result = await response2.json();
    
        if (response2.ok) {
            console.log("the API result is: " , result);

            let theIpAddress = result["data"].ip;
            let theTimeZone = result["data"].timezone.code;
            let theLocation = result["data"].timezone.id;
            let theDateTime = result["data"].timezone.current_time;
            let theLongitude = result["data"].location.longitude;
            let theLatitude = result["data"].location.latitude;
            
            console.log(theLongitude);
            console.log(theLatitude);

            outputIpAddress(theIpAddress);
            outputTimeZone(theTimeZone);
            outputLocation(theLocation);
            outputDateTime(theDateTime);
            
            getWeatherData(theLatitude,theLongitude);
        }

    } catch (error) {
        if (error) throw error;
        console.log("Time/date/location error: ", error);
    
    }
}

/**
 * Get the weather data from API
 * @param {*} lat 
 * @param {*} long 
 */

async function getWeatherData(lat,long) {

     
    const weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat=" + lat + "&lon=" + long + "&appid=" + weatherAPIKey + "&units=metric";

    try {
        const weatherResponse = await fetch(weatherUrl, {cache: "no-cache"});
        const weatherResult = await weatherResponse.json();


        if (weatherResponse.ok) {
            console.log("the API result is: " , weatherResult);

            let theWeather = weatherResult.main.temp;

            console.log(theWeather);
            outputWeather(theWeather);
        }

    } catch (error) {
        if (error) throw error;
        console.log("Weather API error: ", error);
    
    }
}




//Output data to the screen

    
    //Output the IP address
    function outputIpAddress(ip)
    {
        ipAddressText.innerHTML = ip;
    }
    //Output the time zone
    function outputTimeZone(timeZoneInput)
    {
        timeZoneText.innerHTML = timeZoneInput;
    }

    //Output the location
    function outputLocation(locationInput)
    {
        locationText.innerHTML = locationInput;
    }

    //Output the date and time
    function outputDateTime(dateTimeInput)
    {
        dateTimeText.innerHTML = dateTimeInput;
    }

    //Output the weather
    function outputWeather(weatherInput)
    {
        weatherText.innerHTML = weatherInput;
    }