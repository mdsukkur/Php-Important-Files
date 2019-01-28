<?php
include_once "Database.php";

class Multi_Query
{
    /**
     * All Data From Database
     */
    function index($table)
    {
        $obj = new Database;
        $con = $obj->dbConnect();

        $sql = "SELECT * FROM `$table`";
        $prepared = $con->prepare($sql);
        $prepared->execute();
        $result = $prepared->fetchAll(PDO::FETCH_OBJ);
//        $result = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     * Show One Specefic rows data
     */
    function show($table, $conditon)
    {
        $obj = new Database;
        $con = $obj->dbConnect();

        $count_conkey = count(array_keys($conditon));

        $sql = "SELECT * FROM `$table` WHERE ";

        $j = 0;
        foreach ($conditon as $conName => $conValue) {
            if (($count_conkey - 1) == $j) {
                $sql .= "`{$conName}`=$conValue";
            } else {
                $sql .= "`{$conName}`=$conValue" . ",";
            }
            $j++;
        }

        $prepared = $con->prepare($sql);
        $prepared->execute();
        $result = $prepared->fetchAll(PDO::FETCH_OBJ);
//        $result = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    /**
     * Data Insert Query
     */
    function store($table, $data)
    {
        $obj = new Database;
        $con = $obj->dbConnect();

        $values = array_values($data);
        $keys = array_keys($data);
        $count_key = count($keys);


        $sql = "INSERT INTO `{$table}` (";

        foreach ($keys as $key => $value) {
            if ($key == ($count_key - 1)) {
                $sql .= "`{$value}`";
            } else {
                $sql .= "`{$value}`" . ",";
            }
        }

        $sql .= ") VALUES (";

        foreach ($values as $key => $value) {
            if ($key == ($count_key - 1)) {
                $sql .= "'$value'";
            } else {
                $sql .= "'$value'" . ",";
            }
        }

        $sql .= ")";

        $prepared = $con->prepare($sql);
        $prepared->execute();
    }


    /**
     * Edit Single Data
     */
    function edit($table, $editable_data, $conditon)
    {
        $obj = new Database;
        $con = $obj->dbConnect();

        $count_editablekey = count(array_keys($editable_data));
        $count_conkey = count(array_keys($conditon));

        $sql = "UPDATE `{$table}` SET ";

        $i = 0;
        foreach ($editable_data as $key => $value) {
            if (($count_editablekey - 1) == $i) {
                $sql .= "`{$key}`=" . "'$value'";
            } else {
                $sql .= "`{$key}`=" . "'$value'" . ",";
            }
            $i++;
        }

        $sql .= " WHERE ";

        $j = 0;
        foreach ($conditon as $conName => $conValue) {
            if (($count_conkey - 1) == $j) {
                $sql .= "`{$conName}`=$conValue";
            } else {
                $sql .= "`{$conName}`=$conValue" . ",";
            }
            $j++;
        }
        $prepared = $con->prepare($sql);
        $prepared->execute();
    }


    /**
     * Delete Single Data
     */
    function destroy($table, $conditon)
    {
        $obj = new Database;
        $con = $obj->dbConnect();

        $count_conkey = count(array_keys($conditon));

        $sql = "DELETE FROM `{$table}` WHERE ";

        $j = 0;
        foreach ($conditon as $conName => $conValue) {
            if (($count_conkey - 1) == $j) {
                $sql .= "`{$conName}`=$conValue";
            } else {
                $sql .= "`{$conName}`=$conValue" . ",";
            }
            $j++;
        }

        $prepared = $con->prepare($sql);
        $prepared->execute();
    }

}