<?php

namespace Flavorgod\Models\Eloquent\traits;

trait CanResetPassword
{
	 /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->payer_email;
    }


}