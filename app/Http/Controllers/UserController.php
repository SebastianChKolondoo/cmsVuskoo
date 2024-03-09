<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:usuarios.view')->only('index');
        $this->middleware('can:usuarios.view.btn-create')->only('create','store');
        $this->middleware('can:usuarios.view.btn-edit')->only('edit','update');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::paginate(1);
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion =  DB::table('users')->where('numberDocument', '=', $request->numberDocument)->get()->count();
        if ($validacion == 0) {
            $user = User::create([
                'name' => ($request->name),
                'lastname' => ($request->lastname),
                'email' => strtolower($request->email),
                'phone' => $request->phone,
                'numberDocument' => $request->numberDocument,
                'email_verified_at' => now(),
                'password' => bcrypt($request->idNumber),
            ]);
            $user->roles()->sync($request->roles);
            return redirect('/usuarios')->with('info', 'El registro de ' . $request->name . ' ' . $request->lastname . ' ha sido creado.');
        } else {
            return redirect('/usuarios')->with('info', '' . $request->name . ' ' . $request->lastname . ' ya se encuentra registrado.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        $user = User::find($user);
        $roles = Role::all();
        return view('usuarios.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);
        $user->update($request->all());
        $user->roles()->sync($request->roles);
        return redirect('/usuarios')->with('info', 'El registro de ' . $request->name . ' ' . $request->lastname . ' ha sido actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
