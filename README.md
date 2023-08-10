# Applicants Assignment <img src="https://media.giphy.com/media/3nxvpK0CSxT88bFfig/giphy.gif"  width="200" hight="200" style="float: right; padding : 10px"/>
## Objectives:
- Implement a php restful api
- Implement a simple frontend to consume the api
## General Instructions:
- Fork the repository and create a pull request when you are done.
- This assigment is meant to be completed alone, without any help from others.
- You are free to use any resources you can find online.
- You code will be inspected to ensure instructions were followed.
## After successfuly completing this assignment: <img src="https://media.giphy.com/media/gLcUG7QiR0jpMzoNUu/giphy.gif"  width="200" hight="200" style="float: right; padding : 10px"/>
- You will be invited for an interview.
---
# Assignment Instructions:
## Backend:
- Create a php restful api that will allow the following actions:
    - Your backend should comsume the following payload:
        ```json
        {
            "Unit Name": "String",
            "Arrival": "<dd-mm-yyyy>",
            "Departure": "<dd-mm-yyyy>",
            "Occupants": <int>,
            "Ages": [<int array>]
        }
        ```
    - Your backend will them mutate the data and pull rates from a remote api:
        - The remote api is located at: https://dev.gondwana-collection.com/Web-Store/Rates/Rates.php
        - Post request with the following payload:
        ```json
        {
            "Unit Type ID": <int>,
            "Arrival": "yyyy-mm-dd",
            "Departure": "yyyy-mm-dd",
            "Guests": [
                {
                    "Age Group": "Adult"
                },
                {
                    "Age Group": "Adult"
                }
            ]
        }
        ```
    - Return the rates to the frontend
## Frontend:
- Create a simple frontend that will generate the request, and display the response body.
    - The front-end display the following:
        - Unit Name
        - Rate
        - Date range
        - Availability
- You have creative freedom in terms of how the interface should look.