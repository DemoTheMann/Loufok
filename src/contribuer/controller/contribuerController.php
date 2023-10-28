<?php

namespace Contribuer;

use Engine\Base;

class ContribuerController extends Base
{

    public function ContribuerPage(): void
    {
        $this->console->addDebugInfo($_SESSION['user_id']);
        $this->output->load("contribuer/contribuer");

    }
}
