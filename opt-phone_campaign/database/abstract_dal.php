<?php


class abstract_dal
{
    var $db;
    var $log;

    var $fields;
    var $table;
    var $keys;

    function __construct()
    {

        global $config;
        $this->db = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'], $config['db_password']);

        $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $this->log = new KLogger ('database.log' , KLogger::ERROR );


        //$this->log = new KLogger ('/tmp/new_database.log' , KLogger::OFF );

        
        

    }


    function exclute_non_query($sql, $data, $keys=null)
    {
        try
        {
            $statement = $this->db->prepare($sql);
            $statement->execute($data);

            $this->log->LogDebug('exclute_non_query $sql: ' . $sql);
            $this->log->LogDebug('exclute_non_query $data: ' . print_r($data, true));

            return $this->db->lastInsertId();
        }
        catch(PDOException $e)
        {
			$this->log->LogError("sql: $sql");
            $this->log->LogError("Database base error: " . $e->getMessage());
        }
        return null;
    }


    function get_server_date()
    {
        $ret = $this->get_one('select now() as now');
        return $ret->now;
    }

    function get($sql=null)
    {

        if(is_null($sql))
            $sql = $this->codegen_select_statement();

        $this->log->LogDebug('$sql: ' . $sql);

        return $this->get_objects_array($sql);
    }


    function get_one($sql=null)
    {
        if(is_null($sql))
            $sql = $this->codegen_select_statement();

        $this->log->LogDebug('get_one(): $sql: ' . $sql);

        $result = $this->get_objects_array($sql);

        $this->log->LogDebug('get_one(): $result: ' . print_r($result, true));

		if(stripos($sql, 'count(*)')){
			$this->log->LogError('-->get_one(): $result: ' . print_r($result, true));
			$this->log->LogError("--->sql: $sql");
		}

        if(!empty($result)){
            return $result[0];
        }

        return null;

    }


    protected function get_objects_array($sql)
    {
        $statement = $this->db->query($sql);
        $result = $statement->setFetchMode(PDO::FETCH_OBJ);
        $results = array();
        while($obj = $statement->fetch())
        {
            $results[] = $obj;
        }
        return $results;
    }




    function codegen_select_statement()
    {

        $fields = '';
        foreach(explode(', ', $this->fields) as $field)
        {
            if(strlen($fields) > 0) $fields .= ', ';
            $fields .= $field;
        }
        return "select $fields from $this->table";
    }


    function codegen_insert_statement()
    {

        $fields = ''; $values = '';
        foreach(array_diff(explode(', ', $this->fields),
                           explode(', ', $this->keys)) as $field)
        {
            if(strlen($fields) > 0) $fields .= ', ';
            $fields .= $field;

            if(strlen($values) > 0) $values .= ', ';
            $values .= ":$field";

        }
        return "insert into $this->table ($fields) values ($values)";        
    }


    function codegen_update_statement()
    {

        $fields = '';
        foreach(array_diff(explode(', ', $this->fields),
                           explode(', ', $this->keys)) as $field)
        {
            if(strlen($fields) > 0) $fields .= ', ';
            $fields .= "$field = :$field\n";
        }

        $keys = '';
        foreach(explode(', ', $this->keys) as $key)
        {
            if(strlen($keys) > 0) $keys .= ', ';
            $keys .= "$key = :$key";
        }

        return "update $this->table \n  set $fields where $keys";

    }

    function codegen_delete_statement()
    {

        $keys = '';
        foreach(explode(', ', $this->keys) as $key)
        {
            if(strlen($keys) > 0) $keys .= ', ';
            $keys .= "$key = :$key\n";
        }

        return "delete from $this->table where $keys";

    }

    function codegen_field_array()
    {
        $fields = '';
        foreach(explode(', ', $this->fields) as $field)
        {
            if(strlen($fields) > 0) $fields .= ",\n ";
            $fields .= "\t'$field' => \$$field ";
        }
        return "\$data = array(\n$fields\n);";
        
    }

    function codegen_field_list($prefix=null)
    {
        $fields = '';
        foreach(explode(', ', $this->fields) as $field)
        {
            if(strlen($fields) > 0) $fields .= ", ";
            $fields .= $prefix . $field;
        }
        return "$fields";

    }


}

