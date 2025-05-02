<?php

declare(strict_types=1);

namespace App\Repositories\Auth;

// Model
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\UserDeviceDetails;

// Exception
use App\Exceptions\Auth\UserNotFoundException;
use App\Exceptions\Auth\InvalidEmailException;
use App\Exceptions\Auth\InvalidTokenException;
use App\Exceptions\Auth\TokenExpiredException;

// Resource
use App\Http\Resources\Admin\UserResource;

// Others
use Carbon\Carbon;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * @var $model
    */
    protected $model;

    /**
     * @var $carbon
    */
    protected $carbon;

    /**
     *
     * @method __construct
     *
     * @param User $user, Carbon $carbon
    */
    public function __construct(User $model, Carbon $carbon, UserDeviceDetails $deviceDetails)
    {
        $this->model = $model;
        $this->carbon = $carbon;
        $this->userDeviceDetails = $deviceDetails;
    }

    /**
     * Attempt authentication
     *
     * @method attempt
     *
     * @param array $request
     *
     * @return bool
     *
    */
    public function attempt(array $request): bool
    {
        $credential = array('email' => $request['email'],'password' => $request['password']);
        $result = auth()->attempt($credential);
        if (!$result) {
            throw new UserNotFoundException();
        }
        return true;
    }

    /**
     * Create user auth token
     *
     * @method token
     *
     * @return string
     *
     */
    public function createAccessToken(object $user): string
    {
        $tokenResult = $user->createToken('access_token'); // create access token
        $accessToken = $tokenResult->accessToken;
        $token = $tokenResult->token;
        $token->expires_at = now()->addDays(config('constants.TOKEN_EXPIRY')); // set expiration
        $token->save();
        return $accessToken;
    }

    /**
     * Create user password token
     *
     * @method createPasswordToken
     *
     * @param object $user
     *
     * @return string
     *
     */
    public function createPasswordToken(object $user): string
    {
        $token = str_random(60);
        $user->reset_password_token = $token;
        $user->reset_password_token_expires_at = now(config('constants.TOKEN_EXPIRY'))->addHours(24);
        $user->reset_password_email_sent_at = now(config('constants.TOKEN_EXPIRY'));
        $user->save();
        return $token;
    }

    /**
    * Create new record
    *
    * @method store
    *
    * @param  array $request
    *
    * @return App\Models\User
    *
    */
    public function store(array $request): ?User
    {
        $request = array_except($request, ['role']);
        $request['password'] = bcrypt($request['password']);
        $request['remember_token'] = str_random(10);
        return $this->model->create($request);
    }
    
    /**
    * Check password token expired
    *
    * @method isPasswordTokenExpired
    *
    * @param object $user
    *
    * @return void
    *
    */
    public function isPasswordTokenExpired(object $user): void
    {
        $expireAt = $this->carbon->parse($user->reset_password_token_expires_at);
        if ($expireAt->lessThan(now(config('constants.country')))) {
            throw new TokenExpiredException();
        }
    }

    /**
    * Update password
    *
    * @method updatePassword
    *
    * @param object $user
    *
    * @return void
    *
    */
    public function updatePassword(object $user, array $request): void
    {
        $user->password = bcrypt($request['new_password']);
        $user->save();
    }

    /**
    * Find user by email
    *
    * @method findByEmail
    *
    * @param  string  $email [string]
    *
    * @return App\Models\User
    */
    public function findByEmail(string $email): ?User
    {
        $user = $this->model->where('email', $email)->first();
        if (!$user) {
            throw new InvalidEmailException();
        }
        return $user;
    }

    /**
    * Find user by token
    *
    * @method findByToken
    *
    * @param  string  $token [string]
    *
    * @return App\Models\User
    */
    public function findByToken(string $token): ?User
    {
        $user = $this->model->where('reset_password_token', $token)->first();
        if (!$user) {
            throw new InvalidTokenException();
        }
        return $user;
    }

    /**
    * Process objects
    *
    * @method process
    *
    * @return object
    *
    */
    public function process(object $data, bool $collection = false): ?object
    {
        if ($collection) {
            return UserResource::collection($data);
        }
        return new UserResource($data);
    }

    /**
    * Return observer
    *
    * @method observe
    *
    * @return App\Models\User
    *
    */
    public function observe(string $class): ?User
    {
        return $this->model->observe($class);
    }
    
    public function validateUser(object $user,string $type): bool
    {
        // dd($user::with('roles')->pluck('name')->toArray());
        
        $roles = Role::all()->pluck('name')->toArray();
        // dd($roles);
        if (!$roles || ($type!=='admin' && $type!=='business' && $type!=='superadmin')) {
            throw new UserNotFoundException();
        }
        
        if($type=='superadmin' && !in_array('superadmin', $roles)){
            throw new UserNotFoundException();
        }

        if($type=='admin' && !in_array('admin', $roles)){
            throw new UserNotFoundException();
        }

        if($type=='business' && !in_array('business', $roles)) {
            throw new UserNotFoundException();
        }
        return true;
    }

    public function createTemporaryPassword(string $email): string
    {
        $password = uniqid();
        $bcrypt_pass = bcrypt($password);
        $this->model->where('email', $email)
        ->update(["password" => $bcrypt_pass,"is_temp" => false]);
        return $password;
    }

    /**
     * Find record by device details and userId
     *
     * @method checkUserDeviceTokenExists
     *
     * @param  array $deviceDetails
     * @return int
     *
    */

    public function checkUserDeviceTokenExists(array $deviceDetails): ?int
    {
        return $this->userDeviceDetails->where($deviceDetails)->count();
    }

    /**
     * delete record by userId
     *
     * @method destroyDeviceTokensByUserId
     *
     * @param  int $userId
     * @return int
     *
    */

    public function destroyDeviceTokensByUserId(int $userId): ?int
    {
        return $this->userDeviceDetails->where('user_id', $userId)->delete();
    }

    /**
    * Create new device details record
    *
    * @method storeDeviceDetails
    *
    * @param  array $request
    * @return App\Models\UserDeviceDetails
    *
    */
    public function storeDeviceDetails(array $request): ?UserDeviceDetails
    {
        $request['created_at'] = now(config('constants.TIME_ZONE'));
        $request['created_by'] = $request['user_id'];

        return $this->userDeviceDetails->create($request);
    }
}
