
[![Build Status](https://travis-ci.org/kisscool-fr/simple-haveibeenpwned.svg?branch=master)](https://travis-ci.org/kisscool-fr/simple-haveibeenpwned)

# SimpleHIBP

SimpleHIBP is a very simple way to check your password safety against Troy Hunt's [Have I Been Pwned](https://haveibeenpwned.com/API/v2#SearchingPwnedPasswordsByRange) range password API.

## Usage

As the idea of this is to ***keep it simple***, you'll just need to call `isPasswordSafe()` static method, passing it the password you want to test as the only argument, and get a boolean value as the return:
 - `true` if the submited password hasn't been seen in a leak
 - `false` if has been seen

## Example
    use HIBP\SimpleHIBP;
    
    $password = "someth1ng";
    if (SimpleHIBP::isPasswordSafe($password)) {
      echo "My password is safe :)";
    } else {
      echo "My password is unsafe :(";
    }

## Security

 - It's obvious, but your data (password, hashed password) are never stored
 - So, there is no cache at all (see [Limitation](#Limitation))

## Limitation

To ***keep it simple***, there is no caching at all. If you plan to integrate it on a high loaded website, please add some form of caching. Something like that should do the job (for security reason, I highly recommend you not to use the password as a data for the cache key):

    use HIBP\SimpleHIBP;
    
    $password = "someth1ng";
    $key = "someUniqueUserData";
    if (false === ($result = $cache->get($key))) {
      $result = SimpleHIBP::isPasswordSafe($password);
      $cache->set($key, $result);
    }


## Credits

Big thanks to [Troy Hunt](https://www.troyhunt.com/) for his amazing work on [Have I Been Pwned](https://haveibeenpwned.com).
