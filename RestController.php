<?php

class RestController
{
    /**
     * Display a listing of the resource
     * or the specified resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function index(Request $request)
    {
    	$db = DB::connect();
        $input = $request->input();
        $id = (isset($request->urls()[1])) ? $request->urls()[1] : null;

        if (empty($input['search'])) {

        	if (isset($id)) {
				$sql = "SELECT * FROM phonebook WHERE id = ?";
				$stmt = $db->prepare($sql);
				$stmt->bindValue(1, $id);
				$stmt->execute();
				$data = $stmt->fetchAssociative();
        	}
        	else {
				$sql = "SELECT * FROM phonebook";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$data = $stmt->fetchAll();
			}

        }

        elseif (isset($input['search'])) {

			$sql = "SELECT * FROM phonebook WHERE first_name LIKE '%".$input['search']."%' OR last_name LIKE '%".$input['search']."%'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$data = $stmt->fetchAll();
        }

		if ($data) {
			return Response::send(TRUE, 'Recods retrieved successfully', $data);
		} else {
			return Response::send(FALSE, 'No data');
		}
    }

    /**
     * Store record in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function store(Request $request)
    {
    	$db = DB::connect();
        $input = $request->input();

        $validator = new Validator();
        $validator->validate_required($input);
        $validator->validate_rules($input);

        if ($validator->fails()) {
            return Response::send(FALSE, 'Validation Error', $validator->errors());
        }

        $datetime = date('Y-m-d H:i:s');
		$sql = "INSERT INTO phonebook (first_name,last_name,phone_number,country_code,time_zone,insertedOn,updatedOn)
				VALUES ('".$input->first_name."','".$input->last_name."','".$input->phone_number."','".$input->country_code."','".$input->time_zone."','".$datetime."','".$datetime."')";
		$result = $db->executeStatement($sql);

		if ($result) {
			return Response::send(TRUE, 'Record was added successfully');
		} else {
			return Response::send(FALSE, 'Record not added');
		}
    }

    /**
     * Update all fields in the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function fullupdate(Request $request)
    {
    	$db = DB::connect();
        $id = (isset($request->urls()[1])) ? $request->urls()[1] : null;
        $input = $request->input();

        $validator = new Validator();
        $validator->validate_required($input);
        $validator->validate_rules($input);

        if ($validator->fails()) {
            return Response::send(FALSE, 'Validation Error', $validator->errors());
        }

        $datetime = date('Y-m-d H:i:s');
		$sql = "UPDATE phonebook SET first_name='".$input->first_name."', last_name='".$input->last_name."', phone_number='".$input->phone_number."', country_code='".$input->country_code."', time_zone='".$input->time_zone."',updatedOn='".$datetime."' WHERE id='".$id."'";
		$result = $db->executeStatement($sql);

		if ($result) {
			return Response::send(TRUE, 'Record was updated successfully');
		} else {
			return Response::send(FALSE, 'Record not updated');
		}
    }

    /**
     * Update some fields in the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function update(Request $request)
    {
    	$db = DB::connect();
        $id = (isset($request->urls()[1])) ? $request->urls()[1] : null;
        $input = $request->input();

        $validator = new Validator();
        $validator->validate_rules($input);

        if ($validator->fails()) {
            return Response::send(FALSE, 'Validation Error', $validator->errors());
        }

        $arr = array();
        foreach ((array)$input as $key=>$field) {
        	$arr[] = "$key='$field'";
        }
        $datetime = date('Y-m-d H:i:s');
        $arr[] = "updatedOn='".$datetime."'";
		$sql = "UPDATE phonebook SET ".implode(',',$arr)." WHERE id='".$id."'";
		$result = $db->executeStatement($sql);

		if ($result) {
			return Response::send(TRUE, 'Record was updated successfully');
		} else {
			return Response::send(FALSE, 'Record not updated');
		}
    }

    /**
     * Remove the specified record.
     *
     * @param  Request  $request
     * @return Response
     */
    public static function destroy(Request $request)
    {
    	$db = DB::connect();
        $id = (isset($request->urls()[1])) ? $request->urls()[1] : null;

		$result = $db->executeStatement('DELETE FROM phonebook WHERE id = ?', array($id));

		if ($result) {
			return Response::send(TRUE, 'Recod deleted successfully');
		} else {
			return Response::send(FALSE, 'Record not found');
		}


    }
}
