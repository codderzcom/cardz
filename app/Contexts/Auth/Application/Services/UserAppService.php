<?php

namespace App\Contexts\Auth\Application\Services;

use App\Contexts\Auth\Application\Contracts\UserRepositoryInterface;
use App\Contexts\Auth\Application\IntegrationEvents\RegistrationInitiated;
use App\Contexts\Auth\Application\IntegrationEvents\TokenGenerated;
use App\Contexts\Auth\Application\IntegrationEvents\UserNameProvided;
use App\Contexts\Auth\Domain\Model\User\Profile;
use App\Contexts\Auth\Domain\Model\User\User;
use App\Contexts\Auth\Domain\Model\User\UserId;
use App\Contexts\Auth\Domain\Model\User\UserIdentity;
use App\Contexts\Auth\Domain\ReadModel\Token;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Exceptions\ParameterAssertionException;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class UserAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function register(string $name, string $password, ?string $email, ?string $phone): ServiceResultInterface
    {
        try {
            $userIdentity = UserIdentity::of($email, $phone);
        } catch (ParameterAssertionException) {
            return $this->serviceResultFactory->violation("Email or Phone required");
        }

        $user = $this->userRepository->takeWithIdentity($userIdentity);
        if ($user !== null) {
            return $this->serviceResultFactory->violation("User {$user->userId} possesses provided identity");
        }

        $user = User::make(UserId::make(), $userIdentity);
        $user->initiateRegistration(Hash::make($password));
        $user->provideProfile(Profile::of($name));
        $this->userRepository->persist($user);

        $result = $this->serviceResultFactory->ok($user, new RegistrationInitiated($user->userId), new UserNameProvided($user->userId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function getToken(string $identity, string $password, string $deviceName): ServiceResultInterface
    {
        $eloquentUser = EloquentUser::query()
            ->where('email', '=', $identity)
            ->orWhere('phone', '=', $identity)
            ->first();
        if (!$eloquentUser) {
            return $this->serviceResultFactory->notFound("User $identity not found");
        }

        if (!Hash::check($password, $eloquentUser->password)) {
            return $this->serviceResultFactory->violation("Invalid credentials");
        }

        $token = $eloquentUser->createToken($deviceName)->plainTextToken;
        $result = $this->serviceResultFactory->ok(
            new Token($eloquentUser->id, $token),
            new TokenGenerated($eloquentUser->id)
        );

        return $this->reportResult($result, $this->reportingBus);
    }
}
