<?php
/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 04/05/17
 * Time: 18:36
 */
class Database extends PDO{
    /**
     * Database constructor.
     * @param $host
     * @param $user
     * @param $pass
     * @param $database
     */
    public function __construct($host, $user, $pass, $database){
        $dsn = "mysql:host={$host};dbname={$database};charset=utf8";
        parent::__construct($dsn, $user, $pass);
    }

    /**
     * DB Prepare and Execute Query
     * @param $stmt
     * @param $params
     * @return PDOStatement
     */
    public function pquery($stmt, ...$params){
        $stmt = $this->prepare($stmt);

        if(func_num_args() == 2 && is_array(func_get_arg(1))){
            $params = func_get_arg(1);
        }

        $params = array_values($params);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * Generic insert
     * @param $table
     * @param $fields
     * @param $values
     * @return string
     */
    public function insert($table, $fields, ...$values){
        $values = (array) $values;
        $fields = "`".join("`,`", (array) $fields)."`";
        $sql = "INSERT INTO `{$table}` ({$fields}) VALUES";

        function maskVals($vals){
            $sql = '';
            for($i = 0; $i < sizeof($vals); $i++) $sql .= $i == 0 ? "?" : ",?";
            return '('.$sql.')';
        }

        // Mount SQL
        if(is_array($values)){
            foreach ($values as $index => $item){
                $i_vals = maskVals($item);

                $sql .= $index == 0 ? $i_vals : ','.$i_vals;
            }
        }

        $values = call_user_func_array('array_merge', $values);
        $values = array_values($values);

        return $this->pquery($sql, $values);
    }
}