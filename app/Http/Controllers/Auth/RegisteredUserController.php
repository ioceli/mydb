<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\entidad;
use App\Enums\RolEnum;
use App\Enums\EstadoEnum;
use App\Enums\GeneroEnum;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
              $entidad = entidad::all();
        return view('auth.register',compact('entidad'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
   
{
    $request->validate([
        'idEntidad'=>'nullable|exists:entidad,idEntidad',
        'cedula'=>['required', 'string', 'size:10', 'regex:/^[0-9]+$/', 'unique:users,cedula'],
        'name' => ['required', 'string', 'max:255'],
        'apellidos'=>'required|string',
        'rol'=> ['required', Rule::in(RolEnum::values())],
        'estado'=>['required', Rule::in(EstadoEnum::values())],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'genero'=>['required', Rule::in(GeneroEnum::values())],
        'telefono'=>['required', 'string', 'regex:/^[0-9]+$/', 'min:9', 'max:15'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'cedula' => $request->cedula,
        'name' => $request->name,
        'apellidos' => $request->apellidos,
        'rol' => $request->rol,
        'estado' => $request->estado,
        'email' => $request->email,
        'genero' => $request->genero,
        'telefono' => $request->telefono,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));
    Auth::login($user);

    // Generar y enviar código de doble factor
    $user->generateTwoFactorCode(); 
    Mail::to($user->email)->send(new TwoFactorCodeMail($user));

    // Guardar sesión temporal para MFA
    session()->put('two_factor:' . $user->id, false);

    // Redirigir al formulario de MFA
    return redirect()->route('two-factor.challenge');
}
}
