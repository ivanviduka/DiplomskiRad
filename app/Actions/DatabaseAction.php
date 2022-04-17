<?php

namespace App\Actions;


use Illuminate\Support\Facades\DB;

class DatabaseAction
{

    public function adminStatistics()
    {
        $statisticInfo = DB::select('SELECT COUNT(DISTINCT users.id) AS users, (SELECT COUNT(files.id) FROM files WHERE
                                    files.is_public = 1) AS public_files, (SELECT COUNT(files.id) FROM files WHERE files.is_public = 0) AS private_files
                                    FROM users, files');

        return $statisticInfo[0];
    }

}
