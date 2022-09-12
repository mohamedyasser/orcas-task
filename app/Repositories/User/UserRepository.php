<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @param int $page
     * @return array
     */
    public function list(int $page = 1): array
    {
        $pagination = $this->paginate($page);

        return DB::select("SELECT * FROM users LIMIT {$pagination['offset']}, {$pagination['per_page']}");
    }

    /**
     * @param array $data
     * @param int $page
     * @return array
     */
    public function search(array $data = [], int $page = 1): array
    {
        $pagination = $this->paginate($page);
        $stm = "SELECT * FROM users ";

        $stm = $this->sqlFilters($stm, $data);

        $stm .= " LIMIT {$pagination['offset']}, {$pagination['per_page']}";

        return DB::select($stm);
    }

    /**
     * @param string $stm
     * @param array $data
     * @return string
     */
    private function sqlFilters(string $stm, array $data): string
    {
        if (isset($data['first_name']) || isset($data['last_name']) || isset($data['email'])) {
            $stm .= " WHERE 1!=1 ";
        }

        if (isset($data['first_name']) && !empty($data['first_name'])) {
            $stm .= "OR first_name LIKE '%{$data['first_name']}%' ";
        }

        if (isset($data['last_name']) && !empty($data['last_name'])) {
            $stm .= "OR last_name LIKE '%{$data['last_name']}%' ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $stm .= "OR email LIKE '%{$data['email']}%'";
        }

        return $stm;
    }


    /**
     * @param int $page
     * @return array
     */
    private function paginate(int $page = 1): array
    {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        return [
            'offset' => $offset,
            'per_page' => $perPage,
        ];
    }

    /**
     * Create new user
     *
     * @param array $user
     */
    public function createUser(array $user): void
    {
        DB::statement('insert into users (email, first_name, last_name, avatar) values (?, ?,?,?)', [
            $user['email'],
            $user['first_name'],
            $user['last_name'],
            $user['avatar']
        ]);
    }

    /**
     * Update user
     *
     * @param array $user
     */
    public function updateUser(array $user): void
    {
        DB::update('UPDATE users SET first_name = ?, last_name = ?, avatar = ? WHERE email = ?', [
            $user['first_name'],
            $user['last_name'],
            $user['avatar'],
            $user['email'],
        ]);
    }

    /**
     * Check if user exists
     *
     * @param string $email
     * @return bool
     */
    public function checkUserByEmail(string $email): bool
    {
        return DB::select('select * from users where email = ?', [$email]) ? true : false;
    }
}
