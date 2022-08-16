<?php namespace Careerist\Providers;

use Careerist\Helpers\Database;
use Alias;

class DatabaseProvider extends Provider {

  public function register() {

    global $wpdb;

    $tables = [
      "areas" => "{$wpdb->prefix}careerist_plugin_areas",
      "categories" => "{$wpdb->prefix}careerist_plugin_categories",
      "jobs" => "{$wpdb->prefix}careerist_plugin_jobs",
      "syncs" => "{$wpdb->prefix}careerist_plugin_syncs",
      "syncs_events" => "{$wpdb->prefix}careerist_plugin_syncs_events",
    ];

    $Database = new Database($wpdb, $tables);

    $this->App->singleton('Database', $Database);
    foreach ( $tables as $alias => $fullname)
    {
      $this->App->singleton("table.{$alias}", $fullname);
    }

    // Register shortcut Alias
    Alias::add('Database', '\Careerist\Facades\Database');
  }

  public function unregister() {

    // unset($this->App['Database']);

  }

}
