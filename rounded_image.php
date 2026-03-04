<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student List</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }

    .card:hover {
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 15px;
    }

    .card-title {
      font-size: 1.2rem;
      margin-bottom: 5px;
      color: #343a40; /* Dark text color */
    }

    .card-text {
      font-size: 1rem;
      margin-bottom: 5px;
      color: #343a40; /* Dark text color */
    }

    .badge-container {
      display: flex;
      flex-wrap: wrap;
    }

    .badge {
      margin-right: 10px;
      margin-bottom: 5px;
      font-size: 0.9rem;
      padding: 8px 12px;
      border-radius: 20px;
    }

    .badge i {
      margin-right: 5px;
    }

    .badge-info {
      background-color: #17a2b8;
      color: #fff;
    }

    .badge-warning {
      background-color: #ffc107;
      color: #212529;
    }

    .badge-secondary {
      background-color: #6c757d;
      color: #fff;
    }

    /* Remove underline from anchor tags on hover */
    a.card:hover {
      text-decoration: none;
    }

    .mobile-number {
      color: #007bff; /* Blue color for the phone number */
      cursor: pointer;
    }

    .mobile-number:hover {
      text-decoration: underline; /* Underline when hovered */
    }

    .student-class {
      float: right; /* Align on the right side */
      margin-left: 10px;
    }

    .class-label {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="my-4">Student List</h1>
    <!-- Search bar -->
    <form class="form-inline mb-4">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
      <button class="btn btn-outline-secondary my-2 my-sm-0" type="button" onclick="searchStudents()">Search</button>
    </form>
    <!-- Filters -->
    <div class="row mb-4">
      <div class="col-md-4">
        <select class="form-control" id="bookFilter">
          <option value="">All Book Fees</option>
          <option value="0">No Book Fee Pending</option>
          <option value="1">1 Book Fee Pending</option>
          <option value="2">2 Book Fees Pending</option>
          <option value="3">3 or more Book Fees Pending</option>
        </select>
      </div>
      <div class="col-md-4">
        <select class="form-control" id="schoolFeeFilter">
          <option value="">All School Fees</option>
          <option value="0">No School Fee Pending</option>
          <option value="50">School Fee Pending: $50</option>
          <option value="100">School Fee Pending: $100</option>
          <option value="200">School Fee Pending: $200</option>
        </select>
      </div>
      <div class="col-md-4">
        <select class="form-control" id="transportationFilter">
          <option value="">All Transportation Fees</option>
          <option value="0">No Transportation Fee Pending</option>
          <option value="25">Transportation Fee Pending: $25</option>
          <option value="50">Transportation Fee Pending: $50</option>
          <option value="75">Transportation Fee Pending: $75</option>
        </select>
      </div>
    </div>
    <!-- Student Cards -->
    <div class="row" id="studentList">
      <div class="col-md-4 mb-4">
        <a href="#" class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">John Doe</h5>
            <p class="card-text">
              <span class="student-class"><span class="class-label">Class:</span> 10</span>
              <i class="bi bi-telephone"></i> <span class="mobile-number" onclick="makeCall('123-456-7890')">123-456-7890</span>
            </p>
            <div class="badge-container">
              <span class="badge badge-info"><i class="bi bi-book"></i> Books Pending: 3</span>
              <span class="badge badge-warning"><i class="bi bi-currency-dollar"></i> Fees Pending: $100</span>
              <span class="badge badge-secondary"><i class="bi bi-bus"></i> Transportation Pending: $50</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4 mb-4">
        <a href="#" class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">John Doe</h5>
            <p class="card-text">
              <span class="student-class"><span class="class-label">Class:</span> 10</span>
              <i class="bi bi-telephone"></i> <span class="mobile-number" onclick="makeCall('123-456-7890')">123-456-7890</span>
            </p>
            <div class="badge-container">
              <span class="badge badge-info"><i class="bi bi-book"></i> Books Pending: 3</span>
              <span class="badge badge-warning"><i class="bi bi-currency-dollar"></i> Fees Pending: $100</span>
              <span class="badge badge-secondary"><i class="bi bi-bus"></i> Transportation Pending: $50</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4 mb-4">
        <a href="#" class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">John Doe</h5>
            <p class="card-text">
              <span class="student-class"><span class="class-label">Class:</span> 10</span>
              <i class="bi bi-telephone"></i> <span class="mobile-number" onclick="makeCall('123-456-7890')">123-456-7890</span>
            </p>
            <div class="badge-container">
              <span class="badge badge-info"><i class="bi bi-book"></i> Books Pending: 3</span>
              <span class="badge badge-warning"><i class="bi bi-currency-dollar"></i> Fees Pending: $100</span>
              <span class="badge badge-secondary"><i class="bi bi-bus"></i> Transportation Pending: $50</span>
            </div>
          </div>
        </a>
      </div>
      <!-- Add more student cards here -->
    </div>
  </div>

  <!-- Bootstrap JS and dependencies (jQuery and Popper.js) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>
</html>
