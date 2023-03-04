<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
	 * Returns a random string of the type and length specified
	 *
	 * @param  integer $length  The length of string to return
	 * @param  string  $type    The type of string to return: `'base64'`, `'base56'`, `'base36'`, `'alphanumeric'`, `'alpha'`, `'numeric'`, or `'hexadecimal'`, if a different string is provided, it will be used for the alphabet
	 * @return string  A random string of the type and length specified
	 */
	static public function randomString($length, $type='alphanumeric')
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

		$alphabet_length = strlen($alphabet);
		$output = '';

		for ($i = 0; $i < $length; $i++) {
			$output .= $alphabet[self::random(0, $alphabet_length-1)];
		}
		return $output;
	}
    /**
	 * Performs a large iteration of hashing a string with a salt
	 *
	 * @param  string $source  The string to hash
	 * @param  string $salt    The salt for the hash
	 * @return string  An 80 character string of the Flourish fingerprint, salt and hashed password
	 */
	static private function hashWithSalt($source, $salt)
	{
		$sha1 = sha1($salt . $source);
		for ($i = 0; $i < 1000; $i++) {
			$sha1 = sha1($sha1 . (($i % 2 == 0) ? $source : $salt));
		}

		return 'fCryptography::password_hash#' . $salt . '#' . $sha1;
	}
    /**
	 * Generates a random number using [http://php.net/mt_rand mt_rand()] after ensuring a good PRNG seed
	 *
	 * @param  integer $min  The minimum number to return
	 * @param  integer $max  The maximum number to return
	 * @return integer  The psuedo-random number
	 */
	static public function random($min=NULL, $max=NULL)
	{
		if ($min !== NULL || $max !== NULL) {
			return mt_rand($min, $max);
		}
		return mt_rand();
	}
    /**
	 * Checks a password against a hash created with ::hashPassword()
	 *
	 * @param  string $password  The password to check
	 * @param  string $hash      The hash to check against
	 * @return boolean  If the password matches the hash
	 */
	static public function checkPasswordHash($password, $hash)
	{
		$salt = substr($hash, 29, 10);

		if (self::hashWithSalt($password, $salt) == $hash) {
			return TRUE;
		}

		return FALSE;
	}
   
}
