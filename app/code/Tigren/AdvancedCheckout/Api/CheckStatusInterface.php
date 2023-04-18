<?php

namespace Tigren\AdvancedCheckout\Api;

interface CheckStatusInterface
{
    /**
     * @param bool $request
     * @return mixed
     */
    public function execute(bool $request);

}
