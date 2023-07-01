<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StatusController extends Controller
{
    /**
     * Create handler
     * @param Request $request status data
     * @return Redirect
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $status = new Status();
        $status->name = $request->name;
        $status->save();
        return redirect("/user");
    }

    /**
     * Update handler
     * @param User $user user
     * @param Status $status status, detach user logic
     * @param Request $request status data
     * @return Redirect
     */
    public function set(User $user, Request $request)
    {
        $status = Status::findOrFail($request->statusId);
        $user->statuses()->attach($status);
        return redirect("/user");
    }

    public function delete(User $user, Status $status)
    {
        $user->statuses()->detach($status);
        return redirect("/user");
    }

    /**
     * Delete handler
     * @param int $statusId id status
     * @return Redirect
     */
    public function deletestatus(Status $status)
    {
        $status->delete();
        return redirect("/user");
    }
}
