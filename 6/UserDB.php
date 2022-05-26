<?php
class UserDB
{
	private $serverName;
	private $user;
	private $password;
	private $dbName;

	public function __construct(string $servername, string $user, string $password, string $dbname)
	{
		$this->serverName = $servername;
		$this->user = $user;
		$this->password = $password;
		$this->dbName = $dbname;
	}

	public function getServerName(): string
	{
		return $this->serverName;
	}
	public function getUser(): string
	{
		return $this->user;
	}
	public function getPassword(): string
	{
		return $this->password;
	}
	public function getDBName(): string
	{
		return $this->dbName;
	}
}