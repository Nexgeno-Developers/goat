<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Caches query results using CodeIgniter's cache driver with TTL (Time-To-Live).
 *
 * @param string   $key         Cache key name.
 * @param callable $callback    Function that returns the fresh data.
 * @param int      $ttl_seconds Time to live (in seconds), default is 60s.
 * @return mixed                Cached or fresh data.
 */
function cache_with_ttl($key, callable $callback, $ttl_seconds = 300)
{
    $CI =& get_instance();
    $CI->load->driver('cache', ['adapter' => 'file']); // You can change 'file' to 'redis', etc.

    $cached = $CI->cache->get($key);

    if ($cached !== false) {
        return $cached;
    }

    $data = $callback();
    $CI->cache->save($key, $data, $ttl_seconds);

    return $data;
}

function cache_clear($key)
{
    $CI =& get_instance();
    $CI->load->driver('cache', ['adapter' => 'file']);
    return $CI->cache->delete($key);
}

if (!function_exists('clear_all_cache')) {
    function clear_all_cache()
    {
        $CI =& get_instance();

        // Clear database cache (if used)
        $CI->db->cache_delete_all();

        // Clear file-based cache
        $CI->load->driver('cache', ['adapter' => 'file']);
        $CI->cache->clean();

        log_message('info', 'All cache cleared manually.');
        return true;
    }
}

if (!function_exists('duration')) {
    function cache_duration()
    {
        return 60; //15 minutes
    }
}