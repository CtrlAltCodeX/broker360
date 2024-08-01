<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ContactRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash as FlashFlash;

class ContactsController extends AppBaseController
{
    /** @var ContactRepository $contactsRepository*/

    public function __construct(
        public ContactRepository $contactsRepository,
        public UserRepository $userRepository
    ) {
    }

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $contacts = $this->contactsRepository->paginate(10);

        return view('admin.contacts.index')
            ->with('contacts', $contacts);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $users = $this->userRepository->all();

        return view('admin.contacts.create', compact('users'));
    }

    /**
     * Store a newly created User in storage.
     */
    public function store()
    {
        $input = request()->all();

        $this->contactsRepository->create($input);

        FlashFlash::success('Contact saved successfully.');

        return redirect(route('admin.contacts.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $contact = $this->contactsRepository->with('user')->find($id);

        if (empty($contact)) {
            FlashFlash::error('Contact not found');

            return redirect(route('contacts.index'));
        }

        return view('admin.contacts.view')->with('contact', $contact);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $contact = $this->contactsRepository->find($id);

        $users = $this->userRepository->all();

        if (empty($contact)) {
            FlashFlash::error('Contact not found');

            return redirect(route('admin.contacts.index'));
        }

        return view('admin.contacts.edit')->with('contact', $contact)->with('users', $users);
    }

    /**
     * Update the specified User in storage.
     */
    public function update($id)
    {
        $user = $this->contactsRepository->find($id);

        if (empty($user)) {
            FlashFlash::error('Contact not found');

            return redirect(route('admin.contacts.index'));
        }

        $user = $this->contactsRepository->update(request()->all(), $id);

        FlashFlash::success('Contact updated successfully.');

        return redirect(route('admin.contacts.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = $this->contactsRepository->find($id);

        if (empty($user)) {
            FlashFlash::error('Contact not found');

            return redirect(route('contacts.index'));
        }

        $this->contactsRepository->delete($id);

        FlashFlash::success('Contact deleted successfully.');

        return redirect(route('admin.contacts.index'));
    }
}
