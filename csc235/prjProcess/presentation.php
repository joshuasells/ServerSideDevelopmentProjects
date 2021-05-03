<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- presentation.php - This page is part of the Employee Schedule application.
  It's purpose is to establish a needs assessment and is to be presented to the board of directors -->
<!-- Author: Joshua Sells
  Written: 11/24/2020
  Revised:
-->
<title>Employee Schedule Presentation</title>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <div id="frame">
  <h1>Employee Schedule</h1>
    <!-- Navigation -->
  <header>
    <nav>
      <ul class="navLinks">
        <li><a href="presentation.php">Home</a></li>
        <li><a href="index.php">User View</a></li>
        <li><a href="edit.php">Edit Page</a></li>
<!--        <li><a href="dbfCreate.php">Reset Database</a></li> -->
    </nav>
  </header>
    <h2>
      Written by: Joshua Sells<br />
      Date: 11/24/2020  
    </h2>

    <h3>
      The purpose of this page is to discover the needs of the application to be created.<br />
      Listed are some questions and answers to provide information and context on the details of the application needs.<br />

    </h3>

    <h3>Questions and Answers</h3>
    <dl>
      <dt>Who is this application for?</dt>
      <dd>This application is going to be created for two audiences. Employees and Managers.</dd>
      <dt>What is this application going to accomplish?</dt>
      <dd>This application is going to display a table of an employee shift schedule for employees to view.
        It is also going to provide an admin page where a manager can edit the schedule as needed.</dd>
      <dt>What is the purpose of this application?</dt>
      <dd>The purpose of this application is so that there can be one accurate location of the shift schedule for all employees.
        Each employee will have access to this schedule wherever they are and a manger can update it in real time from anywhere.</dd>
      <dt>What data will I need in order to satisfy the application requirements?</dt>
      <dd>The only data needed will be the employees first name, last name. The manager will make their own schedule as they see fit.</dd>
      <dt>What admin actions will need to be created to satisfy the application requirements?</dt>
      <dd>A manager should be able to perform the following actions:
        <ul>
          <li>Add and remove employees from the database.</li>
          <li>Schedule any employee for any day or time as they see fit.</li>
        </ul>
      </dd>
    </dl>
    <h3>Table of sample data</h3>
    <table border="1">
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Time</th>
      </tr>
      <tr>
        <td>Shawn Johnson</td>
        <td>11/25/2020</td>
        <td>7-3</td>
      </tr>
      <tr>
        <td>Jeff Walten</td>
        <td>11/26/2020</td>
        <td>8-4</td>
      </tr>
      <tr>
        <td>Joshua Connor</td>
        <td>11/24/2020</td>
        <td>3-11</td>
      </tr>
      <tr>
        <td>Macy Jackson</td>
        <td>11/28/2020</td>
        <td>12-8</td>
      </tr>
    </table>
    <h3>Implementation</h3>
    <p>One way to approach this application is to keep data in a database and display the data in a table for each employee.
      The employee can click on their name and table will be displayed showing just their shifts.
    </p>
    <p>Another way to approach this application is to also keep the data in a database, but display all the data at once in one table for all employees.
      Along the top line of the table the seven days of the week can be displayed. Along the left side each employee can be listed.
      In this way, a two dimensional table can be displayed that shows all the data for each employee at the same time.
    </p>
    <p>After thinking carefully, I recommend the second option. This would provide a neat way to display more data without it becoming over complicated.
      This way, each employee can easily see their coworker's shift in case they would like to try and switch shifts. The second option is a more versatile, simple option.
    <h4>Prototype</h4>
    <p>Below is a link to my sketch prototype.</p><br />
    <a href="graphic/prototype.html" target="_blank"><img src="graphic/employeeSchedulePrototypePage1.png" alt="prototype" height="200"></a>
    <a href="graphic/prototype.html" target="_blank"><img src="graphic/employeeSchedulePrototypePage2.png" alt="prototype" height="200"></a>
  </div>
</body>
</html>