<?php

namespace App\Components\CoreComponent\Modules\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
 * Author: Raksa Eng
 */
class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::paginate();
        return $this->view('index', [
            'clients' => $clients,
        ]);
    }
    public function create(Request $request)
    {
        return $this->view('create');
    }
    public function store(Request $request)
    {
        $client = new Client();
        $client->fill($request->except('_token'));
        if ($client->save()) {
            return redirect()->route('clients.index')->withSuccess('new client have been created');
        }
        return back()->withError("new client can't be created")->withInput();
    }
    public function show(Request $request, $id)
    {
        $client = Client::find($id);
        return $this->view('show', [
            'client' => $client,
        ]);
    }
    public function edit(Request $request, $id)
    {
        $client = Client::find($id);
        return $this->view('edit', [
            'client' => $client,
        ]);
    }
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->fill($request->all());
        if ($client->save()) {
            return redirect()->route('clients.index')->withSuccess('client have been updated');
        }
        return back()->withError("client can't be updated")->withInput();
    }
    public function destroy(Request $request, $id)
    {
        $client = Client::find($id);
        if ($client->delete()) {
            return redirect()->route('clients.index')->withSuccess('client have been deleted');
        }
        return back()->withError("client can't be deleted");
    }
}
