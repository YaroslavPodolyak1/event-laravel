<?php

	namespace App\Http\Controllers\Auth;

	use App\User;
	use App\Http\Controllers\Controller;
	use Illuminate\Auth\Events\Registered;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Foundation\Auth\RegistersUsers;

	class RegisterController extends Controller
	{


		use RegistersUsers;


		protected function validator(array $data)
		{
			return Validator::make($data, [
				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users',
				'password' => 'required|string|min:6|confirmed',
			]);
		}

		public function register(Request $request)
		{
			$this->validator($request->all())->validate();
			event(new Registered($user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
			])));
			$request->session()->flash('message', 'На ваш адрес было выслано письмо с подтверждением регистрации.');
			return back();
		}

		public function verification(Request $request, $token)
		{

			User::whereToken($token)->firstOrFail()->confirmEmail();
			$request->session()->flash('message', 'Учетная запись подтверждена. Войдите под своим именем.');
			return redirect('login');
		}
	}
