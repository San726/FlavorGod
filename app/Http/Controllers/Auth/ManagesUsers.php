<?php 

namespace Flavorgod\Http\Controllers\Auth;

trait ManagesUsers
{

	/**
     * Determine which domain the user is interacting from
     * @param string $path
     * @return string
     */
    protected function fromDomain($path)
    {
        $re = '/^(((http|https):)?\\/\\/)?((([a-z0-9][a-z0-9\\-]*[a-z0-9])\\.)?(([a-z0-9][a-z0-9\\-]*[a-z0-9])\\.([a-z]{2,}\\.)*([a-z]{2,})))(\\/.*)?$/i';
        if (preg_match($re, $path, $m)) {
            if(empty($m[6])){
                return $m[1].$m[7]; 
            }else{
                return $m[1].$m[6].'.'.$m[7];
            }
        } 
    }

    /**
     * Create a custom token
     * @param string $sting
     */
    public function createToken($string)
    {
        return sha1(time() . $string);
    }

}