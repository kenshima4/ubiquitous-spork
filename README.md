# Job Application Assignment
Welcome applicant, we're glad that you've shown interest in our open position. As a part of the selection process, we would like you to complete a small task that will allow us to assess your skills and capabilities.

## Objective:
- Develop a PHP restful API
- Construct a simple UI to interact with the API

## General Guidelines:
1. Please start the assignment by forking the repository and creating a pull request once you have completed your task.
2. Remember, this is an individual assignment, hence, collaboration isn't allowed.
3. Feel free to utilize any online resources for guidance.
4. Code will be reviewed meticulously to ensure our guidelines and instructions were strictly followed.

Upon successful completion and evaluation of this assignment, you would be shortlisted for the subsequent interview round.

---
# Detailed Assignment Instructions:
## Backend:
1. Build a PHP restful API capable of performing the following operations:
    - The backend should be able to ingest the following payload:
        ```json
        {
            "Unit Name": "String",
            "Arrival": "<dd-mm-yyyy>",
            "Departure": "<dd-mm-yyyy>",
            "Occupants": <int>,
            "Ages": [<int array>]
        }
        ```
    - Post API call to the following address with the converted payload:
      [Remote API Address](https://dev.gondwana-collection.com/Web-Store/Rates/Rates.php)
        - Mutate your ingested payload to the following format to fit the parameters of the remote API:
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
    - Relay the obtained rates back to the frontend
    - Use the following Unit Type IDs [-2147483637,-2147483456] for testing. 
## Frontend:
1. Construct a simple, interactive and user-friendly frontend to send requests to your API and display the responses.
    - The frontend should aid the users in visualising the following data:
        - Unit Name
        - Rate
        - Date Range
        - Availability
        
- The UI design is left to your discretion and creativity, however, the emphasis should be on functionality and user experience.

Thank you for your interest and we look forward to reviewing your work! Good luck.
