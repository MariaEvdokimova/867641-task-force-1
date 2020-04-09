<?php
declare(strict_types=1);

namespace TaskForce\db;

use \Exception;
use SplFileObject;
use Throwable;

class LoadData
{
    /**
     * Columns from table
     * @var String
     */
    public $columns;
    /**
     * Table name
     * @var String
     */
    public $table;
    /**
     * File name
     * @var String
     */
    public $csv_file;

    public function __construct(string $csv_file, string $table, string $columns) {
        if (!file_exists($csv_file)) {
            throw new Exception("Файл {$csv_file} не найден");
        }
        $this->csv_file = $csv_file;
        $this->table = $table;
        $this->columns = $columns;
    }

    /**
     * Insert data from CSV to table in db MySQL
     */
    public function insertData() :void
    {
       $mysqli = new Connection();
        $mysqli = $mysqli->getConnection();

        $file = new SplFileObject($this->csv_file);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY);
        $file->seek(0);

        while (!$file->eof()) {
            $dataCSV = $file->fgetcsv();

            $insertValues = [];

            foreach( $dataCSV as $value ) {
                $insertValues[] = "'" . addslashes(trim($value)) . "'";
            }

            $values = implode(',',$insertValues);
            $query = "INSERT INTO $this->table ( $this->columns ) VALUES ( $values )";
            $mysqli->query($query, MYSQLI_USE_RESULT);
        }
    }
}
