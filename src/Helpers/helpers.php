<?php 

if (! function_exists('versioned_asset')) {
    /**
     * Returns file with version query string on the end that updates every modification
     *
     * @param $file
     * @return string
     */
	function versioned_asset($file)
	{
		if ( file_exists(public_path($file)) ) {
			return asset($file) . '?v=' . filemtime(public_path($file));
		}
		
		return asset($file);
	}
}



if (! function_exists('concat')) {
    /**
     * Concatenate strings together
     *
     * @return string
     */
    function concat()
    {
        $args = func_get_args();

        if (! empty($args)) {
            foreach($args as $key=>$arg) {
                if (is_object($args) || is_array($arg)) {
                    unset($args[$key]);
                }
            }
        }

        return implode(' ', $args);
    }
}

if (! function_exists('concat_ws')) {
    /**
     * Concatenate strings with specified separator as first argument
     *
     * @return string
     */
    function concat_ws()
    {
        $args = func_get_args();

        $separator = (isset($args[0])) ? $args[0] : ' ';
        unset($args[0]);

        if (! empty($args)) {
            foreach($args as $key=>$arg) {
                if (is_object($args) || is_array($arg)) {
                    unset($args[$key]);
                }
            }
        }

        return implode($separator, $args);
    }
}

if (! function_exists('generate_uuid')) {
    /**
     * Generate a valid RFC 4122 universally unique identifier.
     *
     * @param int $version The version of Uuid to generate. Accepts 1-5.
     * @return string
     */
    function generate_uuid($version = 1)
    {
        switch($version) {
            case 1:
                return \Ramsey\Uuid\Uuid::uuid1()->toString();
                break;
            case 2:
                return \Ramsey\Uuid\Uuid::uuid2()->toString();
                break;
            case 3:
                return \Ramsey\Uuid\Uuid::uuid3()->toString();
                break;
            case 4:
                return \Ramsey\Uuid\Uuid::uuid4()->toString();
                break;
            case 5:
                return \Ramsey\Uuid\Uuid::uuid5()->toString();
                break;
        }
    }
}