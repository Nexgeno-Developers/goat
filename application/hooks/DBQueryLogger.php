<?php

class DBQueryLogger
{
    public static function enable_slow_query_log()
    {
        $CI =& get_instance();

        // Wrap CI's query execution
        $CI->db->save_queries = TRUE;

        register_shutdown_function(function () use ($CI) {
            $queries = $CI->db->queries;
            $times   = $CI->db->query_times;

            foreach ($queries as $i => $query) {
                $exec_time = isset($times[$i]) ? $times[$i] : 0;

                if ($exec_time > 0.1) { // Threshold in seconds
                    $controller = $CI->router->fetch_class();
                    $method     = $CI->router->fetch_method();
                    $uri        = $_SERVER['REQUEST_URI'] ?? 'CLI';

                    $log_message = "[SLOW QUERY] " . round($exec_time, 4) . "s | Controller: {$controller}/{$method} | URI: {$uri} | SQL: {$query}";
                    log_message('error', $log_message);
                }
            }
        });
    }
}
