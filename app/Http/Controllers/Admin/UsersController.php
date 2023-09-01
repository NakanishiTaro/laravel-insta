<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        // 
        // $all_users = $this->user->latest()->paginate(5);
        $all_users = $this->user->withTrashed()->latest()->paginate(5);

        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function deactivate($id)
    {
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id)
    {
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    private function search(Request $request)
    {
        $request->validate([
            'search' => 'regex:/^[0-9a-zA-Z.@]+$/'
        ],
        [
            'search'.'.regex' => 'Accepts numbers, alphabets, "." or "@" only'
        ]);

        $users = $this->user->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->withTrashed()->latest()->get();
        return $users;
    }

    public function searchResults(Request $request)
    {
        $users = $this->search($request);

        return view('admin.users.search')->with('users', $users)->with('search', $request->search);
    }
}
