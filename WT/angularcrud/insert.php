<?php

//insert.php

include('dbconnect.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$username = '';
$password = '';
$firstname = '';
$lastname = '';
$classs = '';
$department = '';
$booksissued = '';
$issuedate = '';

if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT * FROM users WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output['username'] = $row['username'];
        $output['password'] = $row['password'];
		$output['firstname'] = $row['firstname'];
		$output['lastname'] = $row['lastname'];
        $output['classs'] = $row['classs'];
        $output['department'] = $row['department'];
        $output['booksissued'] = $row['booksissued'];
        $output['issuedate'] = $row['issuedate'];
	}
}
elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM users WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Data Deleted';
	}
}
else
{
    if(empty($form_data->username))
    {
        $error[] = 'Username is Required';
    }
    else
    {
        $username = $form_data->username;
    }

    if(empty($form_data->password))
    {
        $error[] = 'Password is Required';
    }
    else
    {
        $password = $form_data->password;
    }

	if(empty($form_data->firstname))
	{
		$error[] = 'First Name is Required';
	}
	else
	{
		$firstname = $form_data->firstname;
	}

	if(empty($form_data->lastname))
	{
		$error[] = 'Last Name is Required';
	}
	else
	{
		$lastname = $form_data->lastname;
	}

    if(empty($form_data->classs))
    {
        $error[] = 'Class is Required';
    }
    else
    {
        $classs = $form_data->classs;
    }

    if(empty($form_data->department))
    {
        $error[] = 'Department is Required';
    }
    else
    {
        $department = $form_data->department;
    }

    if(empty($form_data->booksissued))
    {
        $error[] = 'Books Issued is Required';
    }
    else
    {
        $booksissued = $form_data->booksissued;
    }

    if(empty($form_data->issuedate))
    {
        $error[] = 'Issue Date is Required';
    }
    else
    {
        $issuedate = $form_data->issuedate;
    }

	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			$data = array(
                ':username'		    =>	$username,
                ':password'		    =>	$password,
				':firstname'		=>	$firstname,
				':lastname'		    =>	$lastname,
                ':classs'		    =>	$classs,
                ':department'		    =>	$department,
                ':booksissued'		    =>	$booksissued,
                ':issuedate'		    =>	$issuedate
			);
			$query = "
			INSERT INTO users 
				(username, password, firstname, lastname, classs, department, booksissued,issuedate) VALUES 
				(:username, :password, :firstname, :lastname, :classs, :department, :booksissued, :issuedate)";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
                ':username'		    =>	$username,
                ':password'		    =>	$password,
				':firstname'	    =>	$firstname,
				':lastname'	        =>	$lastname,
                ':classs'		    =>	$classs,
                ':department'		    =>	$department,
                ':booksissued'		    =>	$booksissued,
                ':issuedate'		    =>	$issuedate,
				':id'			    =>	$form_data->id
			);
			$query = "
			UPDATE users 
			SET username = :username, password = :password, firstname = :firstname, lastname = :lastname, classs = :classs, department = :department, booksissued = :booksissued, issuedate = :issuedate
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Edited';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);

}



echo json_encode($output);

?>
