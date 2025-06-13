<?php
namespace Frontend;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- for dates -->
  <script type="text/JavaScript" src="https://MomentJS.com/downloads/moment.js"></script>
  <script integrity="jzJ+sNWbKe71gDLLfQKgdtslQjhK70oKLFN+wmwxyg6mQN7Vem+wzce4pryF0HP/"></script>

  <meta charset="UTF-8" />

  <title>Check Unit Availability</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      background-color: #f4f4f4;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-group {
      margin-bottom: 1rem;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 0.3rem;
    }
    input, textarea {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      padding: 0.6rem 1.2rem;
      font-size: 1rem;
      cursor: pointer;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 2rem;
    }
    th, td {
      padding: 0.8rem;
      border: 1px solid #ccc;
    }
    th {
      background-color: #eee;
    }

    
  </style>
</head>
<body id ="document" onload="testing()">
  <div class="container">
    <h1>Check Unit Availability</h1>
    <div class="form-group">
      <label for="unitName">Unit Name</label>
      <input type="text" id="unitName" placeholder="e.g., Desert Camp Chalet" required />
    </div>
    <div class="form-group">
      <label for="arrival">Arrival Date</label>
      <input type="date" id="arrival" required />
    </div>
    <div class="form-group">
      <label for="departure">Departure Date</label>
      <input type="date" id="departure" required />
    </div>
    <div class="form-group">
      <label for="occupants">Occupants</label>
      <input type="number" id="occupants" min="1" required />
    </div>
    <div class="form-group">
      <label for="ages">Ages (comma-separated)</label>
      <input type="text" id="ages" placeholder="e.g., 34,12,8" required />
    </div>
    <button onclick="submitBooking()">Check Availability</button>

    <table id="resultsTable" style="display: none;">
      <thead>
        <tr>
          <th>Unit Name</th>
          <th>Rate</th>
          <th>Date Range</th>
          <th>Availability</th>
        </tr>
      </thead>
      <tbody id="resultsBody"></tbody>
    </table>
  </div>

  <script type="text/javascript">
    async function submitBooking() {
      const unitName = document.getElementById('unitName').value;
      const arrival = document.getElementById('arrival').value;
      const departure = document.getElementById('departure').value;
      const occupants = parseInt(document.getElementById('occupants').value);
      const ages = document.getElementById('ages').value
        .split(',')
        .map(age => parseInt(age.trim()))
        .filter(age => !isNaN(age));

      if (!unitName || !arrival || !departure || !occupants || ages.length === 0) {
        alert('Please fill in all fields correctly.');
        return;
      }

      const payload = {
        "Unit Name": unitName,
        "Arrival": arrival,
        "Departure": departure,
        "Occupants": occupants,
        "Ages": ages
      };

      try {
        const url = 'php/booking';
        
        const response = await fetch(url, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });

        const data = await response.json().then(function (data) {
          console.log(data);
          if (data["status_code_header"] === "HTTP/1.1 200 OK"){
            const tableData = JSON.parse(data.body);
        
            createTable(tableData);
          } else if (data["status_code_header"] === "HTTP/1.1 422 Unprocessable Entity"){
            alert("Please check your inputs carefully.");
          } else {
            alert(error);
          }
          
        });
        
         
      } catch (error) {
        console.error('Error:');
        console.error(error);
        alert('Failed to fetch availability. Check backend or input.');
        
      }
    }

    function testing(){
      console.warn("IN TESTING MODE");
      document.getElementById("unitName").value = "Unit 1";

      const arrivalDateString = "2025-07-20";
      document.getElementById("arrival").value = arrivalDateString;

      const departureDateString = "2025-07-30";
      document.getElementById("departure").value = departureDateString;

      document.getElementById("occupants").value = 3;
      document.getElementById("ages").value = "30,20,10";
    }

    function createTable(data){
      const table = document.getElementById('resultsTable');
      const tbody = document.getElementById('resultsBody');
      tbody.innerHTML = '';

      // Assume response includes fields: unit_name, rate, availability
      const row = document.createElement('tr');
      const begin = moment(data.arrival).format("DD MMMM YYYY");
      const end = moment(data.departure).format("DD MMMM YYYY");
      
      row.innerHTML = `
        <td>${data.unit_name}</td>
        <td>${data.rate}</td>
        <td>${begin} to ${end}</td>
        <td>${data.available ? 'Available' : 'Unavailable'}</td>
      `;
      tbody.appendChild(row);
      table.style.display = 'table';
    }
  </script>
</body>
</html>
