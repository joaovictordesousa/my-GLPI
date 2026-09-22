<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $this->autorizarAdministrador();

        return view('admin.usuarios', [
            'usuarios' => User::orderBy('name')->paginate(20),
        ]);
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $this->autorizarAdministrador();

        $dados = $request->validate([
            'tipo' => ['required', 'in:usuario,tecnico,administrador'],
            'ativo' => ['required', 'boolean'],
        ]);

        if ($usuario->is(auth()->user()) && ($dados['tipo'] !== 'administrador' || ! $dados['ativo'])) {
            return back()->with('error', 'Você não pode remover seu próprio acesso de administrador nem desativar sua conta.');
        }

        $usuario->update($dados);

        return back()->with('success', 'Acesso do usuário atualizado.');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->autorizarAdministrador();

        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo' => ['required', 'in:usuario,tecnico,administrador'],
            'ativo' => ['required', 'boolean'],
        ]);

        $dados['password'] = Hash::make($dados['password']);
        User::create($dados);

        return back()->with('success', 'Novo usuário criado.');
    }

    private function autorizarAdministrador(): void
    {
        abort_unless(auth()->user()->isAdministrador(), 403);
    }
}
