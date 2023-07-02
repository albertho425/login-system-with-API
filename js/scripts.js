//Declare constants and variables

let timeZoneText = document.getElementById("timezone");
let countryText = document.getElementById("country");
let longText = document.getElementById("longitude");
let latText = document.getElementById("latitude");
let weatherText = document.getElementById("weather");
let conditionText = document.getElementById("condition");
let weatherIconText = document.getElementById("weatherIcon");
let cityText = document.getElementById("city");
let exchangeRateText = document.getElementById("exchangeRate");


// When the page loads, run these functions
window.onload = getData();
// window.onload = getWeatherData();



//Get data from API

async function getData() {

    const dataURL = "https://ipapi.co/json/";
    

    try {
        const response2 = await fetch(dataURL, {cache: "no-cache"});
        const result = await response2.json();
    
        if (response2.ok) {
            console.log("the API result is: " , result);

            let theIpAddress = result["ip"];
            console.log (theIpAddress);
            let theTimeZone = result["timezone"];
            console.log(theTimeZone);
            let theCountry = result["country_code"];
            let theLongitude = result["longitude"];
            let theLatitude = result["latitude"];
            
            outputTimeZone(theTimeZone);
            outputCountry(theCountry);
            
            getWeatherData(theLatitude,theLongitude);
            getCurrencyData(theIpAddress);
            hideSpinner();
        }

    } catch (error) {
        if (error) throw error;
        console.log("Time/date/location error: ", error);
        showSpinner();
    
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
            hideSpinner();
        }

    } catch (error) {
        if (error) throw error;
        console.log("Weather API error: ", error);
        showSpinner();
    
    }
}

/**
 * Get the currency based on IP address
 * @param {*} ipAdressInput 
 */

async function getCurrencyData(ipAdressInput) {
    const currencyURL = "https://ipapi.co/" + ipAdressInput + "/json/";

    try {
        const currencyReponse = await fetch(currencyURL, {cache: "no-cache"});
        const currencyResult = await currencyReponse.json();
        


        if (currencyReponse.ok) {
            console.log("the Currency API result is: " , currencyResult);

            let tempCurrency = currencyResult.currency;
            let exchangeRate = getExchangeRate(tempCurrency);
            console.log("Exchange Rate is: " + exchangeRate);
            hideSpinner();
            
        }

    } catch (error) {
        if (error) throw error;
        console.log("Currency API error: ", error);
        showSpinner();
    
    }
}

/**
 * Get the exchange rate from USD to user's local currency
 * @param {*} currencyInput 
 */

async function getExchangeRate(currencyInput) {
    const currencyURL = "https://api.apilayer.com/exchangerates_data/convert?to=USD&from=" + currencyInput + "&amount=1&apikey=" +  currencyAPIKey;

    try {
        const currencyReponse = await fetch(currencyURL, {cache: "no-cache"});
        const currencyResult = await currencyReponse.json();
        


        if (currencyReponse.ok) {
            console.log("the Exchange Rate from API is: " , currencyResult);

            let exchangeValue = (currencyResult.result).toFixed(2);
            let finalResult = exchangeValue + " " + currencyResult.query.from;

            outputExchangeRate(finalResult);
            hideSpinner();
            
        }

    } catch (error) {
        if (error) throw error;
        console.log("Exchange API error: ", error);
        showSpinner();
    
    }
}




// Functions for output or logic

    
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

    //Output the exchange rate

    function outputExchangeRate(currencyInput) {

        exchangeRateText.innerHTML = currencyInput;
    }

    /**
     * Hide the spinner
     */

    function hideSpinner() {
        document.getElementById('spinner')
                .style.display = 'none';
    } 

    /**
     * Show the spinner
     */

    function loadSpinner() {
        document.getElementById('spinner')
                .style.display = '';
    }