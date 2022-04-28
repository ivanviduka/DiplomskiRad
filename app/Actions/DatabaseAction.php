<?php

namespace App\Actions;


use App\Models\File;
use Illuminate\Http\Request;
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

    public function getSearchOptions(){
        $options[0] = DB::select('SELECT id, subject_name FROM subjects');
        $options[1] = DB::select('SELECT DISTINCT year_of_study FROM subjects ORDER BY year_of_study');
        $options[2] = DB::select('SELECT DISTINCT major_name, major_id FROM subjects');

        return $options;
    }

    public function buildSearchQuery(Request $request)
    {
        $query = File::with('user:id,email', 'subject:id,subject_name')
            ->join('subjects', 'files.subject_id', '=', 'subjects.id')
            ->join('users', 'files.user_id', '=', 'users.id')
            ->select(DB::raw('files.id AS file_id, files.*, subjects.*, users.email'))
            ->where('is_public', 1);

        if (isset($request->user_file_name)) {
            $query->where('user_file_name', 'LIKE', '%' . $request->user_file_name . '%');
        }

        if (isset($request->email)) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if (isset($request->subject_id)) {
            $request->validate([
                'subject_id' => 'exists:subjects,id'
            ]);
            $query->where('subject_id', $request->subject_id);
        }

        if (isset($request->year_of_study)) {
            $request->validate([
                'year_of_study' => 'numeric|in:1,2,3,4,5'
            ]);
            $query->where('year_of_study', $request->year_of_study);
        }

        if (isset($request->major_id)) {
            $request->validate([
                'major_id' => 'exists:subjects,major_id'
            ]);
            $query->where('major_id', $request->major_id);
        }

        return $query;
    }

}
