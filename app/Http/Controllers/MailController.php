<?php

namespace App\Http\Controllers;

use App\Repositories\MailRepository;

class MailController extends AppBaseController
{

    public function __construct(
        public MailRepository $mailRepository
    ) {}

    /**
     * Send a success response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mails = $this->mailRepository->all();

        return view('admin.mail.index', compact('mails'));
    }

    /**
     * Delete mail
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $this->mailRepository->find($id)
            ->delete();

        return redirect()->route('admin.mail.index');
    }
}
