<?php

namespace Fos\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FosMainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
