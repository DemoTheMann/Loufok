<?php

namespace Logout;

use Engine\Base;

class LogoutController extends Base
{

    public function logout(): void
    {
        session_destroy();
        header("Location : /");
    }
}