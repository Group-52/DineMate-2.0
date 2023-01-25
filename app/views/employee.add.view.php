<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Add Employee</title>
    </head>

    <body>
        <h2>Employee> New Employee</h2>
        <button type="submit" name="save"><a href="#">Save</a></button>

        <form action = "" method = "POST"> 
            <div class="row">
                <div class="col">
                    <label for="name"><b>Name</b></label><br>
                    <input type = "text" name = "name" placeholder = "Name" required>
                </div>

                <div class="col">
                    <label for="role"><b>Role</b></label><br>
                    <input type = "text" name = "role" placeholder = "Role" required>
                </div>

                <div class="col">
                    <label for="salary"><b>Salary</b></label><br>
                    <input type = "text" name = "salary" placeholder = "Salary">
                </div>

                <div class="col">
                    <label for="DOB"><b>Date Of Birth</b></label><br>
                    <input type = "date" name = "DOB" placeholder = "DOB">
                </div>

                <div class="col">
                    <label for="contact_no"><b>Contact No</b></label><br>
                    <input type = "number" name = "contact_no" placeholder = "Contact No">
                </div>

                <div class="col">
                    <label for="NIC"><b>NIC</b></label><br>
                    <input type = "text" name = "NIC" placeholder = "NIC">
                </div>

            </div>
        </form>
    </body>
</html>