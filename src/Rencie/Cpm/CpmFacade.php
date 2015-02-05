<?php 

namespace Rencie\Cpm;
use Illuminate\Support\Facades\Facade;


class CpmFacade extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cpm';
    }
}
