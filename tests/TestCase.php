<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        Artisan::call('migrate');

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        return $app;
    }

    /**
     * @param \App\Models\User|string $role
     * @return $this
     */
    public function actAs($role)
    {
        if (is_string($role)) {
            if ($role == 'normal') {
                $role = factory(\App\Models\User::class)->create();
            } else {
                $role = factory(\App\Models\User::class, $role)->create();
            }
        }
        return $this->withSession(['uid' => $role->uid, 'token' => $role->getToken()]);
    }
}