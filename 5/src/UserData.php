  <?php
class UserData
{
	private $name;
	private $email;
	private $year;
	private $gender;
	private $numlimbs;
	private $superPowers;
	private $biography;

	public function __construct($name, $email, $year, $gender, $numlimbs, $superPowers, $biography)
	{
		$this->name = $name;
		$this->email = $email;
		$this->year = $year;
		$this->gender = $gender;
		$this->numlimbs = $numlimbs;
		$this->superPowers = $superPowers;
		$this->biography = $biography;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getYear()
	{
		return $this->year;
	}
	public function getGender()
	{
		return $this->gender;
	}
	public function getNumlimbs()
	{
		return $this->numlimbs;
	}
	public function getSuperPowers()
	{
		return $this->superPowers;
	}
	public function getBiography()
	{
		return $this->biography;
	}
}
