<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassword;
use App\Mail\VerifyMail as MailVerifyMail;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\verifyMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['verifyEmailCode', 'resetPassword', 'forgetPasswordCode', 'forgetPassword', 'login', 'registerAdmin', 'registerProvider', 'registerCustomer']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (auth('api')->user()->enabled == 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $this->createNewToken($token);
    }
    public function verifEmail(Request $request)
    {
    }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {

            //create verification random code
            $verification_code = sprintf("%06d", mt_rand(1, 999999));

            //create new code
            $code = Code::create(array_merge(['code' => $verification_code], ['user_id' => $user->id], ['expire_at' => Carbon::now()->addHour() /* expires in 1h */]));

            Mail::to($user->email)->send(new ForgetPassword($code));

            return response()->json([
                'message' => 'OTP sent to your email.'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Can not find a user with the provided email'
            ], 404);
        }
    }
    public function forgetPasswordCode(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $code = Code::with('user')->where('code', '=', $request->code)->first();

        if ($code) {
            if ($code->expire_at < now()) {
                $code->delete();
                return response()->json(['message' => 'Invalid OTP1'], 403);
            } else {
                if ($code->user->email == $request->email) {
                    return response()->json(['message' => 'Valid'], 200);
                } else {
                    return response()->json(['message' => 'unauthorized'], 403);
                }
            }
        } else {
            return response()->json(['message' => 'Invalid OTP2'], 403);
        }
    }

    public function resetPassword(request $request)
    {
        $validator = Validator::make($request->all(), [
            'newPassword' => 'required',
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            $user->update(['password' => bcrypt($request->newPassword)]);

            return response()->json([
                'message' => 'Password successfully Updated',
                'user' => $user
            ], 201);
        } else {
            return response()->json([
                'message' => 'can not find a user with the provided email'
            ], 404);
        }
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $input = $request->all();

        if ($picture = $request->file('picture')) {
            $destinationPath = 'gallery_users/';
            $imageName = date('ymdhis') . "." . $picture->getClientOriginalExtension();
            $picture->move($destinationPath, $imageName);
            $input['picture'] = $imageName;
        }

        $user = User::create(array_merge(
            $request->all(),
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['role' => 2],
            ['picture' => $imageName]
        ));
        //create verification random code
        $verification_code = sprintf("%04d", mt_rand(1, 9999));

        $verifymail = verifyMail::create(array_merge(['user_id' => $user->id], ['token' => $verification_code], ['expire_at' => Carbon::now()->addHour()]));


        Mail::to($user->email)->send(new MailVerifyMail($verifymail, $user));


        return response()->json([
            'message' => 'Customer successfully registered, verify your email please.',
            'user' => $user
        ], 201);
    }

    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $input = $request->all();

        if ($picture = $request->file('picture')) {
            $destinationPath = 'gallery_users/';
            $imageName = date('ymdhis') . "." . $picture->getClientOriginalExtension();
            $picture->move($destinationPath, $imageName);
            $input['picture'] = $imageName;
        }
        $user = User::create(array_merge(
            $request->all(),
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['role' => 1],
            ['picture' => $imageName]
        ));
        return response()->json([
            'message' => 'Admin successfully registered',
            'user' => $user
        ], 201);
    }

    public function registerProvider(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $input = $request->all();

        if ($picture = $request->file('picture')) {
            $destinationPath = 'gallery_users/';
            $imageName = date('ymdhis') . "." . $picture->getClientOriginalExtension();
            $picture->move($destinationPath, $imageName);
            $input['picture'] = $imageName;
        }

        $user = User::create(array_merge(
            $request->all(),
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['role' => 3],
            ['picture' => $imageName]
        ));
        return response()->json([
            'message' => 'Provider successfully registered',
            'user' => $user
        ], 201);
    }


    public function verifyEmailCode(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $verifymail = verifyMail::with('user')->where('token', '=', $request->token)->first();

        $user = User::where('email', '=', $request->email)->first();

        if ($verifymail) {
            if ($verifymail->expire_at < now()) {
                $verifymail->delete();
                return response()->json(['message' => 'Invalid OTP1'], 403);
            } else {
                if ($verifymail->user->email == $request->email) {
                    $user->update(['email_verified' => 0]);
                    $user->increment('id', 0, array('email_verified_at' => Carbon::now()));
                    return response()->json(['message' => 'Valid'], 200);
                } else {
                    return response()->json(['message' => 'unauthorized'], 403);
                }
            }
        } else {
            return response()->json(['message' => 'Invalid OTP2'], 403);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(Auth::refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 * 24,
            'user' => auth()->user()
        ]);
    }
}
