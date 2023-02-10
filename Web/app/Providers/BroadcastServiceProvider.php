<?php
/**
 * Broadcast service provider for Web & Api
 *
 * @name       BroadcastServiceProvider
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
namespace Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Broadcast::routes ();
        Broadcast::channel ( 'App.User.*', function ($user, $userId) {
            return ( int ) $user->id === ( int ) $userId;
        } );
    }
}
