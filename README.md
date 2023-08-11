# Applicants Assignment
## Objectives:
- Implement a PHP restful API
- Implement a simple frontend to consume the API
## General Instructions:
- Fork the repository and create a pull request when you are done.
- This assignment is meant to be completed alone, without any help from others.
- You are free to use any resources you can find online.
- Your code will be inspected to ensure instructions are followed.
## After successfully completing this assignment: 
- You will be invited for an interview.
---
# Assignment Instructions:
## Backend:
- Create a PHP restful API that will allow the following actions:
    - Your backend should consume the following payload:
        ```json
        {
            "Unit Name": "String",
            "Arrival": "<dd-mm-yyyy>",
            "Departure": "<dd-mm-yyyy>",
            "Occupants": <int>,
            "Ages": [<int array>]
        }
        ```
    - Your backend will then mutate the data and pull rates from a remote API:
        - The remote API is located at: https://dev.gondwana-collection.com/Web-Store/Rates/Rates.php
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
- Create a simple frontend to generate the request, and display the response body.
    - The front-end display the following:
        - Unit Name
        - Rate
        - Date range
        - Availability
- You have creative freedom in terms of how the interface should look.
