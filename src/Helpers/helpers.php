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
     * Generate a valid RFC 4122 universally unique identifier. Supporting
     * version 1, 3, 4 and 5,
     *
     * @param int $version The version of Uuid to generate. Accepts 1-5.
     * @param string $name
     * @return string
     */
    function generate_uuid($version = 1, $name = 'laravel')
    {
        switch($version) {
            case 1:
                return \Ramsey\Uuid\Uuid::uuid1()->toString();
                break;
            case 3:
                return \Ramsey\Uuid\Uuid::uuid3(\Ramsey\Uuid\Uuid::NAMESPACE_DNS, $name)->toString();
                break;
            case 4:
                return \Ramsey\Uuid\Uuid::uuid4()->toString();
                break;
            case 5:
                return \Ramsey\Uuid\Uuid::uuid5(\Ramsey\Uuid\Uuid::NAMESPACE_DNS, $name)->toString();
                break;
            default:
                return \Ramsey\Uuid\Uuid::uuid1()->toString();
                break;
        }
    }
}
if ( ! function_exists('var_d'))
{
    /**
     * var_dump(), but pretty printed like dd().
     *
     * @param  mixed
     * @return void
     */
    function var_d()
    {
        array_map(function($x) { (new Illuminate\Support\Debug\Dumper)->dump($x); }, func_get_args());
    }
}


if ( ! function_exists('database_dump')) {
    /**
     * Dump a backup of the specified db/tables
     *
     * @param string $tables
     * @param null   $path
     * @param null   $db
     * @param null   $dbUser
     * @param null   $dbPass
     * @return null|string
     * @throws \Exception
     */
    function database_dump($tables = '', $path = null, $db = null, $dbUser = null, $dbPass = null, $port = 3306)
    {
        if (empty($db)) {
            $db = env('DB_DATABASE');
        }
        if (empty($dbUser)) {
            $dbUser = env('DB_USERNAME');
        }
        if (empty($dbPass)) {
            $dbPass = env('DB_PASSWORD');
        }
        if (empty($path)) {
            $date = date('Ymd_H-i-s');
            $path = storage_path("backups/$db" . "_$date.sql");
        }
        if (is_array($tables)) {
            $tables = implode(" ", $tables);
        }
        if (empty($dbUser) || empty($dbPass) || empty($db) || empty($path) || empty($date) || empty($port)) {
            throw new \Exception('DB credentials missing. Ensure you either pass correct strings or check .env has correct details');
        }

        $output = null;
        $return = null;
        exec("mysqldump --user=$dbUser --password=$dbPass --port=$port $db $tables > $path", $output, $return);

        if ($return) {
            throw new \Exception('There was an error creating the backup - check the mysql logs');
        }

        return $path;
    }
}
