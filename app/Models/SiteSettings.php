<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['site_name', 'admin_name', 'admin_phone'];

    /**
     * Get the singleton settings row, creating it if missing.
     */
    public static function get(): self
    {
        $settings = static::first();

        if (!$settings) {
            $settings = static::create([
                'site_name'   => 'WEIN',
                'admin_name'  => null,
                'admin_phone' => null,
            ]);
        }

        return $settings;
    }
}
