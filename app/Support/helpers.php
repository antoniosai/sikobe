<?php

if (! function_exists('setObjectOption')) {
    /**
     * Set Option object owner.
     *
     * @param  string  $type
     * @param  string  $id
     * 
     * @return void
     */
    function setObjectOption($type, $id)
    {
        \Option::setObject($type, $id);
    }
}

if (! function_exists('option')) {
    /**
     * Get a option.
     *
     * @param  string  $handle
     * 
     * @return string
     * @throws \App\Modules\Option\RecordNotFoundException
     */
    function option($handle)
    {
        return \Option::get($handle);
    }
}

if (! function_exists('setOption')) {
    /**
     * Set a option.
     *
     * @param  string  $handle
     * @param  string  $value
     * 
     * @return void
     */
    function setOption($handle, $value)
    {
        return \Option::set($handle, $value);
    }
}
