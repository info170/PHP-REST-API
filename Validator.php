<?php

class Validator
{
	private $errors;
	private $country_codes;
	private $time_zones;

	public function __construct() {

		try {
			$this->country_codes = (array)$this->loadCountryCodes();
		}
		catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        try {
			$this->time_zones = (array)$this->loadTimeZones();
		}
		catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }
	}

    /**
     * Validates data with the rule "required".
     *
     * @param  array  $input
     * @return void
     */
	public function validate_required($input) {

		if (empty($input->first_name)) {
			$this->errors[] = "First name required!";
		}

		if (empty($input->phone_number)) {
			$this->errors[] = "Phone number required!";
		}
	}

    /**
     * Validates data with the other rules.
     *
     * @param  array  $input
     * @return void
     */
	public function validate_rules($input) {

		if (!preg_match("/^\+\d+\s\d{3}\s\d{9}$/",$input->phone_number)) {
			$this->errors[] = "Phone number format +XX XXX XXXXXXXXX required!";
		}

		if (!empty($input->country_code) and !isset($this->country_codes[$input->country_code])) {
			$this->errors[] = "Invalid country code format!";
		}

		if (!empty($input->time_zone) and !isset($this->time_zones[$input->time_zone])) {
			$this->errors[] = "Invalid timezone!";
		}

	}

    /**
     * Load country codes from remote endpoind.
     *
     * @return array
     *
     * @throws Exception
     */
	protected function loadCountryCodes() {

		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', 'https://api.hostaway.com/countries');

		if ($response->getStatusCode() != 200) {
			throw new Exception('Country codes resourse not acessible.');
		}

		$rez = json_decode($response->getBody());

		if ($rez->status == "success") {

			return $rez->result;

		} else throw new Exception('Country codes resourse answer not success.');
	}

    /**
     * Load timezones from remote endpoind.
     *
     * @return array
     *
     * @throws Exception
     */
	protected function loadTimeZones() {

		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', 'https://api.hostaway.com/timezones');

		if ($response->getStatusCode() != 200) {
			throw new Exception('Timezones resourse not acessible.');
		}

		$rez = json_decode($response->getBody());

		if ($rez->status == "success") {

			return $rez->result;

		} else throw new Exception('Timezones resourse answer not success.');
	}

    /**
     * Return result of validation.
     *
     * @return boolean
     */
	public function fails() {

		if ($this->errors) return true;

		return false;
	}

    /**
     * Return validation errors.
     *
     * @return array
     */
	public function errors() {

		return $this->errors;
	}


}