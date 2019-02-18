<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Services\ClientService;

class ClientController extends BaseController
{
    /**
     * List all clients
     */
    public function clientList(
        Request $request,
        ClientService $clientService
    ) {
        $this->validate($request, [
            'serialNo'  => 'serial_no',
            'page'      => 'integer|min:1|max:1000',
            'size'      => 'integer|min:1|max:100',
        ]);

        $page = (int) $request->query->get('page', 1);
        $res = $clientService->listAllClients(
            $request->query->get('serialNo'),
            $page,
            (int) $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.clientList', [
            'clients'       => $res->clients,
            'page'          => $page >= $res->totalPages ? $res->totalPages : $page,
            'totalPages'    => $res->totalPages,
        ]);
    }


    /**
     * Show create new client form
     */
    public function showCreateNewClientForm()
    {
        return view('admin.createNewClientForm');
    }


    /**
     * Create new client form
     */
    public function createNewClient(
        Request $request,
        ClientService $clientService
    ) {
        $this->validate($request, [
            'serialNo'  => 'required|serial_no',
        ], [
            'serialNo.*'    => '软件号未填写或格式错误',
        ]);

        $clientService->createNewClient(
            $request->request->get('serialNo')
        );

        return redirect()->route('admin.dashboard');
    }


    /**
     * Show client form
     *
     * @param string $clientId
     */
    public function showEditClientForm(
        Request $request,
        ClientService $clientService,
        string $clientId
    ) {
        $request->query->set('clientId', $clientId);
        $this->validate($request, [
            'clientId'  => 'required|uuid',
            'page'      => 'integer|min:1|max:1000',
            'size'      => 'integer|min:1|max:100',
        ]);

        $page = (int) $request->query->get('page', 1);
        $client = $clientService->getClient($request->query->get('clientId'));
        $histories = $clientService->listClientAuthorizationHistories(
            $request->query->get('clientId'),
            $page,
            $request->query->get('size', $this->defaultPageSize)
        );

        return view('admin.editClientForm', [
            'client'    => $client,
            'histories' => $histories,
            'page'      => $page >= $histories->totalPages ? $histories->totalPages : $page,
        ]);
    }


    /**
     * Edit client
     */
    public function editClient(
        Request $request,
        ClientService $clientService,
        string $clientId
    ) {
        $request->request->set('clientId', $clientId);
        $this->validate($request, [
            'clientId'      => 'required|uuid',
            'clientName'    => 'string|nullable|max:12',
        ], [
            'clientName.max'    => '客户名最多不能超过12个字符', 
        ]);

        $clientService->editClient(
            $clientId,
            $request->request->get('clientName', '')
        );

        return back();
    }


    /**
     * Authorize client
     */
    public function authorizeClient(
        Request $request,
        ClientService $clientService,
        string $clientId
    ) {
        $request->request->set('clientId', $clientId);
        $this->validate($request, [
            'clientId'      => 'required|uuid',
            'authEndDate'   => 'required|date_format:Y-m-d',
            'comment'       => 'string|nullable|max:128',
        ], [
            'authEndDate.*' => '授权截止日期未填写或格式错误',
            'comment.max'   => '授权备注最多不能超过128个字符',
        ]);

        $clientService->authorizeClient(
            $clientId,
            Carbon::parse($request->request->get('authEndDate')),
            $request->request->get('comment')
        );

        return back();
    }
}
