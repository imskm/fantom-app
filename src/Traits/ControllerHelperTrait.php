<?php

namespace Application\Traits;

use App\Config;
use Fantom\Log\Log;
use Fantom\Session;
use App\Models\User;
use App\Support\Upload;
use App\Support\ImageUploader;
use App\Support\Authentication\Auth;
use App\Support\Authentication\AdminAuth;
use App\IndianAirServices\Validations\UserDocumentValidator;
trait ControllerHelperTrait
{
	private function redirectIfGetParamHasNoId()
	{
		if (!isset($this->route_params['id'])) {
			Session::flash('error', 'Id is missing.');
			redirect($this->_redirect_to_index);
		}
	}

	private function redirectIfRouteParamHasNoSlug()
	{
		if (!isset($this->route_params['slug'])) {
			Session::flash('error', 'Slug is missing.');
			redirect($this->_redirect_to_index);
		}
	}

	private function buildFilterParams()
	{
		$filter = [];

		if (isset($_GET['sort']) && !empty($_GET['sort'])) {
			$filter['sort'] = ['field' => 'id', 'value' => strtolower($_GET['sort']) == 'asc' ? 'ASC' : 'DESC', 'op' => null];
		}
		if (isset($_GET['status']) && !empty($_GET['status'])) {
			$filter['status'] = ['field' => 'status', 'value' => $_GET['status'], 'op' => '='];
		}
		if (isset($_GET['from']) && !empty($_GET['from'])) {
			$from = date("Y-m-d 00:00:00", strtotime($_GET['from']));
			$filter['from'] = ['field' => 'created_at', 'value' => $from, 'op' => '>='];
		}
		if (isset($_GET['to']) && !empty($_GET['to'])) {
			$to = date("Y-m-d 23:59:59", strtotime($_GET['to']));;
			$filter['to'] = ['field' => 'created_at', 'value' => $to, 'op' => '<='];
		}

		return $filter;
	}

	private function uploadCandidateDocument(User $user)
	{
		$v = new UserDocumentValidator();
		$v->validateProofUpload();
		if ($v->hasError()) {
			return false;
		}

		// @TODO Allow upload only before account has not been locked
		// in a state after which changing doc is not allowed.
		// For example after document verification not changes are
		// allowed to user.

		// Upload the document/image
		$file = null;
		$destination = ROOT . '/public/uploads';
		$ispdf = $_POST['document'] === 'resume';
		if ($ispdf) {
			// Upload PDF
			$file = new Upload($destination);
			$gen_filename = gen_file_name().".pdf";
			$file->setFileName($gen_filename);
			if ($file->upload() === false) {
				Log::error("Failed to upload resume PDF file: ".serialize($file->getMessage()));
				Session::flash("error", "Failed to upload document, try later");
				return false;
			}
		} else {
			// Upload Image
			$file = new ImageUploader($destination);
			if ($file->save('file') === false) {
				Session::flash("error", "Failed to upload document, try later");
				return false;
			}
		}

		$filename 			= $file->getSavedFileNames()[0];
		$_POST['user_id'] 	= $user->id;
		$user_info 			= $user->userInfos();
		$user_info->updateDocument($_POST, $_POST['document'], $filename);

		if ($user_info->save() === false) {
			// Delete uploaded file
			unlink("$destination/$filename");
			Log::error("Faield to upload document: user_id={$user->id}");
			Session::flash("error", "Failed to store document");
		}

		// @TODO Delete Old file

		Session::flash("success", "Document successfully uploaded");
		return true;
	}

	private function generateAccountSetupLink(string $token): string
	{
		$site = Config::get("site_url");

		return "{$site}/user/account-setup/password?token={$token}";
	}

}