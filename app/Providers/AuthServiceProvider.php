<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Client;
use App\Models\Booking;
use App\Models\Part;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define abilities for admin role
        Gate::define('manage-users', function (User $user) {
            return $user->role === 'admin';
        });

        // Define abilities for admin and manager roles
        Gate::define('manage-vehicles', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-drivers', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('manage-parts', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        // Define abilities for all authenticated users
        Gate::define('view-vehicles', function (User $user) {
            return true;
        });

        Gate::define('view-drivers', function (User $user) {
            return true;
        });

        Gate::define('view-parts', function (User $user) {
            return true;
        });

        Gate::define('manage-bookings', function (User $user) {
            return true;
        });

        Gate::define('manage-clients', function (User $user) {
            return true;
        });

        // Resource-specific checks
        Gate::define('update-booking-status', function (User $user, Booking $booking) {
            return in_array($user->role, ['admin', 'manager']) || 
                   $booking->driver_id === $user->id;
        });

        Gate::define('adjust-part-stock', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });

        Gate::define('view-low-stock', function (User $user) {
            return in_array($user->role, ['admin', 'manager']);
        });
    }
}
