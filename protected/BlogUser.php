<?php
// Include TDbUserManager.php file which defines TDbUser

/**
 * BlogUser Class.
 * BlogUser represents the user data that needs to be kept in session.
 * Default implementation keeps username and role information.
 */
class BlogUser extends TDbUser
{
	public function createUser($username)
	{
		
		$baseMethod = new BaseFunction ();
		
		$userRecord=UserRecord::finder()->findByUsername($baseMethod->cryptString($username));
		if($userRecord instanceof UserRecord) // if found
		{
			$user=new BlogUser($this->Manager);
			$user->Name = $username;
			$user->Roles=($userRecord->Role==1 ? 'admin' : 'user');
			$user->IsGuest=false;
			return $user;
		}
	}

	public function validateUser($username,$password)
	{
		$baseMethod = new BaseFunction ();
		return UserRecord::finder()->findBy_Username_AND_Password( $baseMethod->cryptString ( $username ), $baseMethod->cryptString ( $password ));
	}

	public function getIsAdmin()
	{
		return $this->isInRole('admin');
	}
}
?>