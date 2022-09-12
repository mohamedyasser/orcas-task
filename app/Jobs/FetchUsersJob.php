<?php

namespace App\Jobs;

use App\Repositories\User\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private UserRepository $userRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (config('services.users') as $key => $service) {
            $response = Http::get($service['url']);
            if ($response->failed()) {
                continue;
            }
            foreach ($response->json() as $object) {
                $user = $this->formatUser($object, $service['schema']);
                $this->userRepository->checkUserByEmail($user['email']) ? $this->userRepository->updateUser($user) : $this->userRepository->createUser($user);
            }
        }
    }

    /**
     * Format user from api to match database schema
     *
     * @param array $user
     * @param array $schema
     * @return array
     */
    private function formatUser(array $user, array $schema): array
    {
        foreach ($schema as $newKey => $oldKey) {
            $user = $this->replaceArrayKey($user, $oldKey, $newKey);
        }
        return $user;
    }

    /**
     * Replace array key with db schema key
     *
     * @param array $array
     * @param $oldKey
     * @param $newKey
     * @return array
     */
    private function replaceArrayKey(array $array, $oldKey, $newKey): array
    {
        //If the old key doesn't exist, we can't replace it...
        if (!isset($array[$oldKey])) {
            return $array;
        }
        //Get a list of all keys in the array.
        $arrayKeys = array_keys($array);
        //Replace the key in our $arrayKeys array.
        $oldKeyIndex = array_search($oldKey, $arrayKeys);
        $arrayKeys[$oldKeyIndex] = $newKey;
        //Combine them back into one array.
        return array_combine($arrayKeys, $array);
    }
}
