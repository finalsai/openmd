<?php

namespace App\Admin\Actions\Grid;

use App\Models\Content;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class EncryptSupport extends RowAction
{
    /**
     * @return string
     */
	protected $title = 'Upgrade:Encrypt';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $content = Content::find($this->getKey());
        $edit = $content->edit_token;
        $content->edit_token = Hash::make($edit);
        $content->markdown = Crypt::encryptString($content->markdown);
        if ($content->access_token) {
            $crypter = new Encrypter(substr(hash('sha256', $content->access_token), -32), 'aes-256-gcm');
            $content->markdown = $crypter->encryptString($content->markdown);
            $content->access_token = Hash::make($content->access_token);
        }

        $content->saveOrFail();

        return $this->response()
            ->success('Encrypted')
            ->refresh();
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		// return ['Confirm?', 'contents'];
	}

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
