namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse;

class CustomLoginViewResponse implements LoginViewResponse
{
    public function toResponse($request)
    {
        // ログインビューのレスポンス処理
        return response()->view('auth.login');
    }
}