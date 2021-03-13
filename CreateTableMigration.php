<?php

class CreateTableMigration
{
    /**
     * Creates 'phonebook' table in DB.
     *
     * @return void
     */
	public static function up() {

		$db = DB::connect();
		$platform = $db->getDatabasePlatform();
		$schema = new \Doctrine\DBAL\Schema\Schema();

		$myTable = $schema->createTable('phonebook');
		$myTable->addColumn("id", "integer", array("unsigned" => true, "autoincrement" => true));
		$myTable->addColumn("first_name", "string", array("length" => 32));
		$myTable->addColumn("last_name", "string", array("length" => 32, "notnull" => false));
		$myTable->addColumn("phone_number", "string", array("length" => 24));
		$myTable->addColumn("country_code", "string", array("length" => 24, "notnull" => false));
		$myTable->addColumn("time_zone", "string", array("length" => 24, "notnull" => false));
		$myTable->addColumn("insertedOn", "datetime");
		$myTable->addColumn("updatedOn", "datetime");
		$myTable->setPrimaryKey(array("id"));
		$myTable->addUniqueIndex(array("id"));

		$sql = $schema->toSql($platform);
		$stmt = $db->prepare(current($sql));
		$stmt->execute();
	}

    /**
     * Drops 'phonebook' table in DB.
     *
     * @return void
     */
	public static function down() {

		$sql = "DROP TABLE `phonebook`";
		$db = DB::connect();
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
}