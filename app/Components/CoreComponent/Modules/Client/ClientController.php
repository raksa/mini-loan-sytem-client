<?php

namespace App\Components\CoreComponent\Modules\Client;

use App\Components\CoreComponent\Modules\Loan\Loan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/*
 * Author: Raksa Eng
 */
class ClientController extends Controller
{
    protected function getRequiredData()
    {
        return [
            'loanModelClass' => Loan::class,
            'clientModelClass' => Client::class,
        ];
    }

    public function index(Request $request)
    {
        $this->authorize('view', Client::class);
        $clients = Client::paginate();
        return $this->view('index', [
            'clients' => $clients,
        ], $this->getRequiredData());
    }
    public function create(Request $request)
    {
        $this->authorize('create', Client::class);
        return $this->view('create', $this->getRequiredData());
    }
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);
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
        $this->authorize('view', Client::class);
        return $this->view('show', [
            'client' => $client,
        ], $this->getRequiredData());
    }
    public function edit(Request $request, $id)
    {
        $client = Client::find($id);
        $this->authorize('update', $client);
        return $this->view('edit', [
            'client' => $client,
        ], $this->getRequiredData());
    }
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $this->authorize('update', $client);
        $client->fill($request->all());
        if ($client->save()) {
            return redirect()->route('clients.index')->withSuccess('client have been updated');
        }
        return back()->withError("client can't be updated")->withInput();
    }
    public function destroy(Request $request, $id)
    {
        $client = Client::find($id);
        $this->authorize('delete', $client);
        if ($client->delete()) {
            return redirect()->route('clients.index')->withSuccess('client have been deleted');
        }
        return back()->withError("client can't be deleted");
    }
}
