<?php

namespace App\Http\Controllers;


use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('users.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function news(Request $request)
    {
        $this->validate($request, [
            'name' => 'required:string|max:255',
            'lname' => 'required:string|max:255',
            'email' => 'required:string|email|max:255|unique:users',
            'password' => 'required:string|min:6|confirmed'
        ]);


        $email_verified_at = new DateTime('now');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'lname' => $request->lname,
            'email_verified_at' => $email_verified_at
        ]);

        Log::debug('Se creo usuario:'. $request->name ." Apellido: ". $request->lname );

        return redirect('users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return view('users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required:string|max:255',
            'lname' => 'required:string|max:255',
            'email' => 'required:string|email|max:255'
        ]);


        User::where('id', $request->id)
            ->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'lname' => $request->lname,
        ]);

        Log::debug('Se modifico usuario:'. $request->name ." Apellido: ". $request->lname );

        return redirect('users');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        return view('users.delete', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();
        Log::debug('Se elimino usuario:'. $request->name ." Apellido: ". $request->lname );
        return redirect('users');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function change()
    {
        $user = User::find(Auth::user()->id);
        return view('users.change', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function password(Request $request)
    {
        $this->validate($request, [
            'password' => 'required:string|min:6|confirmed'
        ]);

        User::where('id', Auth::user()->id)
            ->update(['password' => Hash::make($request->password)]);
        Log::debug('Se cambio password de usuario con Nombre:'. Auth::user()->name ." Apellido: ". Auth::user()->lname );
        return redirect('users');
    }

}
