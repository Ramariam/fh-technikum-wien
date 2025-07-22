<?php
include("./models/person.php");

class DataHandler
{
    public function queryPersons()
    {
        // Demodaten abrufen
        return $this->getDemoData();
    }

    // Abfrage einer Person anhand der ID
    public function queryPersonById($id)
    {
        $result = array();
        foreach ($this->queryPersons() as $val) {
            if ($val[0]->id == $id) {
                array_push($result, $val);
            }
        }
        return $result;
    }

    // Abfrage einer Person anhand des Namens
    public function queryPersonByName($name)
    {
        $result = array();
        foreach ($this->queryPersons() as $val) {
            if ($val[0]->name == $name) {
                array_push($result, $val);
            }
        }
        return $result;
    }

    // Abfrage einer Person anhand der E-Mail-Adresse
    public function queryPersonByEmail($email)
    {
        $result = array();
        foreach ($this->queryPersons() as $person) {
            if ($person[0]->email == $email) {
                array_push($result, $person);
            }
        }
        return $result;
    }

    // Extension A: Abfrage von Personen nach dem Vornamen
    public function queryPersonByFirstName($firstName)
    {
        $result = array();
        foreach ($this->queryPersons() as $val) {
            foreach ($val as $person) {
                if ($person->firstname == $firstName) {
                    $result[] = $person;
                }
            }
        }
        return $result;
    }

    // Extension B: Abfrage von Personen nach dem Department
    public function queryPersonByDepartment($department)
    {
        $result = array();
        foreach ($this->queryPersons() as $val) {
            foreach ($val as $person) {
                if ($person->department == $department) {
                    $result[] = $person;
                }
            }
        }
        return $result;
    }

    // Demodaten erstellen
    private static function getDemoData()
    {
        $demodata = [
            [new Person(1, "Jane", "Doe", "jane.doe@fhtw.at", 1234567, "Central IT")],
            [new Person(2, "John", "Doe", "john.doe@fhtw.at", 34345654, "Help Desk")],
            [new Person(3, "baby", "Doe", "baby.doe@fhtw.at", 54545455, "Management")],
            [new Person(4, "Mike", "Smith", "mike.smith@fhtw.at", 343477778, "Faculty")],
            [new Person(5, "Drake", "Millers", "jane.doe@office.com", 12345678, "Central IT", "Software Developer")],
            [new Person(6, "Ariana", "Grande", "Ariana.grande@admin.com", 87654321, "Help Desk", "IT Support Specialist")],
            [new Person(7, "Susi", "Wolf", "Susi.wolf@admin.com", 87654321, "Help Desk", "IT Support Specialist")],
            [new Person(8, "Josh", "Sun", "Josh.sun@admin.com", 87654321, "Help Desk", "IT Support Specialist")],
            [new Person(9, "Jessica", "Doe", "jessica.doe@fhtw.at", 9876543, "Administration")],
            [new Person(10, "Michael", "Johnson", "michael.johnson@fhtw.at", 4567890, "Finance")],
        ];

        return $demodata;
    }
}
?>
