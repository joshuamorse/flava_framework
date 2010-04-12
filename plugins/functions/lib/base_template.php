<?php

class %table_base%
{
////declare_vars
  public function __construct($id)
  {
    $this->id = $id;
    $this->set_values($this->fetch_values());
  }

  private function fetch_values()
  {
    $query = mysql_query('SELECT * FROM %table% WHERE id = '.$this->id);

    return mysql_fetch_assoc($query);
  }

  private function set_values($results)
  {
    foreach($results as $field => $result)
    {
      $this->$field = $result;
    }
  }
////get_methods
////one_to_one_methods
////one_to_many_methods
////many_to_many_methods
}
