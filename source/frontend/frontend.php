<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Unit Availability</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
      background-color: #f9f9f9;
    }

    h1 {
      text-align: center;
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: 0.3rem;
      font-weight: bold;
    }

    input[type="date"] {
      padding: 0.4rem;
      width: 100%;
      max-width: 300px;
    }

    button {
      padding: 0.6rem 1.2rem;
      font-size: 1rem;
      margin-top: 1rem;
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
      background: white;
    }

    th, td {
      padding: 0.8rem;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #eee;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Unit Availability</h1>
    <div class="form-group">
      <label for="startDate">Start Date:</label>
      <input type="date" id="startDate">
    </div>
    <div class="form-group">
      <label for="endDate">End Date:</label>
      <input type="date" id="endDate">
    </div>
    <button onclick="fetchAvailability()">Check Availability</button>

    <table id="resultsTable" style="display: none;">
      <thead>
        <tr>
          <th>Unit Name</th>
          <th>Rate</th>
          <th>Date Range</th>
          <th>Availability</th>
        </tr>
      </thead>
      <tbody id="resultsBody">
      </tbody>
    </table>
  </div>

  <script>
    async function fetchAvailability() {
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;

      // if (!startDate || !endDate) {
      //   alert('Please select both start and end dates.');
      //   return;
      // }

      const response = await fetch('/php/booking', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ start_date: startDate, end_date: endDate })
      });

      const data = await response.json();

      const table = document.getElementById('resultsTable');
      const tbody = document.getElementById('resultsBody');
      tbody.innerHTML = ''; // Clear old results

      data.forEach(unit => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${unit.name}</td>
          <td>${unit.rate}</td>
          <td>${startDate} to ${endDate}</td>
          <td>${unit.available ? 'Available' : 'Unavailable'}</td>
        `;
        tbody.appendChild(row);
      });

      table.style.display = 'table';
    }
  </script>
</body>
</html>