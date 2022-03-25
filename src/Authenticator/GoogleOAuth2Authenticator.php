<?php
namespace App\Authenticator;

use App\Core\UserCache;
use App\Libs\ConfigUtil;
use Cake\Core\Configure;
use Psr\Http\Message\ResponseInterface;
use Authentication\Authenticator\Result;
use Psr\Http\Message\ServerRequestInterface;
use Authentication\Authenticator\ResultInterface;
use Authentication\Authenticator\PersistenceInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Authentication\Authenticator\AbstractAuthenticator;

/**
 * Authenticator using ```google_auth``` session information
 *
 */
class GoogleOAuth2Authenticator extends AbstractAuthenticator implements PersistenceInterface
{
	public function authenticate(ServerRequestInterface $request): ResultInterface {
		$user = [];
		// must write logics here due to bug related to namespace of ```Google_Client class```
		$session = $request->getSession();
		$session->read();
		require __DIR__.'/google/getUserInfo.php'; 
		if (!empty($user)) {
			return new Result($user, Result::SUCCESS);
		}

		// No auth data = not authenticated
		return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND);
	}

	public function clearIdentity(ServerRequestInterface $request, ResponseInterface $response): array {
		$session = $request->getSession();
		$session->read();
		$session->delete('google_auth');

		return [
            'request' => $request,
            'response' => $response,
        ];
	}

	public function persistIdentity(ServerRequestInterface $request, ResponseInterface $response, $identity): array {
		return [
            'request' => $request,
            'response' => $response,
        ];
	}
}
