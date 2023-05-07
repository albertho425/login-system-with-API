//Declare constants and variables

weatherAPIKey = "b2ab7ba8839f62d072e8fb6510491325";
// clockAPIKey = "4uiCjGnH2nha1lOycCS2LRRjYirxKLUU7JoYcGt6";
clockAPIKey = "DaSuash1fkGkipLCCIvIzSulDjDPXNF1CNyh1anC";
const key1  = "4uiCjGnH2nha1lOycCS2LRRjYirxKLUU7JoYcGt6";
const key2 = "CCFMH7s4SxEi70LHvuK6TqEeX5Sf75coHdYMFfA";

let ipAddressText = document.getElementById("ipaddress");
let timeZoneText = document.getElementById("timezone");
let countryText = document.getElementById("country");
let longText = document.getElementById("longitude");
let latText = document.getElementById("latitude");
let weatherText = document.getElementById("weather");
let conditionText = document.getElementById("condition");
let weatherIconText = document.getElementById("weatherIcon");
let cityText = document.getElementById("city");


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
            // let theLocation = result["data"].timezone.id;
            let theCountry = result["data"].location.country.emoji;
            let theDateTime = result["data"].timezone.current_time;
            let theLongitude = result["data"].location.longitude;
            let theLatitude = result["data"].location.latitude;
            
            outputIpAddress(theIpAddress);
            outputTimeZone(theTimeZone);
            outputCountry(theCountry);
            
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
            let condtion = weatherResult.weather[0].main;
            let condtionDescription = weatherResult.weather[0].description;
            let theWeatherIcon = weatherResult.weather[0].icon;
            let theCity = weatherResult.name;

            outputWeather(theWeather);
            outPutWeatherConditions(condtionDescription);
            outputWeatherIcon(theWeatherIcon);
            outputCity(theCity);
        }

    } catch (error) {
        if (error) throw error;
        console.log("Weather API error: ", error);
    
    }
}






// Functions for output or logic

    
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

    //Output the date and time
    function outputDateTime(dateTimeInput)
    {
        dateTimeText.innerHTML = dateTimeInput;
    }

    //Output the weather in C and F units
    function outputWeather(weatherInput)
    {
        let tempF = Math.trunc(convertTemp(weatherInput));
        weatherText.innerHTML = Math.trunc(weatherInput) + " C " + " / " + tempF + " F "
    }

    //Output the country
    function outputCountry(countryInput)
    {
        countryText.innerHTML = countryInput;
    }

    //Convert temperature from C to F
    function convertTemp(tempInput) {

        let tempNumber = Number(tempInput);
        let tempResult = (tempNumber * 9/5) + 32
        console.log("Converted temp in F is: " + tempResult);
        return tempResult;
    }

    //Output the current conditions

    function outPutWeatherConditions(condtionsInput) {

        conditionText.innerHTML = condtionsInput;
    }

    //Output the weather icon


    function outputWeatherIcon(weatherInconInput)

    {
        let theIconCode = weatherInconInput;
        
        weatherIconText.innerHTML = "<img src='http://openweathermap.org/img/w/" + theIconCode +  ".png'>";

    }

    //Output the city from weather API

    function outputCity(cityInput) {

        cityText.innerHTML = cityInput;
    }