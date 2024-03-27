### Technical Documentation for the Incidents Management System (IMS)

---

#### Introduction

**Overview:** 
This technical manual provides the necessary information for setting up and managing the Incidents Management System (IMS) using Docker, which encapsulates the components of the LAMP stack.

**URL for Start Page:** 
`http://localhost/cw2/index.php`

**File Structure:**

- `cw2/`: Main application directory.
  - `css/`: Style sheets including `style.css`.
  - `inc/`: PHP includes and utility scripts.
  - `js/`: JavaScript files including `script.js`.
  - `sql/`: Database scripts including `cw2.sql`.
  - `index.php`: Landing page for the IMS.
  - other PHP files: Core application scripts.
- `car.ico`: Favicon for the web application.
- **Docker Configuration:**

- `docker-compose.yml`: Docker configuration for setting up the environment.

**Docker Configuration:**

- `php-apache/`: Custom PHP and Apache server configuration.
- `mariadb/`: MariaDB server configuration and initial SQL files.
- `mariadb-data/`: Persistent storage for MariaDB.
- `phpmyadmin/`: PHPMyAdmin interface for database management.

---

#### System Installation

**Software Dependencies:**

- Docker and Docker Compose
- PHP 8.0, MariaDB 10, and Apache web server

**Installation Steps:**

1. Install Docker from [Docker Official Website](https://www.docker.com/products/docker-desktop/).
2. Navigate to the project directory.
3. Execute `docker compose up` to build and start the services.
4. Once the containers are running, access IMS at `http://localhost/cw2/index.php` and PHPMyAdmin at `http://localhost:8081`.

**Initial Configuration:**

- The `config.php` file should match the Docker MariaDB configuration for database connectivity.

---

#### System Architecture

**Code Organization:**

- **Directory Structure:** The `html/` directory hosts all web resources including HTML, PHP, CSS, and JavaScript files.
- **PHP Includes:** `inc/` directory contains shared PHP scripts like headers and footers.
- **Functions:** A library of functions (`functions.php`) provides common operations such as database access and user authentication.
- **Database Interaction:** `sql/` directory stores the initial database schema and scripts for the IMS.

**Database Design:**

- **Schema:** The `cw2.sql` file contains the database schema for the TIS.
- **Data Persistence:** The `mariadb-data/` directory serves as the persistent storage for the MariaDB container.
- **Queries:** Key SQL queries for operations such as user login, record retrieval, and report generation.
  - **Login**: `SELECT * FROM Police WHERE Police_username = $username AND Police_password = $password`
  - **QueryVehicle**: `SELECT Vehicle.*, People.* FROM Vehicle LEFT JOIN Ownership ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID LEFT JOIN People ON Ownership.People_ID = People.People_ID WHERE Vehicle.Vehicle_licence LIKE $info`
  - **AddReport**： `INSERT INTO Incident (Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES ($vehicleID, $peopleID, $incidentDate, $incidentReport, $offenceID)`


---

#### Frontend and Backend Interaction

**AJAX and JavaScript:** 

- Asynchronous data interactions are handled using native JavaScript without third-party libraries.

**Security Practices:**

- Use of prepared statements for database interaction to mitigate SQL injection risks.

---

#### Maintenance and Expansion

**Development Practices:**

- Adherence to established PHP and web development standards.

**System Extensibility:**

- The modular design allows for the addition of new features with minimal impact on existing functionalities.

---

#### Additional Information

**Rebuilding the Database:**

- To reset and rebuild the database from the SQL source in `mariadb/`, clear the `mariadb-data/` directory and run `docker compose up`.

---

#### Resources Used

**Frameworks:**

- Bootstrap: Provides the responsive UI components.

**Assets:**

- `car.ico`: Icon used across the system for visual identification.

**Styles:**

- `mvp.css`: Minimal stylesheet for attractive defaults.

**External Code:**

- Example code from the module and various utility functions and UI patterns adapted from online resources.
