<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Presentation\Controllers\Rpc\RpcAdapter as AuthRpcAdapter;
use App\Contexts\MobileAppBack\Application\Commands\Customer\RegisterCustomer;
use App\Contexts\MobileAppBack\Application\Exceptions\ServiceException;

class CustomerCommandService
{
    public function __construct(
        private AuthRpcAdapter $authRpcAdapter,
    ) {
    }

    public function register(RegisterCustomer $command)
    {
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $result = $this->authRpcAdapter->registerUser($command->email, $command->phone, $command->name, $command->password);
        if (!$result->isOk()) {
            throw new ServiceException("Unable to register user");
        }
    }
}

