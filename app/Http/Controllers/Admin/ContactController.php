<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;
use App\Model\Contact;

class ContactController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::paginate($this->itemsPerPage);
        return view('admin.contact.list')->with(['contacts' => $contacts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        $name = $request->get('name');
        $company = $request->get('company');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $districtId = $request->get('district');
        Contact::create([
            'name' => $name,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'district_id' => $districtId,
        ]);
        return response()->redirectToRoute('contact.index');
    }

    public function update(UpdateContactRequest $request, Contact $contact){
        $name = $request->get('name');
        $company = $request->get('company');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $districtId = $request->get('district');
        $contact->update([
            'name' => $name,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'district_id' => $districtId,
        ]);
        return response()->redirectToRoute('contact.index');
    }

}
