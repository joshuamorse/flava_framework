<?php

class user_base
{
	private $id;
	private $name;
	private $location;

  public function __construct($id)
  {
    $this->id = $id;
    $this->set_values($this->fetch_values());
  }

  private function fetch_values()
  {
    $query = mysql_query('SELECT * FROM user WHERE id = '.$this->id);

    return mysql_fetch_assoc($query);
  }

  private function set_values($results)
  {
    foreach($results as $field => $result)
    {
      $this->$field = $result;
    }
  }

	public function get_id()
	{
		return $this->id;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_location()
	{
		return $this->location;
	}

	public function get_clan()
	{
		$query = mysql_query('SELECT * FROM clan WHERE id = '.$this->clan_id);
		return mysql_fetch_assoc($query);
	}

	public function get_comments()
	{
		$query = mysql_query('SELECT * FROM comment WHERE user_id = '.$this->user_id);
		return mysql_fetch_assoc($query);
	}

	public function get_songs()
	{
		$query = mysql_query('SELECT * FROM user t1, song t2, user2song jt WHERE t1.id IS NOT NULL AND tj.user_id = '.$this->user_id.' AND t1.id = tj.user_id AND t2.id = tj.song_id');
		return mysql_fetch_assoc($query);
	}

}
