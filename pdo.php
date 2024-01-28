<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'root';
    private $database = 'hrm_project';

    private $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
class Employees
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllEmp()
    {
        try {
            $sql = "SELECT CONCAT(e.first_name, ' ', e.middle_name, ' ', e.last_name) AS name,
                        e.birthdate,
                        e.sex,
                        d.dept_name
                    FROM employees AS e
                    INNER JOIN employees_unitassignments AS eu ON e.idemployees = eu.employees_idemployees
                    INNER JOIN departments AS d ON eu.departments_iddepartments = d.iddepartments;
                    ";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function empLeave()
    {
        try {
            $sql = "SELECT 
                        CONCAT(e.first_name, ' ', e.middle_name, ' ', e.last_name) AS name,
                        d.dept_name,
                        lt.leave_type AS leave_type
                    FROM 
                        employees AS e
                    INNER JOIN employees_unitassignments AS eu ON e.idemployees = eu.employees_idemployees
                    INNER JOIN departments AS d ON eu.departments_iddepartments = d.iddepartments
                    LEFT JOIN employees_has_leave AS el ON e.idemployees = el.employees_id
                    LEFT JOIN leave_types AS lt ON el.leave_type_id = lt.idleave_types
                    LEFT JOIN service_records AS sr ON e.idemployees = sr.employees_idemployees;
                    ";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}

?>